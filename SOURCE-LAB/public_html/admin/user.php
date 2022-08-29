<?php
include("../function/session.php");

if ($_SESSION['isAdmin'] == 1) {
    include("../function/functions.php");
    getAlluser();
?>

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

    <button class="edit_btn" onclick="document.getElementById('user<?php echo $id ?>').style.display='block'">ADD</button>
    <div id='user<?php echo $id ?>' class="modal">
        <span onclick="document.getElementById('user<?php echo $id ?>').style.display='none'" class=" close" title="Close Modal">&times;</span>
        <div class="modal-content">
            <div class="middle" style="padding-top:100px;">
                <form method="post">

                    <label class="col-25" for="lname">First Name</label>
                    <input type="text" id="firstname" name="fname" placeholder="Your first name..">

                    <label class="col-25" for="lname">Last Name</label>
                    <input type="text" id="lastname" name="lname" placeholder="Your last name..">

                    <label class="col-25" for="fname">User Name</label>
                    <input type="text" id="username" name="uname" placeholder="Your user name..">

                    <label class="col-25" for="fname">Password</label>
                    <input type="password" id="password" name="pw" placeholder="Your password ...">

                    <input type="submit" value="Register" name='addbyadmin'>
                    <?php addbyAdmin() ?>
                </form>
            </div>
        </div>
    </div>
<?php } else {
    echo "do not have permission";
} ?>