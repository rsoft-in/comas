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
        <?php if ($site_show_categories) { ?>
            <h2><?= lang('Default.categories') ?></h2>
            <div class="list">
                <?php foreach ($site_categories as $cat) { ?>
                    <div class="list-item">
                        <?= anchor('pages/category/' . $cat->cg_id . '/1', $cat->cg_name) ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($site_show_archive) { ?>
            <h2><?= lang('Default.archive') ?></h2>
            <div class="list">
                <?php foreach ($site_archives as $archive) { ?>
                    <div class="list-item">
                        <?= anchor('#', Time::createFromDate($archive->year, $archive->month, 1)->toLocalizedString('MMM yyyy') . ' (' . $archive->nposts . ')') ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($site_show_archive) { ?>
            <h2><?= lang('Default.members') ?></h2>
            <div class="list">
                <?php foreach ($users as $user) { ?>
                    <div class="list-item mb-1">
                        <?= anchor('pages/user/' . $user->user_id, img(base_url() . '/writable/uploads/' . $user->user_image, false, ['style' => 'width: 26px; height: 26px; border-radius: 13px; vertical-align: middle;']) . " " . $user->user_fullname) ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<?php $this->endSection() ?>