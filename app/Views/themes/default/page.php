<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<div class="mt-4">&nbsp;</div>
<?php if (!empty($page->page_feat_image)) { ?>
    <div class="mb-3">
        <?= img(base_url() . '/writable/uploads/' . $page->page_feat_image, false, ['alt' => $page->page_title, 'style' => 'width: 100%; height: 400px; object-fit: cover;']) ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-8">
        <div class="m-2">
            <h2><?= $page->page_title ?></h2>
            <div class="article"><?= $page->page_content ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <?php if ($site_show_categories) { ?>
            <h4><?= lang('Default.categories') ?></h4>
            <ul class="list-group mb-3">
                <?php foreach ($site_categories as $cat) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= anchor('pages/category/' . $cat->cg_id . '/1', $cat->cg_name, ['class' => 'nav-link']) ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($site_show_archive) { ?>
            <h4><?= lang('Default.archive') ?></h4>
            <ul class="list-group mb-3">
                <?php foreach ($site_archives as $archive) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= anchor('#', Time::createFromDate($archive->year, $archive->month, 1)->toLocalizedString('MMM yyyy'), ['class' => 'nav-link']) ?>
                        <span class="badge bg-secondary rounded-pill"><?= $archive->nposts?></span>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($site_show_archive) { ?>
            <h4><?= lang('Default.members') ?></h4>
            <ul class="list-group mb-3">
                <?php foreach ($users as $user) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= anchor('pages/user/' . $user->user_id, img(base_url() . '/writable/uploads/' . $user->user_image, false, ['style' => 'width: 26px; height: 26px; border-radius: 13px; vertical-align: middle;']) . " " . $user->user_fullname, ['class' => 'nav-link']) ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>
<?php $this->endSection() ?>