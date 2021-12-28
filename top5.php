<?php 
    require_once ('jpgraph/jpgraph.php');
    require_once ('jpgraph/jpgraph_bar.php');
    include('connectDB.php');

    session_start();
    $user_id = $_SESSION['user_id'];
    
    $project_id = mysqli_fetch_assoc($link -> queryExec("SELECT idProject FROM projects
    WHERE idUser = '$user_id';"))['idProject'];


    $query = "SELECT concat(firstname, \" \", lastname) as full_name, investmentFund  FROM `projects_investors`
    JOIN users
    USING (idUser)
    where idProject='$project_id'
    ORDER BY investmentFund desc LIMIT 5;";
    
    $top5 = $link -> queryExec($query);

    $datay=array();
    $datax=array();

    while($row = mysqli_fetch_assoc($top5)){
        $datax[] = $row['full_name'];
        $datay[] = $row['investmentFund'];
    }
    
    // Create the graph. These two calls are always required
    $graph = new Graph(700,500);
    $graph->SetScale('textlin');
    
    // Add a drop shadow
    $graph->SetShadow();
    
    // Adjust the margin a bit to make more room for titles
    $graph->SetMargin(40,30,20,40);

    $graph->xaxis->SetTickLabels($datax);

    
    // Create a bar pot
    $bplot = new BarPlot($datay);
    
    // Adjust fill color
    $bplot->SetFillColor('orange');
    $graph->Add($bplot);
    
    // Setup the titles
    $graph->title->Set('Top 5 most invested users');
    $graph->xaxis->title->Set('Full Names');
    $graph->yaxis->title->Set('Investments');
    
    $graph->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
    
    // Display the graph
    $graph->Stroke();
?>
