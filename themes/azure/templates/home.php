<?php $this->layout('theme::layout/00_layout') ?>
<?php $this->insert('theme::partials/navbar_content', ['params' => $params]); ?>

<div id="content-wrapper" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if ($params['tagline']) {
                    echo '<h1>' . $params['tagline'] . '</h1>';
                } ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <?php
                    foreach ($page['entry_page'] as $key => $node) {
                        echo '<a href="' . $node . '" class="home-button">' . $key . '</a>';
                    }
                    if(isset($params['html']['buttons']) && is_array($params['html']['buttons'])) {
                        foreach ($params['html']['buttons'] as $name => $link ) {
                            echo '<a href="' . $link . '" class="Button Button--secondary Button--hero">' . $name . '</a>';
                        }
                    }
                ?>
                <a href="[pdf_link]" class="home-button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span>Download PDF</span></a>
                <?php    
                    if ($params['html']['repo']) {
                        echo '<a href="https://github.com/' . $params['html']['repo'] . '" class="Button Button--secondary Button--hero">View On GitHub</a>';
                    }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="copy">
                    <?= $page['content']; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($params['html']['links'])) {
                ?>
                    <ul class="HomepageFooter__links">
                        <?php foreach ($params['html']['links'] as $name => $url) {
                            echo '<li><a href="' . $url . '" target="_blank">' . $name . '</a></li>';
                        } ?>
                    </ul>
                <?php
                } ?>

                <?php if (!empty($params['html']['twitter'])) {
                ?>
                    <div class="HomepageFooter__twitter">
                        <?php foreach ($params['html']['twitter'] as $handle) {
                        ?>
                            <div class="Twitter">
                                <iframe allowtransparency="true" frameborder="0" scrolling="no" style="width:162px; height:20px;" src="https://platform.twitter.com/widgets/follow_button.html?screen_name=<?= $handle; ?>&amp;show_count=false"></iframe>
                            </div>
                        <?php
                        } ?>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </div>
</div>