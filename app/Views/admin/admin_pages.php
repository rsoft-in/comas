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
      'pn': pn,
      'ps': <?php echo PAGE_SIZE?>
    }
    postdata = JSON.stringify(postdata);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url() . '/' . index_page()?>/admin/pages/getPages",
      data: "postdata=" + postdata,
      success: function(data) {
        console.log(data);  
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

<div class="modal" id="edit-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo lang('Default.edit') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="f_pid">
        <input type="hidden" id="f_pauthorid">
        <div class="mb-2">
          <label for="inputPassword5" class="form-label"><?php echo lang('Default.title') ?></label>
          <input type="password" id="f_ptitle" class="form-control" aria-describedby="passwordHelpBlock">
        </div>
        <div class="mb-2">
          <label for="inputPassword5" class="form-label"><?php echo lang('Default.url_slug') ?></label>
          <input type="password" id="f_purlslug" class="form-control" aria-describedby="passwordHelpBlock">
        </div>
        <div class="mb-2">
          <label for="inputPassword5" class="form-label"><?php echo lang('Default.page_order') ?></label>
          <input type="password" id="f_porder" class="form-control" aria-describedby="passwordHelpBlock">
        </div>
        <div class="mb-2">
          <label for="inputPassword5" class="form-label"><?php echo lang('Default.feature_image') ?></label>
          <input type="password" id="f_pfeatimage" class="form-control" aria-describedby="passwordHelpBlock">
        </div>
       
        <div class="mb-4">
      <label for="disabledSelect" class="form-label"><?php echo lang('Default.category') ?></label>
      <select id="disabledSelect" class="form-select">
        <option>Disabled select</option>
      </select>
    </div>
        <div class="mb-2 form-check">
    <input type="checkbox" class="form-check-input" id="f_ppublished">
    <label class="form-check-label" for="exampleCheck1"><?php echo lang('Default.published') ?></label>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('Default.close') ?></button>
        <button type="button" class="btn btn-primary"><?php echo lang('Default.save') ?></button>
      </div>
    </div>
  </div>
</div>


<?php $this->endSection() ?>