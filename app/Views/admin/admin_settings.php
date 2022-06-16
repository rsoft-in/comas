<?php $this->extend('layouts/admin_template') ?>
<?php $this->section('content') ?>

<script>
    $(document).ready(function() {
        getSetting('site-config');
    });

    function getSetting(config) {
        var postdata = {
            'name': config
        }
        postdata = JSON.stringify(postdata);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() . '/' . index_page() ?>/admin/settings/getSetting",
            data: "postdata=" + postdata,
            success: function(result) {
                if (result.length != 0) {
                    var siteConfig = JSON.parse(result[0].setting_value);
                    console.log(siteConfig);
                    $('#site_name').val(siteConfig['site-name']);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="site_name" class="form-label"><?php echo lang('Default.site_name') ?></label>
                <input type="text" id="site_name" class="form-control required" maxlength="50">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="f_upwd" class="form-label"><?php echo lang('Default.desciption') ?></label>
                <input type="password" id="f_upwd" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="f_ufullname" class="form-label"><?php echo lang('Default.keywords') ?></label>
                <input type="text" id="f_ufullname" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="f_uemail" class="form-label"><?php echo lang('Default.theme') ?></label>
                <input type="text" id="f_uemail" class="form-control email">
                <div class="invalid_email">Invalid Email</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="f_ufullname" class="form-label"><?php echo lang('Default.logo') ?></label>
                <input type="text" id="f_ufullname" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="f_ufullname" class="form-label"><?php echo lang('Default.contact_email') ?></label>
                <input type="text" id="f_ufullname" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <label for="f_ufullname" class="form-label"><?php echo lang('Default.contact_mobile') ?></label>
        <input type="text" id="f_ufullname" class="form-control required" maxlength="250">
        <div class="required_input">Please enter some text</div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="f_uinactive">
                <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.show_logo_only') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="f_uinactive">
                <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.show_name_only') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="f_uinactive">
                <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.isblog') ?></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="f_uinactive">
                <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.allow_comments') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="f_uinactive">
                <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.allow_comments_moderation') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="f_uinactive">
                <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.show_archive') ?></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="f_uinactive">
                <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.show_categories') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="f_uinactive">
                <label class="form-check-label" for="f_uinactive"><?php echo lang('Default.show_social_links') ?></label>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="f_ufullname" class="form-label"><?php echo lang('Default.social_fb_url') ?></label>
                <input type="text" id="f_ufullname" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="f_ufullname" class="form-label"><?php echo lang('Default.social_tw_url') ?></label>
                <input type="text" id="f_ufullname" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <label for="f_ufullname" class="form-label"><?php echo lang('Default.social_ig_url') ?></label>
        <input type="text" id="f_ufullname" class="form-control required" maxlength="250">
        <div class="required_input">Please enter some text</div>
    </div>
    <div class="mt-3 mb-2 text-end">
        <button type="button" class="btn btn-primary" onclick="save();"><?php echo lang('Default.save') ?></button>
    </div>

</div>

<?php $this->endSection() ?>