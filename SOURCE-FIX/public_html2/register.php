<?php
include("./database/config.php");
session_start();

if ($_SESSION["loggedin"]) {
  header("location: index.php");
}
$is_registed = true;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $uname = mysqli_real_escape_string($con, $_POST['uname']);
  $pw = md5(mysqli_real_escape_string($con, $_POST['pw']));
  $fname = mysqli_real_escape_string($con, $_POST['fname']);
  $lname = mysqli_real_escape_string($con, $_POST['lname']);

  $sql = mysqli_prepare($con, "INSERT INTO user (firstname, lastname, username, password,status,isAdmin) VALUES (?,?,?,?,'1','0')");
  mysqli_stmt_bind_param($sql, "ssss", $fname, $lname, $uname, $pw);
  $sql_check_uname = mysqli_prepare($con, "SELECT id FROM user WHERE username = ?");
  mysqli_stmt_bind_param($sql_check_uname, "s", $uname);
  mysqli_stmt_execute($sql_check_uname);
  $check = mysqli_stmt_get_result($sql_check_uname);
  if (mysqli_num_rows($check) == 0) {
    mysqli_stmt_execute($sql);
    // $is_registed = true;
    $_SESSION['loggedin'] = true;
    $_SESSION['login_user'] = $uname;
    header("location: login.php");
  } else {
    $error = "Username has already exist...";
  }
}

?>


<html>
<link rel=stylesheet href='style.css'>
<link rel=stylesheet href='./css/register.css'>

<body>
  <nav>
    <div class="container">
      <h2 class="log">
        DZ0SA
      </h2>
      <div class="create">
        <label class='btn btn-primary' for="createPost">
          <a style="text-decoration:none;color:white" href="./login.php">Login</a>
        </label>
      </div>
    </div>
  </nav>
  <!----main--->
  <main>
    <h2 class='title'>Register</h2>
    <div class="container">

      <form action="" method="post">

        <label class="col-25" for="lname">First Name</label>
        <input type="text" id="firstname" name="fname" placeholder="Your first name.." required>

        <label class="col-25" for="lname">Last Name</label>
        <input type="text" id="lastname" name="lname" placeholder="Your last name.." required>

        <label class="col-25" for="fname">User Name</label>
        <input type="text" id="username" name="uname" placeholder="Your user name.." required>

        <label class="col-25" for="fname">Password</label>
        <input type="password" id="password" name="pw" placeholder="Your password ..." required>

        <input type="submit" value="Register">
        <?php echo $error ?>
      </form>
    </div>
  </main>
</body>

</html>