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
        <title> League Database </title>
        <link rel="stylesheet" href="main.css">
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





        <!-- DISPLAYING SUPPORT AND BOT META -->
                    
        <div class="center">
            <div class="navbar">

            <form method="POST" class="outerform">
                <div class="innderform">
                    <h2>Custom Support and Bottom Meta Picks</h2>
                </div>

                <div class="innderform">

                    <select name="AddOrDel">
                        <option value="Add">Add</option>
                        <option value="Delete">Delete</option>
                    </select>
                    <input type="submit">

                    <?php
    // Assuming $con is your database connection

    if (isset($_POST["AddOrDel"])) {
        $tempOption = $_POST["AddOrDel"];

        // HANDLE ADD SELECT
        if ($tempOption == "Add") {

             //CREATE SUPP SELECTION
             $supps = mysqli_query($con, "SELECT DISTINCT Champ FROM ChampionList WHERE Pref_role='Support';");
                
             echo '<select name="SuppSelect">';
             echo '<option value="DEFAULT">no selection</option>';   
             while($supp = mysqli_fetch_array($supps)){
                 echo '<option value="' . $supp['Champ'] . '">' . $supp['Champ'] . '</option>';   
             }
             echo '</select>';
             mysqli_free_result($supps);


             //CREATE BOT SELECTION
             $bots = mysqli_query($con, "SELECT DISTINCT Champ FROM ChampionList WHERE Pref_role='Bottom';");

             echo '<select name="BotSelect">';
             echo '<option value="DEFAULT">no selection</option>';   
             while($bot = mysqli_fetch_array($bots)){
                 echo '<option value="' . $bot['Champ'] . '">' . $bot['Champ'] . '</option>';   
             }
             echo '</select>';
             echo '<input type="submit">';
             mysqli_free_result($bots);
        }

        // HANDLE DELETE SELECT
        if ($tempOption == "Delete") {

              //CREATE DELETE SELECTION
              $listcombos = mysqli_query($con , "SELECT * FROM SupportBottomPairing;");

              echo '<form method="POST">'; // Adding a form to submit combo selection
              echo '<select name="ComboSelect">';
              echo '<option value="DEFAULT">no selection</option>'; 
              while($listcombo = mysqli_fetch_array($listcombos)){
                  echo '<option value="' . $listcombo['id'] . '">' . $listcombo['Support'] . ' , ' . $listcombo['Bottom'] . '</option>';    
              }
              echo '</select>';
              echo '<input type="submit" name="deleteCombo" value="Delete Combo">';
              echo '</form>';
              mysqli_free_result($listcombos);

        }
    }

    // HANDLE ADD COMBO
    if (isset($_POST["BotSelect"])) {
        $tempSupp = $_POST["SuppSelect"];
        $tempBot = $_POST["BotSelect"];

        if($tempBot !== "DEFAULT" and $tempSupp !== "DEFAULT"){
            $toInsert = "INSERT INTO SupportBottomPairing (Support, Bottom) VALUES ('$tempSupp', '$tempBot')"; 
            mysqli_query($con, $toInsert);
        }
    }

    // HANDLE DELETE COMBO
    if (isset($_POST["deleteCombo"])) {
        $tempId = $_POST["ComboSelect"];

        if($tempId != "DEFAULT"){
            $toDelete = "DELETE FROM SupportBottomPairing WHERE id='$tempId'";
            mysqli_query($con, $toDelete);
        }
    }
?>


                
                </div>
            </div>
            </form>
        </div>

        </div>


        </div>




        <!-- DISPLAYING FOUND DATA FROM SupportBottomPairing -->
        <div class="center">   
                    <?php

                    $suppBot_sql = "SELECT Support, Bottom FROM SupportBottomPairing;";
                    $combodata = mysqli_query($con, $suppBot_sql);
                    
                    echo '<div class="myitems">
                        <div class="item"><h2>Support</h2></div>
                        <div class="item"><h2>Bottom</h2></div>
                    </div>
                    <div class="mycontainer">';

                    while($combos = mysqli_fetch_array($combodata)){
                    echo '<div class="myitems">';

                    echo '<div class="item">';
                    echo $combos['Support'];
                    echo '</div>';

                    echo '<div class="item">';
                    echo $combos['Bottom'];
                    echo '</div>';
            
                    echo '</div>';   
                    }
                    
                    mysqli_free_result($combodata);

                    ?>
            </div>
        <div>


        
    </body>

</html>