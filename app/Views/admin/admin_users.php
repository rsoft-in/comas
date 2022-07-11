<?php $this->extend('admin/admin_template') ?>
<?php $this->section('content') ?>
<script src="https://cdn.tiny.cloud/1/xgecatowhwzibnjrfw4oho6pdpzimfuyolx4oubiaosi9wf7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    $(document).ready(function() {
        getUsers();

        $('#f_uimage').change(function() {
            var inputFile = $('input[name=f_uimage]');
            var fileToUpload = inputFile[0].files[0];
            var formData = new FormData();
            formData.append("userfile", fileToUpload);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . '/' . index_page() ?>/admin/gallery/profileImage",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#f_usrimage').val(data);
                    $('#f_preview').attr('src', '<?= base_url() ?>/writable/uploads/' + data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });
    });
    let sortby = 'user_name';
    let pn = 0;
    let data = [];

    function getUsers() {
        var postdata = {
            'sort': sortby,
            'qry': '',
            'pn': pn
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/users/getUsers",
            data: "postdata=" + postdata,
            success: function(result) {
                data = result;
                if (data.users.length > 0)
                    $('.no-result').hide();
                else
                    $('.no-result').show();
                $('#users-list').empty();
                $('#users-list').append(generateTable(data));
                // $(document).updatenav();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }

    function generateTable(data) {
        var _html = "";
        for (let i = 0; i < data.users.length; i++) {
            _html += "<div class=\"card mb-3\">\n" +
                "<div class=\"card-body\">\n" +
                "<h5 class=\"card-title\"><img style=\"width: 30px; height: 30px; border-radius: 15px\" src=\"<?= base_url() ?>/writable/uploads/" + data.users[i].user_image + "\"> " + data.users[i].user_fullname + "</h5>\n" +
                "<h6 class=\"card-subtitle mt-2 mb-2 text-muted\">" +
                "<i class=\"bi bi-collection\"></i><span>" + data.users[i].user_name + "</span>" +
                "<i class=\"bi bi-calendar4\"></i><span>" + data.users[i].user_modified + "</span></h6>\n" +
                (data.users[i].user_email != '' ?
                    "<p class=\"card-text\"><i class=\"bi bi-envelope\"></i><span>" + data.users[i].user_email + "<span></p>\n" : '') +
                "<p class=\"card-text\">" +
                "<i class=\"bi bi-shield-lock\"></i><span>" + userRole(data.users[i].user_level) + "<span>" +
                <?php if ($_SESSION['user_level'] == 5) { ?> "<span> (" + data.users[i].user_pwd + ")</span>"
                <?php } else { ?>
                        "<span></span>"
                <?php } ?> +
            "</p>\n" +
            (data.users[i].user_level < 5 || <?= $_SESSION['user_level'] == 5 ? 'true' : 'false' ?> ?
                "<a href=\"#\" class=\"card-link\" onclick=\"onEdit('" + data.users[i].user_id + "')\">Edit</a>\n" +
                "<a href=\"#\" class=\"card-link\" onclick=\"onDelete('" + data.users[i].user_id + "')\">Delete</a>\n" : "") +
            "</div>\n" +
            "</div>\n";
        }
        return _html;
    }

    function add() {
        $(document).resetError();
        $('#f_uid').val('');
        $('#f_uname').val('');
        $('#f_uname').prop('disabled', false);
        $('#f_upwd').val('');
        $('#f_ufullname').val('');
        $('#f_usrimage').val('');
        $('#f_preview').attr('src', '');
        $('#f_uemail').val('');
        $('#f_ulevel').val('0');
        tinymce.get('f_uabout').setContent('');
        $('#f_uinactive').prop('checked', false);
    }

    function onEdit(id) {
        $(document).resetError();
        var row = data.users.find((e) => {
            return e.user_id == id;
        });
        $('#f_uid').val(row.user_id);
        $('#f_uname').val(row.user_name);
        $('#f_uname').prop('disabled', true);
        $('#f_upwd').val(row.user_pwd);
        $('#f_ufullname').val(row.user_fullname);
        $('#f_uemail').val(row.user_email);
        $('#f_usrimage').val(row.user_image);
        $('#f_preview').attr('src', '<?= base_url() ?>/writable/uploads/' + row.user_image);
        tinymce.get('f_uabout').setContent(row.user_about);
        $('#f_uinactive').prop('checked', row.user_inactive == '1');
        $('#f_ulevel').val(row.user_level);
        editModal.show();

    }

    function save() {
        var valid = $(document).validate();
        if (!valid) return;
        var ed = tinymce.get('f_uabout').getContent();
        var postdata = {
            'u_id': $('#f_uid').val(),
            'u_name': $('#f_uname').val(),
            'u_pwd': $('#f_upwd').val(),
            'u_fullname': $('#f_ufullname').val(),
            'u_email': $('#f_uemail').val(),
            'u_image': $('#f_usrimage').val(),
            'u_inactive': $('#f_uinactive').is(":checked"),
            'u_level': $('#f_ulevel').val()
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/users/update",
            data: "postdata=" + postdata + "&ed=" + encodeURIComponent(ed),
            success: function(result) {
                if (result.indexOf('SUCCESS') >= 0) {
                    showToast("Successfully saved!");
                    editModal.hide();
                    getUsers();
                } else {
                    alert(result);
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
                url: "<?php echo base_url() . '/' . index_page() ?>/admin/users/delete",
                data: "postdata=" + postdata,
                success: function(result) {
                    if (result.indexOf('SUCCESS') >= 0) {
                        showToast("Successfully deleted!");
                        getUsers();
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

    function onSort(fld) {
        sortby = fld;
        getUsers();
    }
</script>

<div class="mb-3">
    <div class="btn-group">
        <button type="button" class="btn btn-secondary btn-sm"><?php echo lang('Default.sort_by') ?></button>
        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="onSort('user_name')"><?php echo lang('Default.sort_by_name') ?></a></li>
            <li><a class="dropdown-item" href="#" onclick="onSort('user_email')"><?php echo lang('Default.sort_by_email') ?></a></li>
            <li><a class="dropdown-item" href="#" onclick="onSort('user_modified DESC')"><?php echo lang('Default.latest_first') ?></a></li>

        </ul>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" onclick='add()' data-bs-target="#edit-modal"><?php echo lang('Default.add') ?></button>
</div>
<div class="" id="users-list"></div>
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
                <input type="hidden" id="f_uid">
                <input type="hidden" id="f_usrimage">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="f_uname" class="form-label"><?php echo lang('Default.username') ?></label>
                            <input type="text" id="f_uname" class="form-control required" maxlength="20">
                            <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="f_upwd" class="form-label"><?php echo lang('Default.password') ?></label>
                            <input type="password" id="f_upwd" class="form-control required" maxlength="15">
                            <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="f_ufullname" class="form-label"><?php echo lang('Default.fullname') ?></label>
                            <input type="text" id="f_ufullname" class="form-control required" maxlength="50">
                            <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="f_uemail" class="form-label"><?php echo lang('Default.email') ?></label>
                            <input type="text" id="f_uemail" class="form-control email">
                            <div class="invalid_email"><?php echo lang('Default.invalid_email') ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="f_ulevel" class="form-label"><?php echo lang('Default.user_role') ?></label>
                            <select id="f_ulevel" class="form-select">
                                <option value="0">No Access</option>
                                <option value="1">Moderator</option>
                                <option value="2">Editor</option>
                                <option value="3">Administrator</option>
                                <option value="5" <?= $_SESSION['user_level'] == 5 ? "" : "disabled" ?>>Super Admin</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="f_uimage" class="form-label"><?php echo lang('Default.profile_image') ?></label>
                            <input class="form-control" type="file" name="f_uimage" id="f_uimage">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <img src="" id="f_preview" alt="" style="width: 100px; height: 100px; border-radius: 50px;">
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <textarea id="f_uabout"></textarea>
                </div>
                <div class="mt-3 form-check">
                    <input type="checkbox" class="form-check-input" id="f_uinactive">
                    <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.inactive') ?></label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('Default.close') ?></button>
                <button type="button" class="btn btn-primary" onclick="save();"><?php echo lang('Default.save') ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    const editModal = new bootstrap.Modal(document.getElementById('edit-modal'), {});
    tinymce.init({
        selector: 'textarea#f_uabout',
        statusbar: false,
        menubar: false,
        height: 300,
        plugins: 'wordcount',
        toolbar: 'undo redo bold italic alignleft aligncenter alignright outdent indent wordcount',
    });
</script>

<?php $this->endSection() ?>