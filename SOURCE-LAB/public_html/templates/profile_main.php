<?php

include("header.php");
$current_user = $_SESSION['pro5id'];
?>

<head>
    <title><?php echo $row['firstname'] . " "  . $row['lastname']  ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style>
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
        padding-top: 60px;
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 5px auto;
        /* 15% from the top and centered */
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        /* Position it in the top right corner outside of the modal */
        position: absolute;
        right: 25px;
        top: 100px;
        color: #000;
        font-size: 35px;
        font-weight: bold;
    }

    /* Close button on hover */
    .close:hover,
    .close:focus {
        color: red;
        cursor: pointer;
    }

    /* Add Zoom Animation */
    .animate {
        -webkit-animation: animatezoom 0.6s;
        animation: animatezoom 0.6s
    }

    @-webkit-keyframes animatezoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes animatezoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    td {
        border: 1px solid black;
    }
</style>
<main class="middle">
    <h1>
        Thong tin :
    </h1>
    <div>
        Ten: <?php echo $row['firstname']; ?></br>
        Ho: <?php echo $row['lastname'] ?>
    </div>
    <button class="edit_btn" onclick="document.getElementById('user<?php echo $current_user ?>').style.display='block'">edit</button>
    <div id='user<?php echo $current_user ?>' class="modal">
        <span onclick="document.getElementById('user<?php echo $current_user ?>').style.display='none'" class=" close" title="Close Modal">&times;</span>
        <div class="modal-content">
            <div class="middle" style="padding-top:100px;">
                <form method="post">

                    <label class="col-25" for="lname">First Name</label>
                    <input type="text" id="firstname" name="fname" placeholder="Your first name.." value="<?php echo $row['firstname'] ?>">

                    <label class="col-25" for="lname">Last Name</label>
                    <input type="text" id="lastname" name="lname" placeholder="Your last name.." value="<?php echo $row['lastname'] ?>">

                    <label class="col-25" for="fname">New Password</label>
                    <input type="password" id="password" name="newpw" placeholder="Your new password ...">

                    <input type="submit" value="edit" name="sub1" style="width: fit-content;">
                    <?php editPro5($current_user) ?>
                </form>
            </div>
        </div>
    </div>
    </br>POSTS:
    <table>
        <thead>
            <tr>
                <th>TITLE</th>
                <th>CONTENT</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <?php
        $sql_get_post = "select id, content, title,user_id from post where user_id = '" . $match . "' order by id";
        $result = mysqli_query($con, $sql_get_post);
        while ($post_row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $post_row['title'] ?></td>
                <td><?php echo $post_row["content"] ?></td>
                <td>
                    <button class="edit_btn" onclick="document.getElementById(<?php echo $post_row['id'] ?>).style.display='block'">edit</button>
                    <div id=<?php echo $post_row['id'] ?> class="modal">
                        <span onclick="document.getElementById(<?php echo $post_row['id'] ?>).style.display='none'" class="close" title="Close Modal">&times;</span>
                        <!-- Modal Content -->
                        <div class="modal-content">
                            <div class="middle" style="padding-top:100px;">
                                <div id='insert-post'>
                                    <form class="create-post" method="post">
                                        <label> Title</label>
                                        <input class='title' placeholder="Enter title here" name="title" value="<?php echo $post_row['title'] ?>">
                                        <label>Content</label>
                                        <textarea type="text" placeholder="What's on your mind ?..." class="form-control" style="height:100px" name="content"><?php echo $post_row["content"] ?> </textarea>
                                        <input class="btn-post" value="Post" type="submit" name="<?php echo "edit" . $post_row['id'] ?>">
                                    </form>
                                </div>
                                <?php
                                editPost($match, $post_row['id']) ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <a href="<?php echo $root . "/?id=" . $match . "&del="  . $post_row["id"]; ?>" class="edit_btn" onclick='return confirm("are you sure")'>delete</a>
                </td>
                <?php
                echo "
                            <script>
                                var modal = document.getElementById(" . $post_row['id'] . ");
                                window.onclick = function(event) {
                                    if (event.target == modal) {
                                        modal.style.display = 'none';
                                    }
                                }
                            </script>";
                ?>
            </tr>
        <?php }

        if (isset($_GET['del'])) {
            $id = $_GET['del'];;
            $check = mysqli_query($con, "select user_id from post where id = '$id'");
            $row_check = mysqli_fetch_array($check);

            if ($row_check['user_id'] == $current_user || $_SESSION['isAdmin'] != 0) {
                mysqli_query($con, "DELETE FROM post WHERE id=$id");

                if ($_SESSION['isAdmin'] != 0) {
                    new Redirect($root . '/admin/post.php');
                } else {
                    new Redirect($root . '/profile.php/?id=' . $match);
                }
            } else {
                new Redirect($root . '/profile.php/?id=' . $match);
            }
        }
        ?>
    </table>

</main>
<?php include("footer.php"); ?>