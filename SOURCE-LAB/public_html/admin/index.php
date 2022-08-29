<?php include("../function/session.php");
if ($_COOKIE['isAdmin']) {
    echo "hello";
?>
    <html>

    <head>
        <title>
            admin page
        </title>
    </head>

    <body>
        </br>
        <a href="./user.php">user</a></br>
        <a href="./post.php">post</a>
    </body>

    </html>
<?php } else {
    echo "do not have permission";
} ?>