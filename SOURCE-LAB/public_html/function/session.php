<?php
include('./database/config.php');
session_start();
$root = "http://192.168.56.135:2009";
$user_check = $_SESSION['login_user'];
$is_admin = $_SESSION['isAdmin'];
$ses_sql = mysqli_query($con, "select id ,firstname, lastname , status from user where username = '$user_check' ");
$rowses = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
$user_id = $rowses['id'];
$user_status = $rowses['status'];
$login_session = $rowses['firstname'] . " "  . $rowses['lastname'];
if (!isset($_SESSION['loggedin']) && !$_SESSION['loggedin']) {
   header("location: http://192.168.56.135:2009/login.php");
   exit;
}
