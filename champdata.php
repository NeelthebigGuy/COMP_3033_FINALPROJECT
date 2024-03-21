<!DOCTYPE html>

<?php
    $con = mysqli_connect("localhost", "lol_user", "IFeedBotLane", "lol_database");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $sql_statement = "SELECT Champ, Pref_role, Job, AP_AD FROM ChampionList";

    if(isset($_POST["champName"])){
        $tempName = $_POST["champName"];
        if($tempName != ""){    
            $sql_statement = $sql_statement . " WHERE Champ='$tempName'";
            $result = mysqli_query($con, $sql_statement);
        }
    }else {$result = '';}

    if(isset($_POST["attSelect"])){
        $tempSelect = $_POST["attSelect"];
    }

?>

<html>
    <head>
        <title> Champion Data </title>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="home.css">
    </head>
    <body>

        <div class="centerPB">

        <div class="navbar">
            <form method="POST" class="outerform">
            <h2>League of Legends Database</h2>
                <div class="innderform">
                    Find Champion by name
                    <input type="text" name="champName">
                </div>

                <div class="innderform">
                    List Chamption by 
                    <select name="attSelect">
                        <option value=""> Hide Champions </option>
                        <option value="Pref_role">Role</option>
                        <option value="Job">Job</option>
                    </select>
                    <input type="submit">
                
                    <?php 
                    
                    if(isset($_POST["attSelect"])){
                        $tempSelect = $_POST["attSelect"];

                        //JOB LIST SELECTION
                        if($tempSelect == "Job"){
                            echo '<select name="jobSelect">';

                            $jobs = mysqli_query($con, "SELECT DISTINCT Job FROM ChampionList;");
                            
                            while($job = mysqli_fetch_array($jobs)){
                                echo '<option value="' . $job['Job'] . '">' . $job['Job'] . '</option>';   
                            }

                            echo '</select>';
                            echo '<input type="submit">';
                            mysqli_free_result($jobs);

                        }
                        
                        //LANE LIST SELECTION
                        if($tempSelect == "Pref_role"){
                            echo '<select name="laneSelect">';

                            $lanes = mysqli_query($con, "SELECT DISTINCT Pref_role FROM ChampionList;");
                            
                            while($lane = mysqli_fetch_array($lanes)){
                                echo '<option value="' . $lane['Pref_role'] . '">' . $lane['Pref_role'] . '</option>';   
                            }

                            echo '</select>';
                            echo '<input type="submit">';
                            mysqli_free_result($lanes);

                        }
                    }

                    //JOB SELECT SUBMIT 
                    if(isset($_POST["jobSelect"])){
                        $tempJob = $_POST["jobSelect"];
                        $sql_statement = $sql_statement . " WHERE Job='" . $tempJob . "'";
                        $result = mysqli_query($con, $sql_statement);
                    }


                    //LANE SELECT
                    if(isset($_POST["laneSelect"])){
                        $tempLane= $_POST["laneSelect"];
                        $sql_statement = $sql_statement . " WHERE Pref_role='" . $tempLane . "'";
                        $result = mysqli_query($con, $sql_statement);
                    }

                    ?>
                
                </div>
            </div>
            </form>
        </div>

        </div>


        </div>


        <!-- DISPLAYING FOUND DATA FROM ChampionList -->
        <div class="center">   
                    <?php

                    if($result != ''){
                    echo '<div class="myitems">
                    <div class="item"><h2> Champion Name </h2></div>
                    <div class="item"><h2> Main Role </h2></div>
                    <div class="item"><h2> Job </h2></div>
                    <div class="itemNB"><h2> AP or AD </h2></div>
                    </div>
                    <div class="mycontainer">';

                    while($row = mysqli_fetch_array($result)){
                    echo '<div class="myitems">';

                    echo '<div class="item">';
                    echo $row['Champ'];
                    echo '</div>';

                    echo '<div class="item">';
                    echo $row['Pref_role'];
                    echo '</div>';

                    echo '<div class="item">';
                    echo $row['Job'];
                    echo '</div>';

                    echo '<div class="itemNB">';
                    echo $row['AP_AD'];
                    echo '</div>';
                    
                    echo '</div>';   
                    }
                    mysqli_free_result($result);
                }
                    ?>
            </div>
        <div>


        <!-- BACK BUTTON -->

        <div class="center">

                <div class="homebutton">
                    <a class="link" href="index.php" style="color: grey; min-height: auto;"> Home </a>
                </div>

        </div

    
        
    </body>

</html>