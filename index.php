<!DOCTYPE html>
<?php
require_once 'DBConnection.php';
$Name = "";
$Surname = "";
$IDNumber = "";
$DOB = "";
$errorM = "";
$SuccessM="";


if (isset($_POST['nameInput'])) {
    $Name = $_POST['nameInput'];
}
if (isset($_POST['SurnameInput'])) {
    $Surname = $_POST['SurnameInput'];
}
if (isset($_POST['IDInput'])) {
    $IDNumber = $_POST['IDInput'];
}
if (isset($_POST['DOBInput'])) {
    $DOB = $_POST['DOBInput'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql2 = "SELECT `IDNo` FROM `informationtbl` WHERE `IDNo` = '{$IDNumber}'";

    $IDV = mysqli_query($Connection, $sql2)or die(mysql_error());
    if (mysqli_affected_rows($Connection) == 0) {
        print_r($DOB);
        //$DOB = $Day."/".$month."/".$year;
        
        $sql = "INSERT INTO `informationtbl`(`Name`, `Surname`, `IDNo`, `DateOfBirth`) VALUES ('{$Name}','{$Surname}','{$IDNumber}','{$DOB}')";
        
        mysqli_query($Connection, $sql) or die(mysqli_error($Connection)."Error adding to database");

        $_POST = array();
        $Name = $Surname = $IDNumber = $DOB = "";
        $SuccessM="data added to the database";
    } else {
        $errorM = " <---ID Number Error please try again";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Input Form</title>
        <style>
            label{display:inline-block;width:100px;margin-bottom:10px;}
        </style>
    </head>
    <body>
        <form name="Info" method="POST" action="index.php">

            <div>
                <label>Name</label></br>
                <input type="text" name="nameInput" pattern="[A-Za-z]+" required autocomplete="off" value="<?php echo htmlentities($Name) ?>" >
            </div>

            <div>
                <label>Surname</label></br>
                <input type="text" name="SurnameInput" pattern="[A-Za-z]+" required autocomplete="off" value="<?php echo htmlentities($Surname) ?>">
            </div>

            <div>
                <label >ID Number</label></br>
                <input type="text" name="IDInput" pattern="[0-9]{13}" required autocomplete="off" ><?php echo $errorM; ?>
            </div>

            <div>
                <label>Date Of birth</label></br>
                <input type="date" name="DOBInput"  required autocomplete="off" value="<?php echo htmlentities($DOB) ?>">
            </div>

            </br>
            <button type="submit" name="PostButton">Post</button>
            <button type="reset" name="CancelButton" >Cancel</button>
        </form>
<?php echo "</br>".$SuccessM;?>
    </body>


</html>
