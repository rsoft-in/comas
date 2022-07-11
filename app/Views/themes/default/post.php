<?php

use CodeIgniter\I18n\Time;

$this->extend('themes/default/template') ?>
<?php $this->section('content') ?>
<script src="https://cdn.tiny.cloud/1/xgecatowhwzibnjrfw4oho6pdpzimfuyolx4oubiaosi9wf7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    function submitComment() {
        var editor = tinymce.get('comment-box');
        var user = $('#comment-user').val().replace(/[^a-zA-Z0-9 ]/g, "");
        var words = editor.plugins.wordcount.body.getWordCount();
        if (user.length == 0) {
            alert('Please enter your name!');
            return;
        }
        if (editor.getContent().length == 0) {
            alert('Please do not leave the comments empty!');
            return;
        }

        if (words > 100) {
            alert('Please write comments under 100 words only');
        } else {
            var ed = editor.getContent();
            var postdata = {
                'pid': '<?= $post->post_id ?>',
                'user': $('#comment-user').val().replace(/[^a-zA-Z0-9 ]/g, "")
            }
            postdata = JSON.stringify(postdata);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . '/' . index_page() ?>/pages/addComment",
                data: "postdata=" + postdata + "&ed=" + encodeURIComponent(editor.getContent()),
                success: function(result) {
                    if (result.indexOf('SUCCESS') >= 0) {
                        alert('Thank you for your valuable feedback!');
                        editModal.hide();
                        getPosts();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    }
</script>
<div class="mt-4">&nbsp;</div>
<?php if (!empty($post->post_feature_img)) { ?>
    <div class="mb-3">
        <?= img(base_url() . '/writable/uploads/' . $post->post_feature_img, false, ['alt' => $post->post_title, 'style' => 'width: 100%; height: 300px; object-fit: cover;']) ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-8">
        <div class="m-2">
            <h2 class="post"><?= $post->post_title ?></h2>
            <nav class="nav">
                <?= anchor('pages/category/' . $post->post_cg_id . '/1', "<i class=\"las la-layer-group\"></i>" . $post->cg_name, ['class' => 'nav-link']) ?>
                <?= anchor('pages/user/' . $post->post_author_id, "<i class=\"las la-user\"></i>" . $post->user_fullname, ['class' => 'nav-link']) ?>
                <a href="#comment" class="nav-link"><i class="bi bi-chat-left-text"></i> <?= $post->ncomments ?></a>
                <a class="nav-link disabled"><i class="bi bi-calendar-event"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?></a>
            </nav>
            <div class="article"><?= $post->post_content ?></div>
            <div class="mt-5">
                <h4 id="comment"><a>Comments</a></h4>
                <div class="mb-3">
                    <input type="text" class="form-control" id="comment-user" placeholder="Your name" maxlength="40">
                </div>
                <div>
                    <textarea id="comment-box"></textarea>
                </div>
                <table class="table">
                    <tr>
                        <td>
                            <div class="mt-2">
                                <button id="submit-comment" type="button" class="btn btn-secondary" onclick="submitComment();">Submit</button>
                            </div>
                        </td>
                        <td>
                            <div class="text-end text-muted"><small>(Not more than 100 words.)</small></div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="list-group mt-2">
                <?php foreach ($comments as $cmt) { ?>
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?= $cmt->cmt_user_id ?></h5>
                            <small><?= Time::parse($cmt->cmt_date)->toLocalizedString('MMM d, yyyy') ?></small>
                        </div>
                        <p class="mb-1"><?= $cmt->cmt_text ?></p>
                    </div>
                <?php } ?>
            </div>
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

<script>
    tinymce.init({
        selector: 'textarea#comment-box',
        statusbar: false,
        menubar: false,
        height: 200,
        plugins: 'wordcount',
        toolbar: 'undo redo bold italic alignleft aligncenter alignright outdent indent wordcount',
    });
</script>
<?php $this->endSection() ?>