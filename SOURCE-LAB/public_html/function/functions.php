<?php
$root = "http://192.168.56.135:2009";

use Redirect as GlobalRedirect;

include("../database/config.php");
// Hàm điều hướng trang
class Redirect
{
    public function __construct($url = null, $time = 0)
    {
        if ($url) {
            echo '<script>window.setTimeout(function() {
                location.href =" ' . $url . '";
            },' . $time . ' );</script>';
        }
    }
}

function insertPost($user_id)
{
    if (isset($_POST['sub'])) {
        global $con;
        $content = $_POST['content'];
        $title = $_POST['title'];
        if (strlen($title) == 0) {
            $title = "None";
        }
        if (strlen($content) >= 1 && strlen($title) >= 0) {
            $sql_insert = "insert into post (content, user_id, title) values ('.$content.','$user_id','$title')";
            mysqli_query($con, $sql_insert);
            header('location:' . $_SERVER['REQUEST_URI']);
        }
    }
}


function getPost($user_id)
{
    global $con;
    $sql_get_post = "select id, content, title, user_id from post where user_id = '" . $user_id . "' order by id";
    $result = mysqli_query($con, $sql_get_post);
    echo $sql_get_post;
    return $result;
}

function editPost($user_id, $post_id)
{
    if ($user_id == $_SESSION['pro5id']) {
        if (isset($_POST['edit' . $post_id])) {
            global $con, $root;
            $content = htmlentities($_POST['content']);
            $title = htmlentities($_POST['title']);
            if (strlen($content) >= 1) {
                $sql_update = "update post set content = '$content', title = '$title' where id= $post_id";
                mysqli_query($con, $sql_update);
                new Redirect($root . '/profile.php/?id=' . $user_id);
            }
        }
    }
}

function editPostAdmin($user_id, $post_id)
{
    if (isset($_POST['edit' . $post_id])) {
        global $con, $root;
        $content = htmlentities($_POST['content']);
        $title = htmlentities($_POST['title']);
        if (strlen($content) >= 1) {
            $sql_update = "update post set content = '$content', title = '$title' where id= $post_id";
            mysqli_query($con, $sql_update);
            new Redirect($root . '/admin/post.php');
        }
    }
}

function nfPost()
{
    global $con, $root;
    $per_page = 5;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $start_from = ($page - 1) * $per_page;
    $sql_nfpost = "select p.id,p.user_id,p.title,p.content from post p join user u on p.user_id = u.id where status = 1 order by p.id desc LIMIT $start_from ,$per_page ";

    $run_post = mysqli_query($con, $sql_nfpost);
    while ($row = mysqli_fetch_array($run_post)) {
        $post_id = $row['id'];
        $user_id = $row['user_id'];
        $content = $row['content'];
        $title = $row['title'];
        $user = "select * from user where id ='$user_id'";
        $run_user = mysqli_query($con, $user);
        $row_user = mysqli_fetch_array($run_user);

        $user_name = $row_user['firstname'] . " " . $row_user['lastname'];


        if ($content && $row_user['status'] == 1) {
            echo "
            </br>
            <div style='border: 1px solid black; width:70vw;display:inline-block'>
                <div style='text-align:left'>
                    <a href=" . $root . "/profile.php/?id=" . $user_id . ">"
                . $user_name . "
                    </a>
                </div>
                <div >" . $title . " </div>"
                . $content .
                "</div></br>
            ";
        }
    }

    include('pagination.php');
}

function banUser($userID)
{
    global $con, $root;
    $sql_ban = "update user set status = 0 where id = '$userID'";
    mysqli_query($con, $sql_ban);
    new Redirect($root . '/admin/user.php');
}

function unbanUser($userID)
{
    global $con, $root;
    $sql_ban = "update user set status = 1 where id = '$userID'";
    mysqli_query($con, $sql_ban);
    new Redirect($root . '/admin/user.php');
}

function getAlluser()
{
    global $con;
    $sql_get_user = 'select * from user';
    $run = mysqli_query($con, $sql_get_user);
    echo "
    <table>
        <thead> 
            <tr>
                <th> ID </th>
                <th> Fistname </th>
                <th> Lastname </th>
                <th> username </th>
                <th> status </th>
                <th> admin </th>
                <th> posts num </th>
                <th colspan='3'> action </th>
            </tr>
        </thead>
    ";
    while ($row = mysqli_fetch_assoc($run)) {
        $id = $row['id'];
        $first_name = $row['firstname'];
        $last_name = $row['lastname'];
        $username = $row['username'];
        $status = $row['status'];
        $admin = $row['isAdmin'];
        $post_sql = "select * from post where user_id = '$id'";
        $rs = mysqli_query($con, $post_sql);
        $count = mysqli_num_rows($rs);

        if ($id) {
            echo "
            <tr>
                <td>$id</td>
                <td>$first_name</td>
                <td>$last_name</td>
                <td>$username</td>
                <td>$status</td>
                <td>$admin</td>
                <td>$count </td>
                <td>
                    <form method='post'>
                        <input type='submit' name='ban_user$id' class='button' value='Ban this user' />
                        <input type='submit' name='unban_user$id' class='button' value=' Unban this user' />
                    </form>                
                </td>
                <td>

            ";
?>
            <button class="edit_btn" onclick="document.getElementById('user<?php echo $id ?>').style.display='block'">edit</button>
            <div id='user<?php echo $id ?>' class="modal">
                <span onclick="document.getElementById('user<?php echo $id ?>').style.display='none'" class=" close" title="Close Modal">&times;</span>
                <div class="modal-content">
                    <div class="middle" style="padding-top:100px;">
                        <form method="post">

                            <label class="col-25" for="lname">First Name</label>
                            <input type="text" id="firstname" name="fname" placeholder="Your first name.." value="<?php echo $row['firstname'] ?>" required>

                            <label class="col-25" for="lname">Last Name</label>
                            <input type="text" id="lastname" name="lname" placeholder="Your last name.." value="<?php echo $row['lastname'] ?>" required>

                            <label class="col-25" for="fname">User Name</label>
                            <input type="text" id="username" name="uname" placeholder="Your user name.." value="<?php echo $username ?>" required>

                            <label class="col-25" for="fname">Password</label>
                            <input type="password" id="username" name="pw" placeholder="new password">

                            <input type="submit" value="edit" name="sub<?php echo $id ?>" style="width: fit-content;">
                            <?php editPro5admin($id) ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php }
        if (array_key_exists('ban_user' . $id, $_POST)) {
            banUser($id);
        }

        if (array_key_exists('unban_user' . $id, $_POST)) {
            unbanUser($id);
        }
    }


    echo "
            </td>
        </tr>
    </table>";
}


function getAllpost()
{
    global $con, $root;
    $sql_nfpost = "select * from post order by id ";
    $run_post = mysqli_query($con, $sql_nfpost);
    echo "
            <table>
                <thead>
                    <tr>
                        <th> ID </th>
                        <th>NAME</th>
                        <th>TITLE</th>
                        <th>CONTENT</th>
                        <th colspan='2'>Action</th>
                    </tr>
                </thead>";
    while ($row = mysqli_fetch_assoc($run_post)) {
        $post_id = $row['id'];
        $user_id = $row['user_id'];
        $content = $row['content'];
        $title = $row['title'];
        $user = "select * from user where id ='$user_id'";
        $run_user = mysqli_query($con, $user);
        $row_user = mysqli_fetch_array($run_user);

        $user_name = $row_user['firstname'] . " " . $row_user['lastname'];
        if ($content) {

            echo "
            <tr>
                <td>$user_id</td>
                <td>
                    <a href=$root.'/profile.php/?id=" . $user_id . "'>"
                . $user_name . " 
                    </a>
                </td>
                <td>" . $title . "</td>
                <td>" . $content . "</td>
                <td>
                    <a href=" . $root . "/profile.php/?id=" . $user_id . "&del="  . $post_id . "' class='edit_btn'>delete</a>
                </td>                  
            ";
        ?>
            <td>
                <button class="edit_btn" onclick="document.getElementById(<?php echo $post_id ?>).style.display='block'">edit</button>
                <div id=<?php echo $post_id ?> class="modal">
                    <span onclick="document.getElementById(<?php echo $post_id ?>).style.display='none'" class="close" title="Close Modal">&times;</span>
                    <!-- Modal Content -->
                    <div class="modal-content">
                        <div class="middle" style="padding-top:100px;">
                            <div id='insert-post'>
                                <form class="create-post" method="post">
                                    <label> Title</label>
                                    <input class='title' placeholder="Enter title here" name="title" value="<?php echo $title ?>">
                                    <label>Content</label>
                                    <textarea type="text" placeholder="What's on your mind ?..." class="form-control" style="height:100px" name="content"><?php echo $content ?> </textarea>
                                    <input class="btn-post" value="Post" type="submit" name="<?php echo "edit" . $post_id ?>">
                                </form>
                            </div>
                            <?php
                            editPostAdmin($user_id, $post_id) ?>
                        </div>
                    </div>
                </div>
            </td>
<?php }
    }
    echo "</table>";
}

function editPro5($user_id)
{
    if (isset($_POST['sub1'])) {
        global $con, $root;
        $new = md5(mysqli_real_escape_string($con, $_POST['newpw']));
        $fname = mysqli_real_escape_string($con, $_POST['fname']);
        $lname = mysqli_real_escape_string($con, $_POST['lname']);
        // $sql_check = "select id from user where id = '$user_id' and password = '$old'";

        // $check = mysqli_query($con, $sql_check);
        // $numrow = mysqli_fetch_array($check, MYSQLI_ASSOC);
        // if (mysqli_num_rows($check) == 1) {
        $sql_update = "update user set firstname = '$fname' , lastname = '$lname', password = '$new' where id = $user_id";
        mysqli_query($con, $sql_update);
        new Redirect($root . "/profile.php/?id=" . $user_id);
        // } else {
        //     echo "<script> alert('wrong password') </script>";
        // }
    }
}

function editPro5admin($user_id)
{
    if (isset($_POST['sub' . $user_id])) {
        global $con, $root;
        $fname = mysqli_real_escape_string($con, $_POST['fname']);
        $lname = mysqli_real_escape_string($con, $_POST['lname']);
        $uname = mysqli_real_escape_string($con, $_POST['uname']);
        if (!$_POST['pw']) {
            $sql_update = "update user set firstname = '$fname' , lastname = '$lname', username = '$uname' where id = $user_id";
            mysqli_query($con, $sql_update);
            new Redirect($root . "/admin/user.php");
        } else {
            $pw = md5(mysqli_real_escape_string($con, $_POST['pw']));
            $sql_update = "update user set firstname = '$fname' , lastname = '$lname', username = '$uname', password = '$pw' where id = $user_id";
            mysqli_query($con, $sql_update);
            new Redirect($root . "/admin/user.php");
        }
    }
}

function addbyAdmin()
{
    if (isset($_POST['addbyadmin'])) {
        global $con, $root;
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
            new Redirect($root . "/admin/user.php");
        } else {
            echo "<script> alert('username already exits') </script>";
        }
    }
}


?>