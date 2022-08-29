<?php
include('./database/config.php');
session_start();
$root = "http://192.168.56.135:2010";
$user_check = $_SESSION['login_user'];
$is_admin = $_SESSION['isAdmin'];
$ses_sql = mysqli_prepare($con, "select id ,firstname, lastname , status from user where username = ?");
mysqli_stmt_bind_param($ses_sql, "s", $user_check);
mysqli_stmt_execute($ses_sql);
$rs = mysqli_stmt_get_result($ses_sql);
$rowses = mysqli_fetch_array($rs, MYSQLI_ASSOC);
$user_id = $rowses['id'];
$user_status = $rowses['status'];
$login_session = $rowses['firstname'] . " "  . $rowses['lastname'];
if (!isset($_SESSION['loggedin']) && !$_SESSION['loggedin']) {
   header("location: http://192.168.56.135:2010/login.php");
   exit;
}
