<!DOCTYPE html>

<?php
    $con = mysqli_connect("localhost", "lol_user", "IFeedBotLane", "lol_database");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $sql_statement = "SELECT Champ, Pref_role, Job, AP_AD FROM ChampionList";
    $result = mysqli_query($con, $sql_statement);
    echo "champs in database: " . mysqli_num_rows($result);

    if(isset($_POST["champName"])){
        $tempName = $_POST["champName"];
        echo $tempName;
    }

    if(isset($_POST["attSelect"])){
        $tempSelect = $_POST["attSelect"];
        echo $tempSelect;
    }

?>

<html>
    <head>
        <link rel="stylesheet" href="css/main.css">
        <title> League Database </title>
    </head>
    <body>

        <div class="navbar">

        <div class="center">
            <form method="POST">
                <div class="myform">
                    Find Champion by name
                    <input type="text" name="champName">
                </div>

                <div class="myform">
                    List Chamption by 
                    <select name="attSelect">
                        <option value=""> See All </option>
                        <option value="Pref_role">Role</option>
                        <option value="Job">Job</option>
                    </select>
                    <input type="submit">
                   
                </div>
                </div>

            </form>
        </div>
        </div>


        </div>


        <!-- DISPLAYING FOUND DATA -->
        <div class="center">
            <div class="myitems">
                <div class="item"><h2> Champion Name </h2></div>
                <div class="item"><h2> Main Role </h2></div>
                <div class="item"><h2> Job </h2></div>
                <div class="item"><h2> AP or AD </h2></div>
                </div>
            <div class="mycontainer">
                    <?php
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

                    echo '<div class="item">';
                    echo $row['AP_AD'];
                    echo '</div>';
                    
                    echo '</div>';   
                    }
                    ?>
            </div>
        <div>
    </body>

</html>