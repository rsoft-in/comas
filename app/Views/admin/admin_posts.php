<?php $this->extend('admin/admin_template') ?>
<?php $this->section('content') ?>
<script src="https://cdn.tiny.cloud/1/xgecatowhwzibnjrfw4oho6pdpzimfuyolx4oubiaosi9wf7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    $(document).ready(function() {
        getPosts();
        getCategories();
        $('#f_image').change(function() {
            var inputFile = $('input[name=f_image]');
            var fileToUpload = inputFile[0].files[0];
            var formData = new FormData();
            formData.append("userfile", fileToUpload);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . '/' . index_page() ?>/admin/media/uploadImage",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#f_pfeatimage').val(data);
                    $('#f_preview').attr('src', '<?= base_url() ?>/writable/uploads/' + data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    hideProgress();
                    alert(errorThrown);
                }
            });
        });

        $('#search-qry').change(function() {
            pn = 0;
            getPosts();

        });
    });

    let sortby = 'post_title';
    let pn = 0;
    let data = [];
    let comments = [];

    function getCategories() {
        var postdata = {
            'sort': 'cg_name',
            'qry': '',
            'pn': pn
        }
        postdata = JSON.stringify(postdata);
        console.log(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/categories/getCategories",
            data: "postdata=" + postdata,
            success: function(cat) {
                for (let i = 0; i < cat.categories.length; i++) {
                    $('#f_pcgid').append("<option value=\"" + cat.categories[i].cg_id + "\">" + cat.categories[i].cg_name + "</option>");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }

    function getPosts() {
        var postdata = {
            'sort': sortby,
            'qry': $('#search-qry').val(),
            'pn': pn
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/posts/getPosts",
            data: "postdata=" + postdata,
            success: function(result) {
                data = result;
                if (data.posts.length > 0)
                    $('.no-result').hide();
                else
                    $('.no-result').show();

                $('#posts-list').empty();
                $('#posts-list').append(generateTable(data));
                // $(document).updatenav();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }

    function generateTable(data) {
        var _html = "";
        for (let i = 0; i < data.posts.length; i++) {
            _html += "<div class=\"card mb-3\">\n" +
                "<div class=\"card-body\">\n" +
                "<h5 class=\"card-title\">" + data.posts[i].post_title + "</h5>\n" +
                "<h6 class=\"card-subtitle mb-2 text-muted\">" +
                "<i class=\"bi bi-collection\"></i><span>" + data.posts[i].cg_name + "</span>" +
                "<i class=\"bi bi-calendar4\"></i><span>" + data.posts[i].post_modified + "</span>" +
                "<i class=\"bi bi-eye\"></i><span>" + data.posts[i].post_visited + "</span></h6>\n" +
                "<p class=\"card-text\"><i class=\"bi bi-person\"></i>" + data.posts[i].user_fullname + "</p>\n" +
                <?php if ($_SESSION['user_level'] >= 2) { ?> "<a href=\"#\" class=\"card-link\" onclick=\"onEdit('" + data.posts[i].post_id + "')\">Edit</a>\n" +
                    "<a href=\"#\" class=\"card-link\" onclick=\"onDelete('" + data.posts[i].post_id + "')\">Delete</a>\n"
        <?php } else { ?>
                "<span></span>"
        <?php } ?>
            +
            "<a href=\"#\" class=\"card-link\" onclick=\"onComments('" + data.posts[i].post_id + "')\">" + data.posts[i].ncomments + " Comments</a>\n" +
            "<div class=\"float-end\">" + (data.posts[i].post_published == 1 ?
                "<span class=\"m badge text-bg-success\">Published</span>" : " <span class=\"badge text-bg-danger\">Unpublished</span>") +
            "</div>\n" +
            "</div>\n" +
            "</div>\n";
        }
        return _html;
    }

    function add() {
        $(document).resetError();
        $('#f_pid').val('');
        $('#f_ptitle').val('');
        tinymce.get('f-pcontent').setContent('');
        $('#f_pfeatimage').val('');
        $('#f_p_tags').val('');
        $('#f_pcgid').val('');
        $('#f_ppublished').prop('checked', false);
        $('#f_preview').attr('src', '');

    }

    function onEdit(id) {
        var row = data.posts.find((e) => {
            return e.post_id == id;
        });
        $(document).resetError();
        $('#f_pid').val(row.post_id);
        $('#f_ptitle').val(row.post_title);
        tinymce.get('f-pcontent').setContent(row.post_content);
        $('#f_pfeatimage').val(row.post_feature_img);
        $('#f_p_tags').val(row.post_tags);
        $('#f_pcgid').val(row.post_cg_id);
        $('#f_ppublished').prop('checked', row.post_published == '1');
        if (row.post_feature_img != '')
            $('#f_preview').attr('src', '<?= base_url() ?>/writable/uploads/' + row.post_feature_img);
        editModal.show();
    }

    function save() {
        var valid = $(document).validate();
        if (!valid) return;
        var ed = tinymce.get('f-pcontent').getContent();
        var postdata = {
            'p_id': $('#f_pid').val(),
            'p_title': $('#f_ptitle').val(),
            'p_fimage': $('#f_pfeatimage').val(),
            'p_cgid': $('#f_pcgid').val(),
            'p_tags': $('#f_p_tags').val(),
            'p_published': $('#f_ppublished').is(":checked")
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/posts/update",
            data: "postdata=" + postdata + "&ed=" + encodeURIComponent(ed),
            success: function(result) {
                if (result.indexOf('SUCCESS') >= 0) {
                    showToast("Successfully saved!");
                    editModal.hide();
                    getPosts();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }

    function onDelete(id) {
        if (confirm('<?php echo lang('Default.confirm_delete') ?>')) {
            var postdata = {
                'id': id
            }
            postdata = JSON.stringify(postdata);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . '/' . index_page() ?>/admin/posts/delete",
                data: "postdata=" + postdata,
                success: function(result) {
                    if (result.indexOf('SUCCESS') >= 0) {
                        showToast("Successfully deleted!");
                        getPosts();
                    } else {
                        console.log(result);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
    }

    function onComments(id) {
        var postdata = {
            'sort': 'cmt_date DESC',
            'qry': id,
            'pn': 0
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/comments/getComments",
            data: "postdata=" + postdata,
            success: function(result) {
                console.log(result);
                $('#comments-list').empty();
                if (result.comments.length > 0) {
                    comments = result.comments;
                    $('#comments-list').append(generateCommentsTable(result));
                }
                commentsModal.show();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });

    }

    function generateCommentsTable(data) {
        var _html = "";
        for (let i = 0; i < data.comments.length; i++) {
            _html += "<div class=\"card mb-3\">\n" +
                "<div class=\"card-body\">\n" +
                "<h5 class=\"card-title\">" + data.comments[i].cmt_user_id + "</h5>\n" +
                "<h6 class=\"card-subtitle mb-2 text-muted\"><i class=\"bi bi-calendar4\"></i><span>" + data.comments[i].cmt_date + "</h6>\n" +
                "<p class=\"card-text\">" + data.comments[i].cmt_text + "</p>\n" +
                "<div class=\"form-check form-switch\">" +
                "<input class=\"form-check-input\" type=\"checkbox\" role=\"switch\" id=\"published-" + i + "\" " + (data.comments[i].cmt_published == 1 ? "checked" : "") + " onclick=\"togglePublish(this, \'" + data.comments[i].cmt_id + "\')\">" +
                "<label class=\"form-check-label\" for=\"published-" + i + "\">" + (data.comments[i].cmt_published == 1 ? "Published" : "Un-published") + "</label>" +
                "</div>" +
                "</div>\n" +
                "</div>\n" +
                "</div>\n";
        }
        return _html;
    }

    function togglePublish(obj, id) {
        var selected = ($(obj).is(':checked'));
        comments.find((e) => e.cmt_id == id).cmt_published = selected;
        $(obj).parent().children('label').html(selected ? 'Published' : 'Un-published');
        var postdata = {
            'id': id,
            'val': selected
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/comments/togglePublish",
            data: "postdata=" + postdata,
            success: function(result) {
                if (result.indexOf('SUCCESS') >= 0) {
                    console.log('UPDATED')
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }

    function onSort(fld) {
        sortby = fld;
        getPosts();
    }
</script>

<div class="mb-3">
    <div class="row">
        <div class="col">
            <div class="btn-group">
                <button type="button" class="btn btn-secondary"><?php echo lang('Default.sort_by') ?></button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="onSort('post_title')"><?php echo lang('Default.sort_by_title') ?></a></li>
                    <li><a class="dropdown-item" href="#" onclick="onSort('post_content')"><?php echo lang('Default.sort_by_content') ?></a></li>
                    <li><a class="dropdown-item" href="#" onclick="onSort('post_modified DESC')"><?php echo lang('Default.latest_first') ?></a></li>

                </ul>
            </div>
            <?php if ($_SESSION['user_level'] >= 2) { ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick='add()' data-bs-target="#edit-modal"><?php echo lang('Default.add') ?></button>
            <?php } ?>
        </div>
        <div class="col">
            <input type="text" id="search-qry" class="form-control" placeholder="Search">
        </div>
    </div>
</div>

<div class="" id="posts-list"></div>

<div class="text-center no-result">
    <img src="<?= base_url() ?>/assets/no-result.jpg" alt="" style="width: 150px;">
    <p class="fs-5"><?php echo lang('Default.no_data') ?></p>
</div>

<div class="modal" id="edit-modal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo lang('Default.edit') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="f_pid">
                <input type="hidden" id="f_pfeatimage">
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <label for="f_ptitle" class="form-label"><?php echo lang('Default.title') ?></label>
                            <input type="text" id="f_ptitle" class="form-control required" aria-describedby="passwordHelpBlock" maxlength="250">
                            <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <label for="f_pcgid" class="form-label"><?php echo lang('Default.category') ?></label>
                            <select id="f_pcgid" class="form-select">
                                <option value=""><?php echo lang('Default.select_a_category') ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="f_image" class="form-label"><?php echo lang('Default.feature_image') ?></label>
                            <input class="form-control" type="file" name="f_image" id="f_image">
                        </div>
                    </div>
                    <div class="col-3">
                        <img src="" id="f_preview" alt="" style="width: 100%; max-width: 200px;">
                    </div>
                    <div class="col">
                        <div class="mt-5 form-check">
                            <input type="checkbox" class="form-check-input" id="f_ppublished">
                            <label class="form-check-label" for="f_ppublished"><?php echo lang('Default.published') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <label for="f_p_tags" class="form-label"><?php echo lang('Default.post_tags') ?></label>
                            <input type="text" id="f_p_tags" class="form-control" aria-describedby="passwordHelpBlock" maxlength="250">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-4">
                        </div>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <textarea id="f-pcontent"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('Default.close') ?></button>
                <button type="button" class="btn btn-primary" onclick="save();"><?php echo lang('Default.save') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="comments-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo lang('Default.comments') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" id="comments-list"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('Default.close') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: 'textarea#f-pcontent',
        statusbar: false,
        plugins: 'code',
        toolbar: 'undo redo styles bold italic alignleft aligncenter alignright outdent indent code'
    });

    const editModal = new bootstrap.Modal(document.getElementById('edit-modal'), {});
    const commentsModal = new bootstrap.Modal(document.getElementById('comments-modal'), {});
</script>

<?php $this->endSection() ?>