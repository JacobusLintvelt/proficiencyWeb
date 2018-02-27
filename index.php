<!DOCTYPE html>
<?php
require_once 'DBConnection.php';
$Name = "";
$Surname = "";
$IDNumber = "";
$DOB = "";
$errorM = "";
$SuccessM = "";


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
  
$check2 = FALSE;
$check3 = FALSE;
$check4 = FALSE;
// 1 if name and surname is a string

//2 check if ID number is unique and 13 characters 
$sql2 = "SELECT `IDNo` FROM `informationtbl` WHERE `IDNo` = '{$IDNumber}'";
$IDV = mysqli_query($Connection, $sql2)or die(mysql_error());
if (mysqli_affected_rows($Connection) == 0) {
    $check2 = TRUE;
}
 else {
     $IDNumber= "";
    echo 'ID match error'; 
}
//3 check if Date of birth is DD/MM/YYYY and writes into database YYYY/MM/DD
$Day = substr($DOB, 0, 2);
$month = substr($DOB, 3, 2);
$year = substr($DOB, 6, 4);

    $DOB2 = $year . "-" . $month . "-" . $Day;
    if (checkdate ( $month,$Day ,$year) !== FALSE) {
       
        $check3 = TRUE;
    }
     else {
         $DOB = "";
        echo 'not a date'; 
    }

//4 check if Date of birth is == start of ID number

    $check = substr($year, 2, 2) . $month . $Day;
    $compare = substr($IDNumber, 0, 6);
    if ($check = $compare) {
        $check4 = TRUE;
    }
 else {
        echo 'no match error'; 
    }

//4 write into database if all checks is passed 

if ( $check2 == TRUE && $check3 == TRUE && $check4 == TRUE) {
    $sql = "INSERT INTO `informationtbl`(`Name`, `Surname`, `IDNo`, `DateOfBirth`) VALUES ('{$Name}','{$Surname}','{$IDNumber}','{$DOB2}')";
    mysqli_query($Connection, $sql) or die(mysqli_error($Connection));
    if (mysqli_affected_rows($Connection) > 0){
        $SuccessM = "data added to the database";
    }
    $_POST = array();
    $Name = $Surname = $IDNumber = $DOB2 = $DOB = "";

} else {
    echo 'Error';
}
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Input Form</title>
        <style>
input[type=text]{
    width: 50%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    
}

form {
    margin: auto;
    width: 60%;
    padding: 5px;
    
}
button{
    
}
</style>
    </head>
    <body>
        <form name="Info" method="POST" action="index.php">

            <div>
                <label>Name</label></br>
                <input type="text" name="nameInput" pattern="[A-Za-z]+" required autocomplete="off" value="<?php echo htmlentities($Name) ?>" placeholder="Name">
            </div>

            <div>
                <label>Surname</label></br>
                <input type="text" name="SurnameInput" pattern="[A-Za-z]+" required autocomplete="off" value="<?php echo htmlentities($Surname) ?>" placeholder="Surname">
            </div>

            <div>
                <label >ID Number</label></br>
                <input type="text" name="IDInput" pattern="[0-9]{13}" required autocomplete="off" value="<?php echo htmlentities($IDNumber) ?>" placeholder="Must be 13 characters"><?php echo $errorM; ?>
            </div>

            <div>
                <label>Date Of birth</label></br>
                <input type="text" name="DOBInput" pattern="[0-9]{1,2}/[0-9]{1,2}/[0-9]{4}" required autocomplete="off" value="<?php echo htmlentities($DOB) ?>" placeholder="DD/MM/YYYY">

            </div>

            </br>
            <button type="submit" name="PostButton">Post</button>
            <button type="reset" name="CancelButton" >Cancel</button>
        </form>
<?php echo "</br>" . $SuccessM; ?>
    </body>
</html>

