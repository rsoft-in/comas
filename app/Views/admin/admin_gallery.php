<?php $this->extend('admin/admin_template') ?>
<?php $this->section('content') ?>
<script>
    $(document).ready(function() {
        getGallery();
        $('#f_image').change(function() {
            var inputFile = $('input[name=f_image]');
            var fileToUpload = inputFile[0].files[0];
            var formData = new FormData();
            formData.append("userfile", fileToUpload);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . '/' . index_page() ?>/admin/gallery/uploadGallery",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    alert(data);
                    images.push({
                        'image': data,
                        'desc': 'new image',
                    });
                    listImages();
                    // $('#f_pfeatimage').val(data);
                    // $('#f_preview').attr('src', '<?= base_url() ?>/writable/uploads/' + data);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    hideProgress();
                    alert(errorThrown);
                }
            });
        });
    });
    let sortby = 'gallery_name';
    let pn = 0;
    let data = [];
    let images = [];

    function getGallery() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/gallery/get",
            data: "",
            success: function(result) {
                data = result;
                if (data.galleries.length > 0)
                    $('.no-result').hide();
                else
                    $('.no-result').show();

                $('#gallery-list').empty();
                $('#gallery-list').append(generateTable(data));

                // for (let i = 0; i < result.files.length; i++) {
                //     $('#gallery').append("<div class='col'>" +
                //         "<div class='card'>" +
                //         "<img class='card-img-top' src='<?= base_url() ?>/writable/uploads/" + result.files[i] + "' alt=''/>" +
                //         "<div class='card-body'>" + result.files[i] + "</div>" +
                //         "</div></div>")
                // }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }

    function listImages() {
        $('#image-list').html('');
        $('#image-list').html("<table class='table'><tbody></tbody></table>");
        for (let i = 0; i < images.length; i++) {
            $('#image-list').append("<tr><td class='my-3'>" +
                "<img src='<?= base_url() . '/writable/uploads/gallery/' ?>" + images[i].image + "' style='width: 100px;'>" +
                "</td><td>" +
                "<input type='text' class='image-desc' value='" + images[i].desc + "' id='image-" + i + "'>" +
                "</td>" +
                "</tr>");
        }
    }

    function generateTable(data) {
        var _html = "";
        for (let i = 0; i < data.galleries.length; i++) {
            _html += "<div class=\"card mb-3\">\n" +
                "<div class=\"card-body\">\n" +
                "<h5 class=\"card-title\">" + data.galleries[i].gallery_name + "</h5>\n" +
                "<h6 class=\"card-subtitle mb-2 text-muted\">" +
                "<span>" + data.galleries[i].gallery_desc + "</span></h6>\n" +

                "<a href=\"#\" class=\"card-link\" onclick=\"onEdit('" + data.galleries[i].gallery_id + "')\">Edit</a>\n" +
                "<a href=\"#\" class=\"card-link\" onclick=\"onDelete('" + data.galleries[i].gallery_id + "')\">Delete</a>\n" +
                "</div>\n" +
                "</div>\n";
        }
        return _html;
    }

    function add() {
        $(document).resetError();
        $('#f_gid').val('');
        $('#f_gname').val('');
        $('#f_gdesc').val('');
        images = [];
        $('#image-list').html('');
    }

    function onEdit(id) {
        var row = data.galleries.find((e) => {
            return e.gallery_id == id;
        });
        $(document).resetError();
        $('#f_gid').val(row.gallery_id);
        $('#f_gname').val(row.gallery_name);
        $('#f_gdesc').val(row.gallery_desc);
        images = JSON.parse(row.gallery_items);
        listImages();
        $('#f_gname').focus();
        editModal.show();
    }

    function save() {
        var valid = $(document).validate();
        if (!valid) return;
        var nItems = $('.image-desc').length;
        alert(nItems);
        for (let i = 0; i < nItems; i++) {
            images[i].desc = $('#image-' + i).val();
        }
        var items = JSON.stringify(images);
        var postdata = {
            'id': $('#f_gid').val(),
            'name': $('#f_gname').val(),
            'desc': $('#f_gdesc').val(),
            'items': items
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/gallery/update",
            data: "postdata=" + postdata,
            success: function(result) {
                if (result.indexOf('SUCCESS') >= 0) {
                    showToast("Successfully saved!");
                    editModal.hide();
                    getGallery();
                } else {
                    console.log(result);
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
                url: "<?php echo base_url() . '/' . index_page() ?>/admin/gallery/delete",
                data: "postdata=" + postdata,
                success: function(result) {
                    if (result.indexOf('SUCCESS') >= 0) {
                        showToast("Successfully deleted!");
                        getGallery();
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
</script>
<div class="mb-3">
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" onclick='add()' data-bs-target="#edit-modal"><?php echo lang('Default.add') ?></button>
</div>
<div class="" id="gallery-list"></div>
<div class="text-center no-result">
    <img src="<?= base_url() ?>/assets/no-result.jpg" alt="" style="width: 150px;">
    <p class="fs-5"><?php echo lang('Default.no_data') ?></p>
</div>

<div class="modal" id="edit-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo lang('Default.edit') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="f_gid">
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <label for="f_gname" class="form-label"><?php echo lang('Default.name') ?></label>
                            <input type="text" id="f_gname" class="form-control required" maxlength="50">
                            <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <label for="f_gdesc" class="form-label"><?php echo lang('Default.description') ?></label>
                            <textarea id="f_gdesc" class="form-control required" rows="3" maxlength="250"></textarea>
                            <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="f_image" class="form-label"><?php echo lang('Default.add_to_gallery') ?></label>
                            <input class="form-control" type="file" name="f_image" id="f_image">
                        </div>
                    </div>
                </div>
                <div class="" id="image-list"></div>
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