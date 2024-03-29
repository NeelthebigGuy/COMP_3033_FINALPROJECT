<!DOCTYPE html>

<?php
    $con = mysqli_connect("localhost", "lol_user", "IFeedBotLane", "lol_database");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $sql_statement = "SELECT Champ, Pref_role, Job, AP_AD FROM ChampionList";
    $result = '';

    if(isset($_POST["champName"])){
        $tempName = $_POST["champName"];
        if($tempName != "default"){    

            // FIND BASIC DATA
            $sql_statement = $sql_statement . " WHERE Champ='$tempName'";
            $result = mysqli_query($con, $sql_statement);

            //FIND ITEM BUILD DATA
            $itemsql = 'SELECT First_Item, Second_Item, Third_Item FROM ChampionBuild';
            $buildResult = '';
        }
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
                    Pick Champion:
                    <select name="champName" onmousedown="if(this.options.length>6){this.size=10;} style='height: 150px; width: 200px'"  onchange='this.size=0; style="position: relative;"' onblur="this.size=0; style='position: relative;'">
                        <option value="default"> Champions </option>
                        <?php
                         $champs = mysqli_query($con, "SELECT DISTINCT Champ FROM ChampionList;");
                
                         while($champ = mysqli_fetch_array($champs)){
                             echo '<option value="' . $champ['Champ'] . '">' . $champ['Champ'] . '</option>';   
                         }
                         mysqli_free_result($champs);
                        ?>
                    </select>
                    <input type="submit">
                </div>

                
            </form>
        </div>

        </div>


        </div>


        <!-- DISPLAYING FOUND DATA FROM ChampionList -->
        <div class="center">   
                    <?php

                    if($result != ''){

                    echo '<div class="champtitle">
                        
                        ' . $tempName . '
                        
                        </div>';

                    echo '<div class="myitems">
                    <div class="item"><h2> Main Role </h2></div>
                    <div class="item"><h2> Job </h2></div>
                    <div class="itemNB"><h2> AP or AD </h2></div>
                    </div>
                    <div class="mycontainer">';

                    while($row = mysqli_fetch_array($result)){
                    echo '<div class="myitems">';

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