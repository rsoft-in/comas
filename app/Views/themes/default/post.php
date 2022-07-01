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
<div class="row">
    <div class="col-large">
        <div class="m-2">
            <h2><?= $post->post_title ?></h2>
            <div class="author">
                <table>
                    <tr>
                        <td>
                            <?= anchor('pages/category/' . $post->post_cg_id . '/1', "<i class=\"las la-layer-group\"></i>" . $post->cg_name) . anchor('#', "<i class=\"las la-user\"></i>" . $post->user_fullname) ?>
                        </td>
                        <td class="text-end">
                            <a href="#comment"><i class="las la-comment"></i> <?= $post->ncomments?></a>
                            <i class="las la-calendar"></i> <?= Time::parse($post->post_modified)->toLocalizedString('MMM d, yyyy') ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="article"><?= $post->post_content ?></div>
            <div>
                <h3 id="comment"><a>Comments</a></h3>
                <div>
                    <input type="text" id="comment-user" placeholder="Your name" maxlength="40">
                </div>
                <div>
                    <textarea id="comment-box"></textarea>
                </div>
                <table>
                    <tr>
                        <td>
                            <div class="mt-2">
                                <button id="submit-comment" type="button" onclick="submitComment();">Submit</button>
                            </div>
                        </td>
                        <td>
                            <div class="text-end muted" style="padding: 5px;">(Not more than 100 words.)</div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="list mt-2">
                <?php foreach ($comments as $cmt) { ?>
                    <div class="p-2" style="border-top: 1px solid #e5e5e5;">
                        <div class="p-1"><strong><?= $cmt->cmt_user_id ?></strong> | <span class="muted"><?= Time::parse($cmt->cmt_date)->toLocalizedString('MMM d, yyyy') ?></span></div>
                        <div class="p-1"><?= $cmt->cmt_text ?></div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-small">
        <h2><?= lang('Default.categories')?></h2>
        <div class="list">
            <?php foreach ($site_categories as $cat) { ?>
                <div class="list-item">
                    <?= anchor('pages/category/' . $cat->cg_id . '/1', $cat->cg_name) ?>
                </div>
            <?php } ?>
        </div>
        <h2><?= lang('Default.archive')?></h2>
        <div class="list">
            <?php foreach ($site_archives as $archive) { ?>
                <div class="list-item">
                    <a href="#"><?= Time::createFromDate($archive->year, $archive->month, 1)->toLocalizedString('MMM yyyy') . ' (' . $archive->nposts . ')' ?></a>
                </div>
            <?php } ?>
        </div>

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