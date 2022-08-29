 <?php
    include('./function/session.php');
    include("./database/config.php");
    include("./function/functions.php");
    // include("./templates/header.php");
    session_start();
    if (is_numeric($_GET['id']) && abs($_GET['id']) == $_GET['id']) {
        $url = $_SERVER["REQUEST_URI"];

        $match = mysqli_real_escape_string($con, (int)$_GET['id']);
        $sql_select_pro5 = mysqli_prepare($con, "select firstname, lastname,status,id from user where id = ?");
        mysqli_stmt_bind_param($sql_select_pro5, "i", $match);
        mysqli_stmt_execute($sql_select_pro5);
        $result = mysqli_stmt_get_result($sql_select_pro5);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if (count($row) == 0) {
            echo "NOT FOUND";
        } else
            include("./templates/profile_main.php");
    } else {
        echo "not found";
    }
    ?>

 