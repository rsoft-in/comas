<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<div class="row">
    <div class="col-large">
        <?php if ($site_isblog) { ?>
            <h2>Recent Posts</h2>
            <div class="list">
                <?php foreach ($posts as $post) { ?>
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

            <table>
                <tr>
                    <td style="width: 50%;" class="text-end">
                        <?= ($current_page > 1 ? anchor('pages/posts/' . ($current_page - 1), "<i class=\"las la-angle-left\"></i> Previous") : '&nbsp;') ?></td>
                    <td><div class="ml-2 mr-2">...</div></td>
                    <td style="width: 50%;" class="">
                        <?= ($current_page < $next_page ? anchor('pages/posts/' . $next_page, "Next <i class=\"las la-angle-right\"></i>") : '&nbsp;') ?></td>
                </tr>
            </table>
        <?php } ?>
    </div>
    <div class="col-small">
        <?php if ($site_show_categories) { ?>
            <h2>Categories</h2>
            <div class="list">
                <?php foreach ($site_categories as $cat) { ?>
                    <div class="list-item">
                        <?= anchor('#', $cat->cg_name) ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($site_show_archive) { ?>
            <h2>Archive</h2>
            <div class="list">
                <?php foreach ($site_archives as $archive) { ?>
                    <div class="list-item">
                        <?= anchor('#', Time::createFromDate($archive->year, $archive->month, 1)->toLocalizedString('MMM yyyy') . ' (' . $archive->nposts . ')') ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>


<?php $this->endSection() ?>