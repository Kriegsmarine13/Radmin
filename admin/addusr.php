<?php
$including = require_once('../bd.php');
if(!$including) {
    echo "Failed to include file!<br>";
} else {
    echo "Included!<br>";
}
$dummy = 'superpass';
echo "User password: ".$dummy."<br>";
$superpass = password_hash($dummy, PASSWORD_BCRYPT);
$login = "SU1";
echo "Hashed User Password: ".$superpass."<br>";
$sql = "INSERT INTO `administration`(`id`,`login`, `password`, `level`,`placeholder`) VALUES ('','$login','$superpass','0','')";
echo $sql."<br>";
$result = $mysqli->query($sql);
if($result) {
    echo "Insertion of a new Hashed User Password: " . $result . "<br>";
} else {
    echo "Insertion failed!<br>";
}
echo "Test";
?>
