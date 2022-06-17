<?php $this->extend('layouts/admin_template') ?>
<?php $this->section('content') ?>
<script>
  $(document).ready(function() {
    getCategories();

  });
  let sortby = 'cg_modified DESC';
  let pn = 0;
  let data = [];

  function getCategories() {
    var postdata = {
      'sort': sortby,
      'qry': '',
      'pn': pn
    }
    postdata = JSON.stringify(postdata);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . '/' . index_page() ?>/admin/categories/getCategories",
      data: "postdata=" + postdata,
      success: function(result) {
        data = result;
        if (data.categories.length > 0)
          $('.no-result').hide();
        else
          $('.no-result').show();


        $('#category-list').empty();
        $('#category-list').append(generateTable(data));
        // $(document).updatenav();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert(errorThrown);
      }
    });
  }

  function generateTable(data) {
    var _html = "";
    for (let i = 0; i < data.categories.length; i++) {
      _html += "<div class=\"card mb-3\">\n" +
        "<div class=\"card-body\">\n" +
        "<h5 class=\"card-title\">" + data.categories[i].cg_name + "</h5>\n" +
        "<h6 class=\"card-subtitle mb-2 text-muted\">" +
        "<span>" + data.categories[i].cg_desc + "</span></h6>\n" +

        "<a href=\"#\" class=\"card-link\" onclick=\"onEdit('" + data.categories[i].cg_id + "')\">Edit</a>\n" +
        "<a href=\"#\" class=\"card-link\" onclick=\"onDelete('" + data.categories[i].cg_id + "')\">Delete</a>\n" +
        "</div>\n" +
        "</div>\n";
    }
    return _html;
  }


  function add() {
    $(document).resetError();
    $('#f_cgid').val('');
    $('#f_cgname').val('');
    $('#f_cgdesc').val('');
    $('#f_cgname').focus();
  }

  function onEdit(id) {
    var row = data.categories.find((e) => {
      return e.cg_id == id;
    });
    $(document).resetError();
    $('#f_cgid').val(row.cg_id);
    $('#f_cgname').val(row.cg_name);
    $('#f_cgdesc').val(row.cg_desc);
    $('#f_cgname').focus();
    editModal.show();
  }

  function save() {
    var valid = $(document).validate();
    if (!valid) return;
    var postdata = {
      'id': $('#f_cgid').val(),
      'name': $('#f_cgname').val(),
      'desc': $('#f_cgdesc').val(),
    }
    postdata = JSON.stringify(postdata);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . '/' . index_page() ?>/admin/categories/" + ($('#f_cgid').val() == '' ? 'addCategory' : 'updateCategory'),
      data: "postdata=" + postdata,
      success: function(result) {
        console.log(result);
        if (result.indexOf('SUCCESS') >= 0) {
          editModal.hide();
          getCategories();
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
        url: "<?php echo base_url() . '/' . index_page() ?>/admin/categories/deleteCategory",
        data: "postdata=" + postdata,
        success: function(result) {
          if (result.indexOf('SUCCESS') >= 0) {
            getCategories();
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
<div class="" id="category-list"></div>
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
        <input type="hidden" id="f_cgid">
        <div class="mb-2">
          <label for="f_cgname" class="form-label"><?php echo lang('Default.name') ?></label>
          <input type="text" id="f_cgname" class="form-control required" maxlength="50">
          <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
        </div>
        <div class="mb-2">
          <label for="f_cgdesc" class="form-label"><?php echo lang('Default.description') ?></label>
          <textarea id="f_cgdesc" class="form-control required" rows="3" maxlength="250"></textarea>
          <div class="required_input"><?php echo lang('Default.enter_some_text') ?></div>
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