<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<?php if ($site_isblog) { ?>
    <h2>Popular Posts</h2>
    <div class="row">
        <?php foreach ($site_posts_popular as $post) { ?>
            <div class="column">
                <div class="card link">
                    <h3><a href="#"><?= $post->post_title ?></a></h3>
                    <div class="cover">
                        <a href="#"><img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse4.mm.bing.net%2Fth%3Fid%3DOIP.Ix6XjMbuCvoq3EQNgJoyEQHaFj%26pid%3DApi&f=1" alt="<?= $post->post_title ?>"></a>
                    </div>
                    <div class="subtitle"><?= $post->cg_name ?> - <?= $post->post_author_id ?></div>
                    <div class="muted"><i class="las la-calendar"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?></div>
                    <p><?= substr($post->post_content, 0, 150) ?></p>
                    <div class="footer">
                        <a href="#">Read more</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <h2>Recent Posts</h2>
    <div class="list">
        <?php foreach ($site_posts_recent as $post) { ?>
            <div class="list-item link">
                <div class="leading">
                    <a href="#"><img src="https://static.remove.bg/remove-bg-web/eb1bb48845c5007c3ec8d72ce7972fc8b76733b1/assets/start-1abfb4fe2980eabfbbaaa4365a0692539f7cd2725f324f904565a9a744f8e214.jpg" alt="<?= $post->post_title ?>"></a>
                </div>
                <div class="list-content">
                    <h3><a href="#"><?= $post->post_title ?></a></h3>
                    <div class="subtitle"><?= $post->cg_name ?> - <?= $post->post_author_id ?></div>
                    <div class="muted"><i class="las la-calendar"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?></div>
                    <p><?= substr($post->post_content, 0, 150) ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div></div>
<?php } ?>
<?php $this->endSection() ?>