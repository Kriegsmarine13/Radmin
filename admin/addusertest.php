<?php
require_once "../bd.php";
$dummy = 'superpass';
$superpass = password_hash($dummy, BCRYPT);
$sql = 'INSERT INTO administration (login, password, level) VALUES (SuperUser,'.$superpass.',0)';
$result = $mysqli->query($sql);
echo $superpass;
echo $mysqli;
echo $result;
echo "Ty pidor";
?>
