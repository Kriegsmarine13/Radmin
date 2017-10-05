<?php
include "../bd.php";

//trying to get IP bypassing proxy
function getUserIP() {
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    } elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    return $ip;
}

public $userIP = getUserIP();

private function login() {
    $login = $_POST['login'];
    $sql = 'SELECT password,level FROM administration WHERE login = $login';
    $mysqli = $mysqli->query($sql);
    $password = $mysqli['password'];
    $check = password_verify($_POST['password'],$password);
    $sessid = $_COOKIE['PHPSESSID'];
    $token = hash('bcrypt', $token); //unique token of user session, will try to realize csrf token (or delete later)
    $levels = ["0" => "365", "1" => "14", "2" => "1"]; //cookie time for different users
    //if login successful, send cookie with $token value for time depending on $level of access, then redirect to main admin page
    if($check) {
        setcookie("1", $token, time() + 60 * 60 * 24 * $level, "/admin/", "risens.team");
        header('Location: main.html');
    } else {
        //else, set timezone, define $timestamp, open log file and write login attempt with $login, $password, $ip and $timestamp
        date_deafault_timezone_set("UTC+3")
        $timestamp = date(DATE_RFC822);
        $fopen = fopen("log.txt", "a");
        fwrite($fopen, "Login: ".$login."; Password: ".$password."; IP: ".$userIP." at ".$timestamp;)
        $fclose = fclose($fopen);
        //redirect back to login page
        echo "Invalid Password";
        header('Location: index.html');
    }
}
?>
