<?php defined('ALTUMCODE') || die() ?>

<div class="modal fade" id="create_biolink_tiktok_profile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" data-toggle="modal" data-target="#biolink_link_create_modal" data-dismiss="modal" class="btn btn-sm btn-link"><i class="fas fa-fw fa-chevron-circle-left text-muted"></i></button>
                <h5 class="modal-title"><?= l('biolink_tiktok_profile.header') ?></h5>
                <button type="button" class="close" data-dismiss="modal" title="<?= l('global.close') ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form name="create_biolink_tiktok_profile" method="post" role="form">
                    <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" required="required" />
                    <input type="hidden" name="request_type" value="create" />
                    <input type="hidden" name="link_id" value="<?= $data->link->link_id ?>" />
                    <input type="hidden" name="block_type" value="tiktok_profile" />

                    <div class="notification-container"></div>

                    <div class="form-group">
                        <label for="tiktok_profile_location_url"><i class="fas fa-fw fa-link fa-sm text-muted mr-1"></i> <?= l('biolink_tiktok_profile.location_url') ?></label>
                        <input id="tiktok_profile_location_url" type="url" class="form-control" name="location_url" required="required" maxlength="2048" placeholder="<?= l('biolink_tiktok_profile.location_url_placeholder') ?>" />
                    </div>

                    <p class="small text-muted"><i class="fas fa-fw fa-sm fa-circle-info mr-1"></i> <?= l('link.biolink.create_block_info') ?></p>
                    
                    <div class="text-center mt-4">
                        <button type="submit" name="submit" class="btn btn-block btn-primary" data-is-ajax><?= l('link.biolink.create_block') ?></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
