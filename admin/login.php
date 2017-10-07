<?php
//All echoes for error_handling reasons
error_reporting(E_ALL);
//trying to get IP bypassing proxy
session_start();
    require_once("../bd.php");
    include_once("getip.php");
    $login = $_POST['login'];
    $sql = "SELECT `password`,`level` FROM `administration` WHERE `login` = '$login'";
//    echo $sql;
    $result = $mysqli->query($sql);
//    if(!$result){
//        echo "<br>Failed to send request!";
//    } else {
//        echo "<br>Request was sent";
//    }
    foreach($result as $item) {
        $level = $item['level'];
        $password = $item['password'];
    }
//    echo "<br>Access level is: ".$level;
//    echo "<br>Password is: ".$password;
    $check = password_verify($_POST['password'],$password);
//    if($check) {
//        echo "<br>Password verified!";
//    } else {
//        echo "<br>Password denied!";
//    }
    $sessid = $_COOKIE['PHPSESSID'];
//    echo "<br>PHPSESSID is: ".$sessid;
    $token = hash('sha256', $sessid); //unique token of user session, will try to realize csrf token (or delete later)
//    echo "<br>Token is: ".$token;
    $levels = ["0" => "365", "1" => "14", "2" => "1"]; //cookie time for different users
    $getIP = new getIP();
    $ip = $getIP->getUserIP();
//    echo "<br>IP is: ".$ip;
    //if login successful, send cookie with $token value for time depending on $level of access, then redirect to main admin page
    if($check) {
        setcookie("1", $token, time() + 60 * 60 * 24 * $level, "/admin/", "risens.team");
        header('Location: ../admin/main.html');
        echo "Cookie sent, redirecting";
    } else {
        //else, set timezone, define $timestamp, open log file and write login attempt with $login, $password, $ip and $timestamp
        date_default_timezone_set("UTC+3");
        $timestamp = date(DATE_RFC822);
        $fopen = fopen("log.txt", "a+");
        fwrite($fopen, "\r\nLogin: ".$login."; Password: ".$password."; IP: ".$ip." at ".$timestamp);
        $fclose = fclose($fopen);
        //redirect back to login page
        echo "<br>Invalid Password";
        header('Refresh: 0, Location: index.html');
    }
?>
