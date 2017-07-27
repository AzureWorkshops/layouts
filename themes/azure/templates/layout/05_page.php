<?php $this->layout('theme::layout/00_layout') ?>
<?php $this->insert('theme::partials/navbar_content', ['params' => $params]); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-md-offset-1 breadcrumbs">
            <?= $this->get_breadcrumb_title($page, $base_page) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-md-offset-1">
            <!-- Navigation -->
            <?php
            $rendertree = $tree;
            $path = '';

            if ($page['language'] !== '') {
                $rendertree = $tree[$page['language']];
                $path = $page['language'];
            }

            echo $this->get_navigation($rendertree, $path, isset($params['request']) ? $params['request'] : '', $base_page, $params['mode']);
            ?>

            <div class="Links">
                <?php if (!empty($params['html']['links'])) {
                ?>
                    <hr/>
                    <?php foreach ($params['html']['links'] as $name => $url) {
                    ?>
                        <a href="<?= $url ?>" target="_blank"><?= $name ?></a>
                        <br />
                    <?php
                    } ?>
                <?php
                } ?>

                <?php if (!empty($params['html']['twitter'])) {
                ?>
                    <hr/>
                    <div class="Twitter">
                        <?php foreach ($params['html']['twitter'] as $handle) {
                        ?>
                            <iframe allowtransparency="true" frameborder="0" scrolling="no" style="width:162px; height:20px;" src="https://platform.twitter.com/widgets/follow_button.html?screen_name=<?= $handle; ?>&amp;show_count=false"></iframe>
                            <br />
                            <br />
                        <?php
                        } ?>
                    </div>
                <?php
                } ?>
            </div>
        </div>
        <div class="col-md-8">
            <?= $this->section('content'); ?>
        </div>
    </div>
</div>