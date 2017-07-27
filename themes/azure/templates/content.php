<?php $this->layout('theme::layout/05_page') ?>
<article class="Page">

    <h1><?= $page['title'] ?></h1>

    <div class="copy">
        <?= $page['content']; ?>
    </div>

    <?php if ($params['html']['date_modified']) { ?>
        <span style="float: left; font-size: 10px; color: gray;">
            <?= date("l, F j, Y g:i A", $page['modified_time']); ?>
        </span>
    <?php } ?>
</article>

