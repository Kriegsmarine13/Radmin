<?php
if(!require_once('../bd.php')) {
    echo "failed to include file!";
} else {
    echo "Included!";
}
$dummy = 'superpass';
echo $dummy;
$superpass = password_hash($dummy, PASSWORD_BCRYPT);
echo $superpass;
$sql = 'INSERT INTO administration (login, password, level) VALUES (SuperUser,'.$superpass.',0)';
$result = $mysqli->query($sql);
echo $result;
echo "Ty pidor";
?>
