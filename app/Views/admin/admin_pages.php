<?php $this->extend('layouts/admin_template') ?>
<?php $this->section('content') ?>
<script>
  $(document).ready(function() {
    getPages();
  });
  let sortby = 'page_title';
  let pn = 0;

  function getPages() {
    var postdata = {
      'sort': sortby,
      'qry': '',
      'pn': pn
    }
    postdata = JSON.stringify(postdata);
    $.ajax({
      type: "POST",
      url: "pages/getPages",
      data: "postdata=" + postdata,
      success: function(data) {
        $('#pages-table').append(generatePagesTable(data));
        // $(document).updatenav();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert(errorThrown);
      }
    });
  }

  function edit() {

  }
</script>
<div class="p-2 text-end">
  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit-modal">Add</button>
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

<div class="modal" tabindex="-1" id="edit-model" aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edit-modal-label"><?php echo lang('Default.edit') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php $this->endSection() ?>