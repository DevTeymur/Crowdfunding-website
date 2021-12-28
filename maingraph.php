<?php
    // Include necessary graphs
    include_once("jpgraph/jpgraph.php");
    include_once("jpgraph/jpgraph_bar.php");
    include('connectDB.php');

    // Collecting data
    $query = "SELECT projectName, SUM(investmentFund) as sum_, requestedFund FROM `projects_investors`
    JOIN projects
    USING (idProject)
    GROUP BY idProject;";
    $result = $link -> queryExec($query);
    $datay1 = array();
    $datay2 = array();
    $datay3 = array();

    while($row = mysqli_fetch_assoc($result)){
        $datay1[] = $row['projectName'];
        $datay2[] = $row['requestedFund'];
        $datay3[] = $row['sum_'];
    }

    // Giving properties to graph
    $graph = new Graph(1000,500,'auto');    
    $graph->SetScale("textlin");
    $graph->SetShadow();
    $graph->img->SetMargin(40,30,40,40);
    $graph->xaxis->SetTickLabels($datay1);
    
    $graph->xaxis->title->Set('Projects');
    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
    
    $graph->title->Set('Requested funds and amount of invesments to Projects');
    $graph->title->SetFont(FF_FONT1,FS_BOLD);
    
    $bplot2 = new BarPlot($datay2);
    $bplot3 = new BarPlot($datay3);
    
    $bplot2->SetFillColor("brown");
    $bplot3->SetFillColor("darkgreen");
    
    $bplot2->SetShadow();
    $bplot3->SetShadow();
    
    $bplot2->SetShadow();
    $bplot3->SetShadow();
    
    $gbarplot = new GroupBarPlot(array($bplot2,$bplot3));
    $gbarplot->SetWidth(0.6);
    $graph->Add($gbarplot);
    
    $graph->Stroke();
?>