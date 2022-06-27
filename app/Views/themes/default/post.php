<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<div class="row">
    <div class="col-large">
        <div class="m-2">
            <h2><?= $post->post_title ?></h2>
            <div class="author">
                <table>
                    <tr>
                        <td>
                            <?= anchor('#', "<i class=\"las la-layer-group\"></i>" . $post->cg_name) . anchor('#', "<i class=\"las la-user\"></i>" . $post->post_author_id) ?>
                        </td>
                        <td class="text-end">
                            <?= anchor('#', "<i class=\"las la-comment\"></i>" . $post->ncomments) ?>
                            <i class="las la-calendar"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="article"><?= $post->post_content ?></div>
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
<?php $this->endSection() ?>