<?php $this->layout('theme::layout/00_layout') ?>
<?php $this->insert('theme::partials/navbar_content', ['params' => $params]); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            Test
        </div>
        <div class="col-md-8">
            <?= $this->section('content'); ?>
        </div>
    </div>
</div>