<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<div class="mt-4">&nbsp;</div>
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <h2>
                <?= anchor('#', img(base_url() . '/writable/uploads/' . $user->user_image, false, ['title' => $user->user_fullname, 'style' => 'width: 50px; height: 50px; border-radius: 25px; vertical-align: middle;'])) ?>
                <?= $user->user_fullname ?></h2>
        </div>
        <div class="p-2 m-2">
            <?= $user->user_about ?>
        </div>
        <hr>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($posts as $post) { ?>
                <div class="col">
                        <div id="card<?= $ctr ?>" class="card shadow">
                            <?= anchor('pages/post/' . $post->post_id, img(empty($post->post_feature_img) ?  'assets/placeholder.png' : 'writable/uploads/' . $post->post_feature_img, false, ['title' => $post->post_title, 'class' => 'card-img-top', 'style' => 'height: 150px; object-fit: cover;']))  ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= anchor('pages/post/' . $post->post_id, $post->post_title) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <?= anchor('pages/category/' . $post->post_cg_id . '/1', "<i class=\"bi bi-collection\"></i>" . $post->cg_name) ?>
                                    <?= anchor('pages/user/' . $post->post_author_id, "<i class=\"bi bi-person\"></i>" . $post->user_fullname) ?>
                                    <?= anchor('pages/post/' . $post->post_id . '#comment', "<i class=\"bi bi-chat-left-text\"></i>" . $post->ncomments) ?>
                                </h6>
                                <div class="card-text">
                                    <div class="post"><?= word_limiter($post->post_content, 10) ?></div>
                                </div>
                                <div class="text-end text-muted">
                                    <small><i class="bi bi-calendar-event"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php } ?>
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
                        <span class="badge bg-secondary rounded-pill"><?= $archive->nposts ?></span>
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