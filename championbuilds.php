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
        <title> Champion Builds </title>
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="home.css">
    </head>
    <body>

         <!-- GETTING INFO FOR ITEM BUILDS BY SEARCH -->
        
         <div class="center">

            <div class="navbar">
                <form method="POST" class="outerform">
                <h2>Item Builds by Champion</h2>
                    <div class="innderform">
                        Find Champion by name
                        <input type="text" name="champBuild">
                    </div>
                </form>

                <?php

                    if(isset($_POST["champBuild"])){
                        $tempBuild = $_POST["champBuild"];
                        if($tempBuild != ""){    
                            echo $tempBuild;
                        }
                    }else {$tempBuild = '';}

                ?>


            </div>

            </div>

            <div class="center">

            <?php

                echo '<div class="myitems">';

                    echo '<div class="item">';
                    echo $tempBuild;
                    echo '</div>';
                    
                echo '</div>';

            ?>

            </div>



        <!-- BACK BUTTON -->

        <div class="center">

                <div class="homebutton">
                    <a class="link" href="index.php" style="color: grey; min-height: auto;"> Home </a>
                </div>

        </div>

    </body>

</html> 