<div class="middle" style="padding-top:100px;">
    <div id='insert-post'>
        <form class="create-post" method="post" id="f">
            <label> Title</label>
            <input class='title' placeholder="Enter title here" name="title">
            <label>Content</label>
            <textarea type="text" placeholder="What's on your mind ?..." class="form-control" style="height:100px" name="content"></textarea>
            <input class="btn-post" value="Post" type="submit" name="sub" style="width: fit-content;">
        </form>
        <?php insertPost($user_id); ?>
        <?php nfPost() ?>
    </div>
</div>