<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<?php if ($site_isblog) { ?>
    <script>
        $(document).ready(function() {
            // var nslides = $('.slider .card').length;
            // $('.slider .card').hide();
            // $('.slider #card' + (nslides - 1)).show();
            // var ctr = 0;
            // setInterval(function() {
            //     $('.slider .card').hide();
            //     var slide = document.getElementById('card' + ctr);
            //     slide.style.display = 'block';
            //     window.setTimeout(function() {
            //         slide.style.opacity = 1;
            //         slide.style.transform = 'scale(1)';
            //         slide.style.transition = '.8s ease opacity, .8s ease transform';
            //     }, 0);
            //     ctr++;
            //     if (ctr == nslides) ctr = 0;
            // }, 5000);
        });
    </script>
    <div class="mt-4">&nbsp;</div>
    <h3>Popular Posts</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        $ctr = 0;
        foreach ($site_posts_popular as $post) { ?>
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
        <?php
            $ctr++;
        } ?>
    </div>
<?php } ?>

<div class="row mt-5">
    <div class="col-md-8">
        <?php if ($site_isblog) { ?>
            <h3>Recent Posts</h3>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php foreach ($site_posts_recent as $post) { ?>
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
            <div class="mt-2 mb-2 text-center">
                <?= anchor('pages/posts', 'More <i class="bi bi-caret-right"></i>', ['class' => 'btn btn-light']) ?>
            </div>
        <?php } else { ?>
            <div class="m-2">
                <h2><?= $page->page_title ?></h2>
                <div class="article"><?= $page->page_content ?></div>
            </div>
        <?php } ?>
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