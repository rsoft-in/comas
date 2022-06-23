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
                                        <div class="divider-right"><?= anchor('#', "<i class=\"las la-layer-group\"></i>" . $post->cg_name) ?></div>
                                        <?= anchor('#', "<i class=\"las la-user\"></i>" . $post->post_author_id, ['class' => 'ml-1']) ?>
                                    </td>
                                    <td>
                                        <div class="text-end">
                                            <?= anchor('#', "<i class=\"las la-comment\"></i>6", ['class' => 'mr-1']) ?>
                                            <div class="divider-left"><i class="las la-calendar"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?></div>
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
    <div class="row">
        <div class="col-large">
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
                                                <div class="divider-right"><?= anchor('#', "<i class=\"las la-layer-group\"></i>" . $post->cg_name) ?></div>
                                                <?= anchor('#', "<i class=\"las la-user\"></i>" . $post->post_author_id, ['class' => 'ml-1']) ?>
                                            </td>
                                            <td>
                                                <div class="text-end">
                                                    <?= anchor('#', "<i class=\"las la-comment\"></i>6", ['class' => 'mr-1']) ?>
                                                    <div class="divider-left"><i class="las la-calendar"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?></div>
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
        </div>
        <div class="col-small">
            <?php if ($site_show_categories) { ?>
                <h2>Categories</h2>
                <div class="list">
                    <?php foreach ($site_categories as $cat) { ?>
                        <div class="list-item">
                            <?= anchor('#', $cat->cg_name)?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($site_show_archive) { ?>
                <h2>Archive</h2>
                <div class="list">
                    <?php foreach ($site_archives as $archive) { ?>
                        <div class="list-item">
                            <?= anchor('#', Time::createFromDate($archive->year, $archive->month, 1)->toLocalizedString('MMM yyyy') . ' (' . $archive->nposts . ')')?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

<?php } else { ?>
    <div></div>
<?php } ?>
<?php $this->endSection() ?>