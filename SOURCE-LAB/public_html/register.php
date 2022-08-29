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
  $sql = "INSERT INTO user (firstname, lastname, username, password,status,isAdmin) VALUES ('$fname','$lname','$uname','$pw','1','0')";
  $sql_check_uname = "SELECT id FROM user WHERE username = '$uname'";
  $check = mysqli_query($con, $sql_check_uname);
  if (mysqli_num_rows($check) == 0) {
    $result = mysqli_query($con, $sql);
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