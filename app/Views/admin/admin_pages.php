<?php $this->extend('layouts/admin_template') ?>
<?php $this->section('content') ?>
<script src="https://cdn.tiny.cloud/1/xgecatowhwzibnjrfw4oho6pdpzimfuyolx4oubiaosi9wf7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  $(document).ready(function() {
    getPages();

    $('#f_ptitle').change(function() {
      $('#f_purlslug').val($(this).val().toLowerCase().replace(/ /g, '_').replace(/[^\w\s]/gi, ''));
    });
  });
  let sortby = 'page_title';
  let pn = 0;
  let data = [];

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
    for (let i = 0; i < data.pages.length; i++) {
      _html += "<tr>\n" +
        "<td>" + data.pages[i].page_title + "</td>\n" +
        "<td>" + data.pages[i].page_url_slug + "</td>\n" +
        "<td>" + data.pages[i].page_order + "</td>\n" +
        "<td>" + (data.pages[i].page_published == 1 ? "<i class=\"bi bi-check2\"></i>" : "") + "</td>\n" +
        "<td class=\"text-end\">" +
        "<a class=\"ms-3\" href=\"#\" title='Edit' onclick=\"edit('" + data.pages[i].page_id + "')\"><i class=\"bi bi-pencil\"></i></a>" +
        "<a class=\"ms-3\" href=\"#\" title='Delete' onclick=\"delete('" + data.pages[i].page_id + "')\"><i class=\"bi bi-trash\"></i></a>" +
        "</td>" +
        "</tr>";
    }
    return _html;
  }

  function add() {

    $('#f_pid').val('');
    $('#f_ptitle').val('');
    tinymce.get('f-page-editor').setContent('');
    $('#f_purlslug').val('');
    $('#f_porder').val('0');
    $('#f_pfeatimage').val('');
    $('#f_pcgid').val('');
    $('#f_ppublished').prop('checked', true);

  }

  function edit(id) {
    var row = data.pages.find((e) => {
      return e.page_id == id;
    });

    $('#f_pid').val(row.page_id);
    $('#f_ptitle').val(row.page_title);

    tinymce.get('f-page-editor').setContent(row.page_content);
    $('#f_purlslug').val(row.page_url_slug);
    $('#f_porder').val(row.page_order);
    $('#f_pfeatimage').val(row.page_feat_image);
    $('#f_pcgid').val(row.page_cg_id);
    $('#f_ppublished').prop('checked', row.page_published == '1');
    editModal.show();
  }

  function save() {
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
      url: "<?php echo base_url() . '/' . index_page() ?>/admin/pages/" + ($('#f_pid').val() == '' ? 'addPages' : 'updatePages'),
      data: "postdata=" + postdata + "&ed=" + encodeURIComponent(ed),
      success: function(result) {
        if (result.indexOf('SUCCESS') >= 0) {
          editModal.hide();
          getPages();
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert(errorThrown);
      }
    });
  }
</script>


<div class="p-2 text-end">
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" onclick='add()' data-bs-target="#edit-modal">Add</button>
</div>
<table class="table" id="pages-table">
  <thead>
    <tr>
      <th scope="col"><?php echo lang('Default.title') ?></th>
      <th scope="col"><?php echo lang('Default.url_slug') ?></th>
      <th scope="col"><?php echo lang('Default.page_order') ?></th>
      <th scope="col"><?php echo lang('Default.published') ?></th>
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
        <input type="hidden" id="f_pid">
        <input type="hidden" id="f_pauthorid">
        <div class="row">
          <div class="col">
            <div class="mb-2">
              <label for="f_ptitle" class="form-label"><?php echo lang('Default.title') ?></label>
              <input type="text" id="f_ptitle" class="form-control" aria-describedby="passwordHelpBlock" maxlength="250">
            </div>
          </div>
          <div class="col">
            <div class="mb-2">
              <label for="f_purlslug" class="form-label"><?php echo lang('Default.url_slug') ?></label>
              <input type="text" id="f_purlslug" class="form-control" aria-describedby="passwordHelpBlock" maxlength="250">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="mb-2">
              <label for="f_porder" class="form-label"><?php echo lang('Default.page_order') ?></label>
              <input type="number" id="f_porder" class="form-control" aria-describedby="passwordHelpBlock" max="99" min="0">
            </div>

          </div>
          <div class="col">
            <div class="mb-2">
              <label for="f_pfeatimage" class="form-label"><?php echo lang('Default.feature_image') ?></label>
              <input type="text" id="f_pfeatimage" class="form-control" aria-describedby="passwordHelpBlock">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="mb-4">
              <label for="f_pcgid" class="form-label"><?php echo lang('Default.category') ?></label>
              <select id="f_pcgid" class="form-select">
                <option>Disabled select</option>
              </select>
            </div>
          </div>
          <div class="col">
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