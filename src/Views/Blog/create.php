<?php
ob_start();
?>

<section class="create">
    <h1><i class="fas fa-list-alt"></i> Création Bloglist :</h1>

    <div>
        <div class="list">
            <div class="top">
                <form action="/dashboard/nouveau" method="post" enctype="multipart/form-data">
                    <input type="text" name="name" value="<?php echo old("name"); ?>" placeholder="Name list">
                    <textarea name="area" id="area" cols="30" rows="10"></textarea>
                    <input type="file" name="file" id="file">
                    <button type="submit" name="button"><i class="fas fa-plus"></i></button>
                </form>
                <span class="error"><?php echo error("name"); ?></span>
            </div>

            <div class="separateur"></div>

            <div class="bottom">
            </div>
        </div>


    </div>

</section>

<?php
$content = ob_get_clean();
require VIEWS . 'layout.php';
