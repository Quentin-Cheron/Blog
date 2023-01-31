<?php
ob_start();
?>

<section class="sectionView">
    <div class="viewList">
        <div class="top">
            <p class="nameList"><?php echo escape($Blog->getTitle()); ?></p>
            <form class="formEdit" action="/dashboard/<?php echo escape($Blog->getTitle()); ?>/createUpdate" method="post">
                <button type="submit" name="button"><i class="fas fa-pen"></i></button>
                <input type="hidden" name="title" value="<?= $Blog->getTitle() ?>">
                <input type="hidden" name="content" value="<?= $Blog->getContent() ?>">
            </form>
        </div>
        <div class="separateur"></div>
        <div class="bottom">
            <div class="showEdit">
                <p><?php echo escape($Blog->getContent()); ?></p>
            </div>
            <div class="comment">
                <?php foreach ($Blog->blogs() as $el) : ?>
                    <p><?= $el->getContent() ?></p>
                    <p><?= $Blog->getDate() ?></p>
                    <p><?= $_SESSION["user"]["username"] ?></p>
                <?php endforeach ?>
            </div>
            <div class="blockForm">
                <form action="/dashboard/comment/nouveau" method="post">
                    <i class="iconTask fas fa-tasks"></i>
                    <input type="text" name="comment" value="<?php echo old("nameTask"); ?>" placeholder="create comment">
                    <input type="hidden" name="name" value="<?php echo $Blog->getTitle(); ?>">
                    <input type="hidden" name="id" value="<?php echo $Blog->getId(); ?>">
                    <input type="hidden" name="user" value="<?= $Blog->getUser_id() ?>">
                    <input type="hidden" name="id_article" value="<?= $Blog->getId() ?>">
                    <button type="submit" name="button"><i class="fas fa-plus"></i></button>
                </form>
                <span class="error"><?php echo error("nameTask"); ?></span>
            </div>
        </div>
    </div>
</section>

<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';
