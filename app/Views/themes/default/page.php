<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<div class="row">
    <div class="col-large">
        <div class="m-2">
            <h2><?= $page->page_title ?></h2>
            <!-- <div class="author">
                <table>
                    <tr>
                        <td>
                            <div class="divider-right"><a href="#"><i class="las la-layer-group"></i><?= $page->cg_name ?></a></div>
                            <a href="#" class="ml-1"><i class="las la-user"></i><?= $page->page_author_id ?></a>
                        </td>
                        <td class="text-end"><i class="las la-calendar"></i> <?= Time::parse($page->page_modified)->toLocalizedString('MMM d, yyyy') ?></td>
                    </tr>
                </table>
            </div> -->
            <div class="article"><?= $page->page_content ?></div>
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