<?php
    require_once ('jpgraph/jpgraph.php');
    require_once ('jpgraph/jpgraph_pie.php');
    require_once ('jpgraph/jpgraph_pie3d.php');
    include('connectDB.php');

    session_start();
    $project_id = $_SESSION['project_id']; 

    $query = "SELECT SUM(investmentFund) as sum_, requestedFund-SUM(investmentFund) as remaining FROM `projects_investors`
    JOIN projects
    USING (idProject)
    WHERE idProject='$project_id'
    GROUP BY idProject;";
    $result = $link -> queryExec($query);
    $data = array();

    $row = mysqli_fetch_assoc($result);
    $data[] = $row['sum_'];
    $data[] = $row['remaining'];

    // Create the Pie Graph. 
    $graph = new PieGraph(350,300);

    $theme_class= new VividTheme;
    $graph->SetTheme($theme_class);
    
    // Set A title for the plot
    $graph->title->Set("Colected and remaining money");

    // Create
    $p1 = new PiePlot3D($data);

    $p1->SetLegends(array('Collected', 'Remaining'));
    $graph->legend->SetPos(0.5,0.999,'center','bottom');

    $graph->Add($p1);

    $p1->ShowBorder();
    $p1->SetColor('black');
    $p1->ExplodeSlice(1);
    $graph->Stroke();

?>


