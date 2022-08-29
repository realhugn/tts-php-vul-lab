<?php
$root = $_SERVER["REQUEST_URI"];
include("./database/config.php");
include("./function/functions.php");
session_start();
$login = false;
if ($_SESSION["loggedin"]) {
  header("location: index.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $uname = mysqli_real_escape_string($con, $_POST['uname']);
  $pw =  mysqli_real_escape_string($con, md5($_POST['pw']));
  $stmt = mysqli_prepare($con, "SELECT * FROM user WHERE username = ?");
  mysqli_stmt_bind_param($stmt, "s", $uname);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  $count = mysqli_num_rows($result);

  if ($count != 0) {
    if ($pw == $row['password']) {
      $login = true;
      $_SESSION['loggedin'] = true;
      $_SESSION['pro5id'] = $row['id'];
      $_SESSION['login_user'] = $uname;
      if ($row['isAdmin'] == 1) {
        $_SESSION['isAdmin']  = 1;
      } else {
        $_SESSION['isAdmin'] = 0;
      }
      new Redirect('http://192.168.56.135:2010/index.php', 2000);
    } else {
      $error = "Invalid username or password1";
    }
  } else if ($count == 0) {
    $error = "Invalid username or password";
  } else {
    $error = "Can't Login to a Banned Account";
  }
}
?>




<html>
<link rel=stylesheet href='./style.css'>
<link rel=stylesheet href='./css/register.css'>

<body>
  <nav>
    <div class="container">
      <h2 class="log">
        DZ0SA
      </h2>
      <div class="create">
        <label class='btn btn-primary' for="createPost">
          <a style="text-decoration: none; color:white" href="./register.php">Register</a>
        </label>
      </div>
    </div>
  </nav>
  <!----main--->
  <?php
  if (!$login) {
    echo '<main>
      <h2 class="title">Login</h2>
      <div class="container">

        <form action="" method="post">

          <label class="col-25" for="fname">User Name</label>
          <input type="text" id="username" name="uname" placeholder="Your user name..">

          <label class="col-25" for="fname">Password</label>
          <input type="password" id="password" name="pw" placeholder="Your password ...">
          <a style="display:block;margin-top:20px; font-size: 15px" href="./register.php">Khong co tai khoan ?</a>
          <input type="submit" value="Login">

        </form>
        <div style="font-size: 11px; color:#cc0000; margin-top:10px">';
    echo $error;
    echo '</div>
      </div>
    </main>';
  } else {
    echo '<main>
      <h2 class="title">Login</h2>
      <div class="container">
        Logged In Sucessfully! 
        Click <a href = "./index.php"> here</a> if not redirect
      </div>
    </main>';
  }
  ?>
</body>

</html>