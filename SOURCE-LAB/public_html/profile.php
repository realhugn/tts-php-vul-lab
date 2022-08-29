 <?php
    include('./function/session.php');
    include("./database/config.php");
    include("./function/functions.php");
    // include("./templates/header.php");
    session_start();
    $url = $_SERVER["REQUEST_URI"];
    $match = $_GET['id'];
    $sql_select_pro5 = "select firstname, lastname,status,id from user where id = '" . $match . "'";
    $result = mysqli_query($con, $sql_select_pro5);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (mysqli_error($con)) {
        echo mysqli_error($con);
    }
    if (count($row) == 0) {
        echo "NOT FOUND";
    } else
        include("./templates/profile_main.php");

    ?>

 