<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Comatible">
    <meta name="viewport" content="width-device-width, initial-scale-1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="/css/register.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <script src="https://kit.fontawesome.com/6161ff573e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <script>
        document.onkeydown = function(evt) {
            var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
            if (keyCode == 13) {
                //your function call here
                document.search.submit();
            }
        }
    </script>
</head>

<body>
    <nav>
        <div class="container">
            <h2 class="log">
                <img src="/img?filename=1.png" style="width:20px ;">
                <a style="text-decoration: none;" href="http://192.168.56.135:2009/index.php">DZ0SA </a>
            </h2>
            <div class="search-bar" style="width:fit-content">
                <i class=" uil uil-search"></i>
                <form name="search" action="http://192.168.56.135:2009/search.php" method="get" style="display: inline-block;">
                    <input type="search" placeholder="Search" name="search">
                </form>
            </div>
            <div class="create">
                <div class="col-12">
                    <?php
                    if ($login_session) {
                        echo 'Welcome <a href=' . $root . '/profile.php/?id=' . $user_id . '>' . $login_session . '</a>';
                    } else {
                        echo "";
                    }
                    ?>
                </div>
                <?php if (isset($_SESSION['loggedin'])) { ?>
                    <a href="http://192.168.56.135:2009/logout.php" class='btn btn-primary' for="createPost" style="color:white;">
                        Logout
                    </a>
                <?php } ?>
            </div>
        </div>
    </nav>