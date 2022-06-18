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
                            <a href="#"><img src="<?= base_url() . '/writable/uploads/' . $post->post_feature_img ?>" alt="<?= $post->post_title ?>"></a>
                        </div>
                        <div class="content">
                            <h3><a href="#"><?= $post->post_title ?></a></h3>
                            <div class="post"><?= substr($post->post_content, 0, 150) ?></div>
                        </div>
                        <div class="card-footer">
                            <table>
                                <tr>
                                    <td>
                                        <div class="divider-right"><a href="#"><i class="las la-layer-group"></i><?= $post->cg_name ?></a></div>
                                        <a href="#" class="ml-1"><i class="las la-user"></i><?= $post->post_author_id ?></a>
                                    </td>
                                    <td>
                                        <div class="text-end">
                                            <a href="#" class="mr-1"><i class="las la-comment"></i>6</a>
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
                                    <a href="#"><img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse4.mm.bing.net%2Fth%3Fid%3DOIP.Ix6XjMbuCvoq3EQNgJoyEQHaFj%26pid%3DApi&f=1" alt="<?= $post->post_title ?>"></a>
                                </div>
                                <div class="content">
                                    <h3><a href="#"><?= $post->post_title ?></a></h3>
                                    <div class="post"><?= substr($post->post_content, 0, 150) ?></div>
                                </div>
                                <div class="card-footer">
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="divider-right"><a href="#"><i class="las la-layer-group"></i><?= $post->cg_name ?></a></div>
                                                <a href="#" class="ml-1"><i class="las la-user"></i><?= $post->post_author_id ?></a>
                                            </td>
                                            <td>
                                                <div class="text-end">
                                                    <a href="#" class="mr-1"><i class="las la-comment"></i>6</a>
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
            <h2>Categories</h2>
            <div class="list">
                <?php foreach ($site_categories as $cat) { ?>
                    <div class="list-item">
                        <a href="#"><?= $cat->cg_name ?></a>
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

<?php } else { ?>
    <div></div>
<?php } ?>
<?php $this->endSection() ?>