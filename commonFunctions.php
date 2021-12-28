<?php
    include('connectDB.php');
    
    // Checking if user is owner of project or not
    // Return type: True or False
    function isOwner($user_id, $project_id, $link_){
        $res = $link_ -> queryExec("SELECT idUser FROM projects WHERE idUser=\"$user_id\" AND idProject=\"$project_id\";");
        if (mysqli_num_rows($res) == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    // Returns sum of invests to spesific project
    function projectsBudget($project_id, $link_){
        $totalMoney = mysqli_fetch_assoc($link_ -> queryExec("SELECT SUM(investmentFund) totalSum
        FROM projects_investors
        WHERE idProject='$project_id';"))['totalSum'];
        return $totalMoney;
    }

    // Returns information of spesific project
    // Return type: array
    function getProjectDetails($pr_id, $link_){
        $projectDetailsArray = mysqli_fetch_assoc($link_ -> queryExec("SELECT * FROM projects
        WHERE idProject='$pr_id';"));
        return $projectDetailsArray;
    }

    // Checks if user dontaed to certain project or not
    // Return type: True or False
    function hasDonated($user_id, $project_id, $link_){
        $userDonateCheck = $link_ -> queryExec("SELECT * FROM projects_investors
        WHERE idUser='$user_id' AND idProject='$project_id';");
        if(mysqli_num_rows($userDonateCheck)!=0){
            return True;
        } else {
            return False;
        }
    }

    // Checks if project expired or not
    // Return type: True or False
    function expiredProject($project_id, $link_){
        $today = date("Y-m-d");
        $query = mysqli_fetch_assoc($link_ -> queryExec("SELECT projectEndDate FROM projects WHERE idProject='$project_id';"));
        $endDate = $query['projectEndDate'];
        if($endDate<$today){
            return True;
        }else{
            return False;
        }
    }

?>