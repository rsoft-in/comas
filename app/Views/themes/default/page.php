<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<?php if (!empty($page->page_feat_image)) { ?>
    <div class="cover-img">
        <?= img(base_url() . '/writable/uploads/' . $page->page_feat_image, false, ['alt' => $page->page_title]) ?>
    </div>
<?php } ?>
<div class="row">
    <div class="col-large">
        <div class="m-2">
            <h2><?= $page->page_title ?></h2>
            <div class="article"><?= $page->page_content ?></div>
        </div>
    </div>
    <div class="col-small">
        <h2>Categories</h2>
        <div class="list">
            <?php foreach ($site_categories as $cat) { ?>
                <div class="list-item">
                    <?= anchor('pages/category/' . $cat->cg_id . '/1', $cat->cg_name) ?>
                </div>
            <?php } ?>
        </div>
        <h2>Archive</h2>
        <div class="list">
            <?php foreach ($site_archives as $archive) { ?>
                <div class="list-item">
                    <a href="#"><?= Time::createFromDate($archive->year, $archive->month, 1)->toLocalizedString('MMM yyyy') . ' (' . $archive->nposts . ')' ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->endSection() ?>