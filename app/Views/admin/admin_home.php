<?php $this->extend('admin/admin_template') ?>
<?php $this->section('content') ?>
<h4><?= 'Welcome ' . $user_name ?></h4>
<div class="row g-2">
    <div class="col-sm col-md-6 col-lg-4">
        <div class="card">
            <h5 class="card-header">Pages</h5>
            <div class="card-body">
                <h5 class="card-title">Create and Manage Site Pages</h5>
                <p class="card-text fw-light"><?= $page_count ?> Pages</p>
                <a href="<?= base_url() . '/' . index_page() ?>/admin/pages" class="btn btn-primary">Open</a>
            </div>
        </div>
    </div>
    <div class="col-sm col-md-6 col-lg-4">
        <div class="card">
            <h5 class="card-header">Posts</h5>
            <div class="card-body">
                <h5 class="card-title">Create and Manage Posts</h5>
                <p class="card-text fw-light"><?= $post_count ?> Posts</p>
                <a href="<?= base_url() . '/' . index_page() ?>/admin/posts" class="btn btn-primary">Open</a>
            </div>
        </div>
    </div>
    <div class="col-sm col-md-6 col-lg-4">
        <div class="card">
            <h5 class="card-header">Users</h5>
            <div class="card-body">
                <h5 class="card-title">Create and Manage Users</h5>
                <p class="card-text fw-light"><?= $user_count ?> Users</p>
                <a href="<?= base_url() . '/' . index_page() ?>/admin/users" class="btn btn-primary">Open</a>
            </div>
        </div>
    </div>
    <div class="col-sm col-md-6 col-lg-4">
        <div class="card">
            <h5 class="card-header">Comments</h5>
            <div class="card-body">
                <h5 class="card-title">Publish and Manage Comments</h5>
                <p class="card-text fw-light"><?= $comment_count ?> Unpublished Comments</p>
                <a href="<?= base_url() . '/' . index_page() ?>/admin/posts" class="btn btn-primary">Open</a>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>