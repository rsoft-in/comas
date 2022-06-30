<?php $this->extend('admin/admin_template') ?>
<?php $this->section('content') ?>
<script>
    $(document).ready(function() {
        getUsers();
        $('#f_upwd').change(function() {
            pwdNew = true;
        });
    });
    let sortby = 'user_name';
    let pn = 0;
    let data = [];
    let pwdNew = false;

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
                "<h5 class=\"card-title\">" + data.users[i].user_fullname + "</h5>\n" +
                "<h6 class=\"card-subtitle mb-2 text-muted\">" +
                "<i class=\"bi bi-collection\"></i><span>" + data.users[i].user_name + "</span>" +
                "<i class=\"bi bi-calendar4\"></i><span>" + data.users[i].user_modified + "</span></h6>\n" +
                "<p class=\"card-text\"><i class=\"bi bi-envelope\"></i><span>" + data.users[i].user_email + "<span></p>\n" +
                "<a href=\"#\" class=\"card-link\" onclick=\"onEdit('" + data.users[i].user_id + "')\">Edit</a>\n" +
                "<a href=\"#\" class=\"card-link\" onclick=\"onDelete('" + data.users[i].user_id + "')\">Delete</a>\n" +
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
        $('#f_uemail').val('');
        $('#f_uabout').val('');
        $('#f_uinactive').prop('checked', false);
        pwdNew = true;

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
        $('#f_uabout').val(row.user_about);
        $('#f_uinactive').prop('checked', row.user_inactive == '1');
        pwdNew = false;
        editModal.show();

    }

    function save() {
        var valid = $(document).validate();
        if (!valid) return;
        var postdata = {
            'u_id': $('#f_uid').val(),
            'u_name': $('#f_uname').val(),
            'u_pwd': $('#f_upwd').val(),
            'u_fullname': $('#f_ufullname').val(),
            'u_email': $('#f_uemail').val(),
            'u_about': $('#f_uabout').val(),
            'u_inactive': $('#f_uinactive').is(":checked"),
            'pwd_new': pwdNew
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/users/update",
            data: "postdata=" + postdata,
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo lang('Default.edit') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="f_uid">
                <div class="mb-2">
                    <label for="f_uname" class="form-label"><?php echo lang('Default.username') ?></label>
                    <input type="text" id="f_uname" class="form-control required" maxlength="20">
                    <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                </div>
                <div class="mb-2">
                    <label for="f_upwd" class="form-label"><?php echo lang('Default.password') ?></label>
                    <input type="password" id="f_upwd" class="form-control required" maxlength="15">
                    <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                </div>
                <div class="mb-2">
                    <label for="f_ufullname" class="form-label"><?php echo lang('Default.fullname') ?></label>
                    <input type="text" id="f_ufullname" class="form-control required" maxlength="50">
                    <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                </div>
                <div class="mb-2">
                    <label for="f_uemail" class="form-label"><?php echo lang('Default.email') ?></label>
                    <input type="text" id="f_uemail" class="form-control email">
                    <div class="invalid_email"><?php echo lang('Default.invalid_email') ?></div>
                </div>
                <div class="mb-2">
                    <label for="f_uabout" class="form-label"><?php echo lang('Default.about') ?></label>
                    <input type="text" id="f_uabout" class="form-control" maxlength="250">

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
</script>

<?php $this->endSection() ?>