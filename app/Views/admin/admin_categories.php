<?php $this->extend('layouts/admin_template') ?>
<?php $this->section('content') ?>
<script>
  $(document).ready(function() {
    getCategories();

  });
  let sortby = 'cg_name';
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
        $('#pages-table tbody').empty();
        $('#pages-table').append(generateTable(data));
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
      _html += "<tr>\n" +
        "<td>" + data.categories[i].cg_name + "</td>\n" +
        "<td>" + data.categories[i].cg_desc + "</td>\n" +
        "<td class=\"text-end\">" +
        "<a class=\"ms-3\" href=\"#\" title='Edit' onclick=\"onEdit('" + data.categories[i].cg_id + "')\"><i class=\"bi bi-pencil\"></i></a>" +
        "<a class=\"ms-3\" href=\"#\" title='Delete' onclick=\"onDelete('" + data.categories[i].cg_id + "')\"><i class=\"bi bi-trash\"></i></a>" +
        "</td>" +
        "</tr>";
    }
    return _html;
  }

  function onAdd() {
    $('#f_cgid').val('');
    $('#f_cgname').val('');
    $('#f_cgdesc').val('');
    $('#f_cgname').focus();
  }

  function onEdit(id) {
    var row = data.categories.find((e) => {
      return e.cg_id == id;
    });
    $('#f_cgid').val(row.cg_id);
    $('#f_cgname').val(row.cg_name);
    $('#f_cgdesc').val(row.cg_desc);
    $('#f_cgname').focus();
    editModal.show();
  }

  function save() {
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
    if (confirm('<?php echo lang('Default.confirm_delete')?>')) {
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


<div class="p-2 text-end">
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" onclick='onAdd()' data-bs-target="#edit-modal">Add</button>
</div>
<table class="table" id="pages-table">
  <thead>
    <tr>
      <th scope="col"><?php echo lang('Default.name') ?></th>
      <th scope="col"><?php echo lang('Default.description') ?></th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<div class="modal" id="edit-modal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo lang('Default.edit') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="f_cgid">
        <div class="mb-2">
          <label for="f_cgname" class="form-label"><?php echo lang('Default.name') ?></label>
          <input type="text" id="f_cgname" class="form-control" maxlength="50">
        </div>
        <div class="mb-2">
          <label for="f_cgdesc" class="form-label"><?php echo lang('Default.description') ?></label>
          <textarea id="f_cgdesc" class="form-control" rows="3" maxlength="250"></textarea>
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