<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<?php if ($site_isblog) { ?>
    <h2>Popular Posts</h2>
    <div class="row">
        <?php foreach ($site_posts_popular as $post) { ?>
            <div class="column">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="cover">
                            <?= anchor('pages/post/' . $post->post_id, img(empty($post->post_feature_img) ?  'assets/placeholder.png' : 'writable/uploads/' . $post->post_feature_img, false, ['title' => $post->post_title]))  ?>
                        </div>
                        <div class="content">
                            <h3><?= anchor('pages/post/' . $post->post_id, $post->post_title) ?></h3>
                            <div class="post"><?= word_limiter($post->post_content, 10) ?></div>
                        </div>
                        <div class="card-footer">
                            <table>
                                <tr>
                                    <td>
                                        <?= anchor('pages/category/' . $post->post_cg_id . '/1', "<i class=\"las la-layer-group\"></i>" . $post->cg_name) ?>
                                        <?= anchor('pages/user/' . $post->post_author_id, "<i class=\"las la-user\"></i>" . $post->user_fullname) ?>
                                    </td>
                                    <td>
                                        <div class="text-end">
                                        <?= anchor('pages/post/' . $post->post_id . '#comment', "<i class=\"las la-comment\"></i>" . $post->ncomments) ?>
                                            <i class="las la-calendar"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-large">
        <?php if ($site_isblog) { ?>
            <h2>Recent Posts</h2>
            <div class="list">
                <?php foreach ($site_posts_recent as $post) { ?>
                    <div class="item">
                        <div class="card">
                            <div class="card-body">
                                <div class="cover">
                                    <?= anchor('pages/post/' . $post->post_id, img(empty($post->post_feature_img) ?  'assets/placeholder.png' : 'writable/uploads/' . $post->post_feature_img, false, ['title' => $post->post_title]))  ?>
                                </div>
                                <div class="content">
                                    <h3><?= anchor('pages/post/' . $post->post_id, $post->post_title) ?></h3>
                                    <div class="post"><?= word_limiter($post->post_content, 10) ?></div>
                                </div>
                                <div class="card-footer">
                                    <table>
                                        <tr>
                                            <td>
                                                <?= anchor('pages/category/' . $post->post_cg_id . '/1', "<i class=\"las la-layer-group\"></i>" . $post->cg_name) ?>
                                                <?= anchor('pages/user/' . $post->post_author_id, "<i class=\"las la-user\"></i>" . $post->user_fullname) ?>
                                            </td>
                                            <td>
                                                <div class="text-end">
                                                    <?= anchor('pages/post/' . $post->post_id . '#comment', "<i class=\"las la-comment\"></i>" . $post->ncomments) ?>
                                                    <i class="las la-calendar"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="mt-2 mb-2 text-end">
                <h3><?= anchor('pages/posts', 'More...')?></h3>
            </div>
        <?php } else { ?>
            <div class="m-2">
                <h2><?= $page->page_title ?></h2>
                <div class="article"><?= $page->page_content ?></div>
            </div>
        <?php } ?>
    </div>
    <div class="col-small">
        <?php if ($site_show_categories) { ?>
            <h2><?= lang('Default.categories')?></h2>
            <div class="list">
                <?php foreach ($site_categories as $cat) { ?>
                    <div class="list-item">
                        <?= anchor('pages/category/' . $cat->cg_id . '/1', $cat->cg_name) ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($site_show_archive) { ?>
            <h2><?= lang('Default.archive')?></h2>
            <div class="list">
                <?php foreach ($site_archives as $archive) { ?>
                    <div class="list-item">
                        <?= anchor('#', Time::createFromDate($archive->year, $archive->month, 1)->toLocalizedString('MMM yyyy') . ' (' . $archive->nposts . ')') ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($site_show_archive) { ?>
            <h2><?= lang('Default.members')?></h2>
            <div class="list">
                <?php foreach ($users as $user) { ?>
                    <div class="list-item mb-1">
                        <?= anchor('pages/user/' . $user->user_id, img(base_url() . '/writable/uploads/' . $user->user_image, false, ['style' => 'width: 26px; height: 26px; border-radius: 13px; vertical-align: middle;']) . " " . $user->user_fullname ) ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>


<?php $this->endSection() ?>