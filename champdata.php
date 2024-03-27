<!DOCTYPE html>

<!--    FIX MARGIN AND PADDING SPACING WHEN DIFFERENT SELECTIONS    -->

<?php
    $con = mysqli_connect("localhost", "lol_user", "IFeedBotLane", "lol_database");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $sql_statement_basic = "SELECT Champ, Pref_role, Job, AP_AD FROM ChampionList";
    $result = '';

    if(isset($_POST["champName"])){
        $tempName = $_POST["champName"];
        if($tempName != "default"){    

            // QUERY BASIC DATA
            $sql_statement_basic = $sql_statement_basic . " WHERE Champ='$tempName'";
            $result = mysqli_query($con, $sql_statement_basic);

            // QUERY BUILD/ITEM DATA
            $buildData = mysqli_query($con, "SELECT First_Item, Second_Item, Third_Item FROM ChampionBuild WHERE Champ='$tempName'");
            

            // QUERY BOT/SUPPORT PAIRS
            $botPairs = mysqli_query($con,"SELECT Bottom FROM SupportBottomPairing WHERE Support='$tempName'");
            $supPairs = mysqli_query($con,"SELECT Support FROM SupportBottomPairing WHERE Bottom='$tempName'");

        }
    }
?>

<html>
    <head>
        <title> Champion Data </title>
        <link rel="stylesheet" href="css/main.css">
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


        


        <!-- DISPLAYING FOUND DATA FROM ChampionList -->
        <div class="center">   
                    <?php

                    //  DISPLAYING MAIN ROLE AND BASIC DATA
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


            <span style="margin-top: 50px; height: 20px;"> </span>


            <div class="center">   
                    <?php

                    //  DISPLAYING ITEM BUILDS DATA
                    if($buildData != ''){

                    echo '<div class="myitems">
                        <div class="item"><h2> First Item </h2></div>
                        <div class="item"><h2> Second Item </h2></div>
                        <div class="itemNB"><h2> Third Item </h2></div>
                    </div>
                    <div class="mycontainer">';

                        while($items = mysqli_fetch_array($buildData)){
                        echo '<div class="myitems" style="padding: 5px;">';

                            $url1 = "https://ddragon.leagueoflegends.com/cdn/14.5.1/img/item/";
                            $url1 = $url1 . $items["First_Item"];
                            $url1 = $url1 . ".png";

                            $url2 = "https://ddragon.leagueoflegends.com/cdn/14.5.1/img/item/";
                            $url2 = $url2 . $items["Second_Item"];
                            $url2 = $url2 . ".png";

                            $url3 = "https://ddragon.leagueoflegends.com/cdn/14.5.1/img/item/";
                            $url3 = $url3 . $items["Third_Item"];
                            $url3 = $url3 . ".png";

                        echo '<div class="item">';
                        echo '<img src=' . $url1 . ' alt="Item">';
                        echo '</div>';

                        echo '<div class="item">';
                        echo '<img src=' . $url2 . ' alt="Item">';
                        echo '</div>';

                        echo '<div class="itemNB">';
                        echo '<img src=' . $url3 . ' alt="Item">';
                        echo '</div>';
                        
                    echo '</div>';   
                    }
                    mysqli_free_result($buildData);
                }

                    ?>
            
            </div>


            <span style="margin-top: 50px; height: 20px;"> </span>
            
            <div class="center">   
                    <?php

                    //  DISPLAYING BOT PAIRS AS SUPPORT
                    
                    if(mysqli_num_rows($botPairs)){

                        echo    '<div class="myitems" style="margin-bottom: 10px;">
                        <div class="item"><h2> Pairs well with </h2></div>
                                </div>
                                <div class="myitemsflex" style="display: flex; gap: 10px;">';

                        while($pair = mysqli_fetch_array($botPairs)){

                            $champURL = "https://ddragon.leagueoflegends.com/cdn/14.5.1/img/champion/";
                            $champURL = $champURL . $pair['Bottom'];
                            $champURL = $champURL . ".png";

                        echo '<div class="myitems">';

                        echo '<div class="item">';
                        echo '<img src="' . $champURL . '" alt="Champions" style="padding: 5px;">';
                        echo '</div>';

                    echo '</div>';   
                    }
                    mysqli_free_result($botPairs);
                }

                    ?>
            
            </div>



                    <?php

                    //  DISPLAYING SUPPORT PAIRS AS BOTTOM
                    
                    if(mysqli_num_rows($supPairs)){

                    echo    '<div class="myitems" style="margin-bottom: 10px;">
                                <div class="item"><h2> Pairs well with </h2></div>
                                </div>
                            <div class="myitemsflex" style="display: flex;">';

                        while($pair = mysqli_fetch_array($supPairs)){

                            $champURL = "https://ddragon.leagueoflegends.com/cdn/14.5.1/img/champion/";
                            $champURL = $champURL . $pair['Support'];
                            $champURL = $champURL . ".png";

                        echo '<div class="">';

                        echo '<div class="">';
                        echo '<img src="' . $champURL . '" alt="Champions" style="padding: 5px;">';
                        echo '</div>';

                    echo '</div>';   
                    }
                    mysqli_free_result($supPairs);
                }

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