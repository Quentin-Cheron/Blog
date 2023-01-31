<?php
ob_start();

?>

<section class="dashboard">
    <div class="topDashBoard">
        <h1><i class="fas fa-list-alt"></i> BlogList :</h1>
        <a href="/dashboard/nouveau">
            <i class="fas fa-plus-circle"></i>
        </a>
    </div>
    <div class="blockAllList" id="masonry">
        <?php
        foreach ($Blogs as $Blog) {
        ?>
            <div class="blockCard">
                <div class="card">
                    <div class="top">
                        <p><?php echo escape($Blog->getTitle()); ?></p>
                        <?php if ($_SESSION["user"]["id"] == $Blog->getUser_id()) : ?>
                            <div>
                                <a href="/dashboard/<?= escape($Blog->getTitle()); ?>"><i class="fas fa-eye"></i></a>
                                <a href="/dashboard/<?= escape($Blog->getTitle()) ?>/delete"><i class="fas fa-trash"></i></a>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="separateur"></div>
                    <div class="bottom">
                        <p><?php echo escape($Blog->getContent()); ?></p>
                        <?php if ($Blog->getFile()) : ?>
                            <img src="/img/<?= $Blog->getFile() ?>" alt="">
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </div>

</section>

<script>
    let container = document.getElementById('masonry');

    let nb_col = window.innerWidth > 1024 ? 3 : window.innerWidth > 768 ? 3 : 1;

    let col_height = [];

    for (var i = 0; i <= nb_col; i++) {
        col_height.push(0);
    }

    for (var i = 0; i < container.children.length; i++) {
        let order = (i + 1) % nb_col || nb_col;
        container.children[i].style.order = order;
        col_height[order] += container.children[i].clientHeight;
    }
    container.style.height = Math.max.apply(Math, col_height) + 50 + 'px';
</script>
<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';
