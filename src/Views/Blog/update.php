<?php
ob_start();
?>

<section class="create">
    <h1><i class="fas fa-list-alt"></i> Modification Bloglist : <?= $_POST["content"] ?></h1>

    <div>
        <div class="list">
            <div class="top">
                <form action="/dashboard/<?= escape($_POST["title"]) ?>/update" method="post">
                    <input type="text" name="title" value="<?= $_POST["title"] ?>" placeholder="Name list">
                    <textarea name="content" id="content" cols="30" rows="10"><?= $_POST["content"] ?></textarea>
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
