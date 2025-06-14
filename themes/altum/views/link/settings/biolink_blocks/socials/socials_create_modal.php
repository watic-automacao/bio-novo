<?php defined('ALTUMCODE') || die() ?>

<div class="modal fade" id="create_biolink_socials" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" data-toggle="modal" data-target="#biolink_link_create_modal" data-dismiss="modal" class="btn btn-sm btn-link"><i class="fas fa-fw fa-chevron-circle-left text-muted"></i></button>
                <h5 class="modal-title"><?= l('biolink_socials.header') ?></h5>
                <button type="button" class="close" data-dismiss="modal" title="<?= l('global.close') ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form name="create_biolink_socials" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" required="required" />
                    <input type="hidden" name="request_type" value="create" />
                    <input type="hidden" name="link_id" value="<?= $data->link->link_id ?>" />
                    <input type="hidden" name="block_type" value="socials" />

                    <div class="notification-container"></div>

                    <?php $biolink_socials = require APP_PATH . 'includes/biolink_socials.php'; ?>
                    <?php foreach($biolink_socials as $key => $value): ?>
                        <?php if($value['input_group']): ?>
                            <div class="form-group">
                                <label for="<?= 'socials_' . $key ?>"><i class="<?= $value['icon'] ?> fa-fw fa-sm text-muted mr-1"></i> <?= l('biolink_socials.' . $key . '.name') ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><?= remove_url_protocol_from_url(str_replace('%s', '', $value['format'])) ?></span>
                                    </div>
                                    <input id="<?= 'socials_' . $key ?>" type="text" class="form-control" name="socials[<?= $key ?>]" placeholder="<?= l('biolink_socials.' . $key . '.placeholder') ?>" value="" maxlength="<?= $value['max_length'] ?>" />
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="form-group">
                                <label for="<?= 'socials_' . $key ?>"><i class="<?= $value['icon'] ?> fa-fw fa-sm text-muted mr-1"></i> <?= l('biolink_socials.' . $key . '.name') ?></label>
                                <input id="<?= 'socials_' . $key ?>" type="text" class="form-control" name="socials[<?= $key ?>]" placeholder="<?= l('biolink_socials.' . $key . '.placeholder') ?>" value="" maxlength="<?= $value['max_length'] ?>" />
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>

                    <p class="small text-muted"><i class="fas fa-fw fa-sm fa-circle-info mr-1"></i> <?= l('link.biolink.create_block_info') ?></p>
                    
                    <div class="text-center mt-4">
                        <button type="submit" name="submit" class="btn btn-block btn-primary" data-is-ajax><?= l('link.biolink.create_block') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
