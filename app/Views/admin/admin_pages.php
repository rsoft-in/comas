<?php $this->extend('admin/admin_template') ?>
<?php $this->section('content') ?>
<script src="https://cdn.tiny.cloud/1/xgecatowhwzibnjrfw4oho6pdpzimfuyolx4oubiaosi9wf7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  $(document).ready(function() {
    getPages();
    getCategories();

    $('#f_ptitle').change(function() {
      $('#f_purlslug').val($(this).val().toLowerCase().replace(/ /g, '_').replace(/[^\w\s]/gi, ''));
    });

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
  });
  let sortby = 'page_title';
  let pn = 0;
  let data = [];

  function getCategories() {
    var postdata = {
      'sort': 'cg_name',
      'qry': '',
      'pn': pn
    }
    postdata = JSON.stringify(postdata);
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

  function getPages() {
    var postdata = {
      'sort': sortby,
      'qry': '',
      'pn': pn
    }
    postdata = JSON.stringify(postdata);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . '/' . index_page() ?>/admin/pages/getPages",
      data: "postdata=" + postdata,
      success: function(result) {
        data = result;
        if (data.pages.length > 0)
          $('.no-result').hide();
        else
          $('.no-result').show();

        $('#pages-list').empty();
        $('#pages-list').append(generateTable(data));
        // $(document).updatenav();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert(errorThrown);
      }
    });
  }

  function generateTable(data) {
    var _html = "";
    for (let i = 0; i < data.pages.length; i++) {
      _html += "<div class=\"card mb-3\">\n" +
        "<div class=\"card-body\">\n" +
        "<h5 class=\"card-title\">" + data.pages[i].page_title + "</h5>\n" +
        "<h6 class=\"card-subtitle mb-2 text-muted\">" +
        "<i class=\"bi bi-collection\"></i><span>" + data.pages[i].cg_name + "</span>" +
        "<i class=\"bi bi-calendar4\"></i><span>" + data.pages[i].page_modified + "</span>" +
        "<i class=\"bi bi-sort-up\"></i><span>" + data.pages[i].page_order + "</span></h6>\n" +
        "<p class=\"card-text\">" + data.pages[i].page_author_id + "</p>\n" +
        "<a href=\"#\" class=\"card-link\" onclick=\"onEdit('" + data.pages[i].page_id + "')\">Edit</a>\n" +
        "<a href=\"#\" class=\"card-link\" onclick=\"onDelete('" + data.pages[i].page_id + "')\">Delete</a>\n" +
        "<div class=\"float-end\">" + (data.pages[i].page_published == 1 ? "<span class=\"m badge text-bg-success\">Published</span>" : " <span class=\"badge text-bg-danger\">Unpublished</span>") +
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
    tinymce.get('f-page-editor').setContent('');
    $('#f_purlslug').val('');
    $('#f_porder').val('0');
    $('#f_pfeatimage').val('');
    $('#f_pcgid').val('');
    $('#f_ppublished').prop('checked', true);
    $('#f_preview').attr('src', '');

  }

  function onEdit(id) {
    var row = data.pages.find((e) => {
      return e.page_id == id;
    });
    $(document).resetError();
    $('#f_pid').val(row.page_id);
    $('#f_ptitle').val(row.page_title);

    tinymce.get('f-page-editor').setContent(row.page_content);
    $('#f_purlslug').val(row.page_url_slug);
    $('#f_porder').val(row.page_order);
    $('#f_pfeatimage').val(row.page_feat_image);
    $('#f_pcgid').val(row.page_cg_id);
    $('#f_ppublished').prop('checked', row.page_published == '1');
    if (row.page_feat_image != '')
      $('#f_preview').attr('src', '<?= base_url() ?>/writable/uploads/' + row.page_feat_image);
    editModal.show();
  }

  function save() {
    var valid = $(document).validate();
    if (!valid) return;
    var ed = tinymce.get('f-page-editor').getContent();
    var postdata = {
      'p_id': $('#f_pid').val(),
      'p_title': $('#f_ptitle').val(),
      'p_urlslug': $('#f_purlslug').val(),
      'p_order': $('#f_porder').val(),
      'p_fimage': $('#f_pfeatimage').val(),
      'p_cgid': $('#f_pcgid').val(),
      'p_published': $('#f_ppublished').is(":checked")
    }
    postdata = JSON.stringify(postdata);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . '/' . index_page() ?>/admin/pages/update",
      data: "postdata=" + postdata + "&ed=" + encodeURIComponent(ed),
      success: function(result) {
        if (result.indexOf('SUCCESS') >= 0) {
          showToast("Successfully saved!");
          editModal.hide();
          getPages();
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
        url: "<?php echo base_url() . '/' . index_page() ?>/admin/pages/delete",
        data: "postdata=" + postdata,
        success: function(result) {
          if (result.indexOf('SUCCESS') >= 0) {
            showToast("Successfully deleted!");
            getPages();
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
    getPages();
  }
</script>

<div class="mb-3">
  <div class="btn-group">
    <button type="button" class="btn btn-secondary btn-sm"><?php echo lang('Default.sort_by') ?></button>
    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
      <span class="visually-hidden">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="#" onclick="onSort('page_title')"><?php echo lang('Default.sort_by_title') ?></a></li>
      <li><a class="dropdown-item" href="#" onclick="onSort('cg_name')"><?php echo lang('Default.sort_by_category') ?></a></li>
      <li><a class="dropdown-item" href="#" onclick="onSort('page_modified DESC')"><?php echo lang('Default.latest_first') ?></a></li>
      <li><a class="dropdown-item" href="#" onclick="onSort('page_order')"><?php echo lang('Default.sort_by_page_order') ?></a></li>
    </ul>
  </div>
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" onclick='add()' data-bs-target="#edit-modal"><?php echo lang('Default.add') ?></button>
</div>

<div class="" id="pages-list"></div>
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
        <input type="hidden" id="f_pauthorid">
        <input type="hidden" id="f_pfeatimage">
        <div class="row">
          <div class="col">
            <div class="mb-2">
              <label for="f_ptitle" class="form-label"><?php echo lang('Default.title') ?></label>
              <input type="text" id="f_ptitle" class="form-control required" aria-describedby="passwordHelpBlock" maxlength="250">
              <div class="required_input">Please enter some text</div>
            </div>
          </div>
          <div class="col">
            <div class="mb-2">
              <label for="f_purlslug" class="form-label"><?php echo lang('Default.url_slug') ?></label>
              <input type="text" id="f_purlslug" class="form-control required" aria-describedby="passwordHelpBlock" maxlength="250">
              <div class="required_input">Please enter some text</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="mb-2">
              <label for="f_porder" class="form-label"><?php echo lang('Default.page_order') ?></label>
              <input type="number" id="f_porder" class="form-control required" aria-describedby="passwordHelpBlock" max="99" min="0">
              <div class="required_input">Please enter some text</div>
            </div>
          </div>
          <div class="col">
            <div class="mb-4">
              <label for="f_pcgid" class="form-label"><?php echo lang('Default.category') ?></label>
              <select id="f_pcgid" class="form-select">
                <option value="">Select a Category</option>
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
          <div class="col-3">
            <div class="mt-5 form-check">
              <input type="checkbox" class="form-check-input" id="f_ppublished">
              <label class="form-check-label" for="f_ppublished"><?php echo lang('Default.published') ?></label>
            </div>
          </div>
        </div>
        <textarea id="f-page-editor">

        </textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('Default.close') ?></button>
        <button type="button" class="btn btn-primary" onclick="save();"><?php echo lang('Default.save') ?></button>
      </div>
    </div>
  </div>
</div>
<script>
  tinymce.init({
    selector: 'textarea#f-page-editor',
    statusbar: false,
    plugins: 'code',
    toolbar: 'undo redo styles bold italic alignleft aligncenter alignright outdent indent code'
  });

  const editModal = new bootstrap.Modal(document.getElementById('edit-modal'), {});
</script>

<?php $this->endSection() ?>