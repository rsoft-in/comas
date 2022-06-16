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
                    $('#site_desc').val(siteConfig['site-desc']);
                    $('#site_keywords').val(siteConfig['site-keywords']);
                    $('#site_theme').val(siteConfig['site-theme']);
                    $('#site_logo').val(siteConfig['site-logo']);
                    $('#site_contact_email').val(siteConfig['site_contact_email']);
                    $('#site_contact_mobile').val(siteConfig['site_contact_mobile']);
                    $('#site_show_logo_only').prop('checked', siteConfig['site_show_logo_only']);
                    $('#site_show_name_only').prop('checked', siteConfig['site_show_name_only']);
                    $('#site_isblog').prop('checked', siteConfig['site_isblog']);
                    $('#site_allow_comments').prop('checked', siteConfig['site_allow_comments']);
                    $('#site_allow_comments_moderation').prop('checked', siteConfig['site_allow_comments_moderation']);
                    $('#site_show_archive').prop('checked', siteConfig['site_show_archive']);
                    $('#site_show_categories').prop('checked', siteConfig['site_show_categories']);
                    $('#site_show_social_links').prop('checked', siteConfig['site_show_social_links']);
                    $('#site_social_fb_url').val(siteConfig['site_social_fb_url']);
                    $('#site_social_ig_url').val(siteConfig['site_social_ig_url']);
                    $('#site_social_tw_url').val(siteConfig['site_social_tw_url']);
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
                <label for="site_desc" class="form-label"><?php echo lang('Default.desciption') ?></label>
                <input type="text" id="site_desc" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="site_keywords" class="form-label"><?php echo lang('Default.keywords') ?></label>
                <input type="text" id="site_keywords" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
        <div class="col">
                        <div class="mb-2">
                            <label for="f_pcgid" class="form-label"><?php echo lang('Default.theme') ?></label>
                            <select id="f_pcgid" class="form-select">
                                <option value="">Default</option>
                                <option value="">Modern</option>
                                <option value="">Classic</option>
                             
                            </select>
                        </div>
                    </div>
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="site_theme" class="form-label"><?php echo lang('Default.theme') ?></label>
                <input type="text" id="site_theme" class="form-control email">
                <div class="invalid_email">Invalid Email</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="site_logo" class="form-label"><?php echo lang('Default.logo') ?></label>
                <input type="text" id="site_logo" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="site_contact_email" class="form-label"><?php echo lang('Default.contact_email') ?></label>
                <input type="text" id="site_contact_email" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <label for="site_contact_mobile" class="form-label"><?php echo lang('Default.contact_mobile') ?></label>
        <input type="text" id="site_contact_mobile" class="form-control required" maxlength="250">
        <div class="required_input">Please enter some text</div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="site_show_logo_only">
                <label class="form-check-label" for="site_show_logo_only"><?php echo lang('Default.show_logo_only') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="site_show_name_only">
                <label class="form-check-label" for="site_show_name_only"><?php echo lang('Default.show_name_only') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="site_isblog">
                <label class="form-check-label" for="site_isblog"><?php echo lang('Default.isblog') ?></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="site_allow_comments">
                <label class="form-check-label" for="site_allow_comments"><?php echo lang('Default.allow_comments') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="site_allow_comments_moderation">
                <label class="form-check-label" for="site_allow_comments_moderation"><?php echo lang('Default.allow_comments_moderation') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="site_show_archive">
                <label class="form-check-label" for="site_show_archive"><?php echo lang('Default.show_archive') ?></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="site_show_categories">
                <label class="form-check-label" for="site_show_categories"><?php echo lang('Default.show_categories') ?></label>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mt-3 form-check">
                <input type="checkbox" class="form-check-input" id="site_show_social_links">
                <label class="form-check-label" for="site_show_social_links"><?php echo lang('Default.show_social_links') ?></label>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="site_social_fb_url" class="form-label"><?php echo lang('Default.social_fb_url') ?></label>
                <input type="text" id="site_social_fb_url" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-2">
                <label for="site_social_tw_url" class="form-label"><?php echo lang('Default.social_tw_url') ?></label>
                <input type="text" id="site_social_tw_url" class="form-control required" maxlength="250">
                <div class="required_input">Please enter some text</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <label for="site_social_ig_url" class="form-label"><?php echo lang('Default.social_ig_url') ?></label>
        <input type="text" id="site_social_ig_url" class="form-control required" maxlength="250">
        <div class="required_input">Please enter some text</div>
    </div>
    <div class="mt-3 mb-2 text-end">
        <button type="button" class="btn btn-primary" onclick="save();"><?php echo lang('Default.save') ?></button>
    </div>

</div>

<?php $this->endSection() ?>