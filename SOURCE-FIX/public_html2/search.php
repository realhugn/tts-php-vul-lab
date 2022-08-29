<?php
session_start();
include("./function/session.php");
include("./templates/header.php");

include("./database/config.php");

include("./function/functions.php");

?>
<div class="middle">
    <?php

    $search = htmlentities($_GET['search']);
    xss_clean($search);
    if (isset($_GET['search'])) {
        $sql_search_user = mysqli_prepare($con, "select * from user where firstname like '%?%' or lastname like '%?%'");
        mysqli_stmt_bind_param($sql_search_user, "ss", $search);
        mysqli_stmt_execute($sql_search_user);
        $result_user = mysqli_stmt_get_result($sql_search_user);
        $num = mysqli_num_rows($result_user);
        if ($num != 0 && $search != "") {
            echo "$num user for $search </br>";
            echo '<tr>';
            echo "USER: </br>";
            while ($row = mysqli_fetch_array($result_user)) {
                echo "<td> <a style='text-decoration:none' href='http://192.168.56.135:2010/profile.php?id=" . $row['id'] . "'>" . $row['firstname'] . " " . $row['lastname'] . "</a></td>";
                echo "</br>";
            }
            echo '</tr>';
        } else {
            echo "0 users for $search </br>";
        }
    } else {
        echo "<p> Empty </p>";
    }
    ?>
</div>
<?php include("./templates/footer.php") ?>