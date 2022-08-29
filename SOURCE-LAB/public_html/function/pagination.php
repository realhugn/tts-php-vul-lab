<style>
    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    center {
        display: flex;
        justify-content: center;
        align-self: center;
        text-align: center;
        position: absolute;
        left: 50%;
        width: 300px;
        margin-left: -150px;
        bottom: 10px;
    }
</style>



<?php
$query = 'select * from posts';
$result = mysqli_query($con, $query);
$total_posts = mysqli_num_rows($result);
$total_pages = ceil($total_posts / $per_page);
$next_page = $page + 1;
$pre_page = $page - 1;
if ($page == 1) {
    echo "
    <center>
    <div class='pagination'>
    <a href='index.php?page=1'>First Page </a>
";
} else {
    echo "
    <center>
    <div class='pagination'>
    <a href='index.php?page=$pre_page'>Previous Page </a>";
}
echo "<a href ='index.php?page=$next_page'>Next page</div></center>";
?>