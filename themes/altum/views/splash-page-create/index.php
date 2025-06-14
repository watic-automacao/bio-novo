<?php defined('ALTUMCODE') || die() ?>

<div class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <?php if(settings()->main->breadcrumbs_is_enabled): ?>
        <nav aria-label="breadcrumb">
            <ol class="custom-breadcrumbs small">
                <li>
                    <a href="<?= url('splash-pages') ?>"><?= l('splash_pages.breadcrumb') ?></a><i class="fas fa-fw fa-angle-right"></i>
                </li>
                <li class="active" aria-current="page"><?= l('splash_page_create.breadcrumb') ?></li>
            </ol>
        </nav>
    <?php endif ?>

    <h1 class="h4 text-truncate mb-4"><i class="fas fa-fw fa-xs fa-droplet mr-1"></i> <?= l('splash_page_create.header') ?></h1>

    <div class="card">
        <div class="card-body">

            <form action="" method="post" role="form" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" />

                <div class="form-group">
                    <label for="name"><i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('global.name') ?></label>
                    <input type="text" id="name" name="name" class="form-control <?= \Altum\Alerts::has_field_errors('name') ? 'is-invalid' : null ?>" value="<?= $data->values['name'] ?>" maxlength="64" required="required" />
                    <?= \Altum\Alerts::output_field_error('name') ?>
                </div>

                <div class="form-group" data-file-image-input-wrapper data-file-input-wrapper-size-limit="<?= settings()->links->avatar_size_limit ?>" data-file-input-wrapper-size-limit-error="<?= sprintf(l('global.error_message.file_size_limit'), settings()->links->avatar_size_limit) ?>">
                    <label for="logo"><i class="fas fa-fw fa-sm fa-image text-muted mr-1"></i> <?= l('splash_pages.logo') ?></label>
                    <?= include_view(THEME_PATH . 'views/partials/file_image_input.php', ['uploads_file_key' => 'splash_pages', 'file_key' => 'logo', 'already_existing_image' => null]) ?>
                    <?= \Altum\Alerts::output_field_error('logo') ?>
                    <small class="form-text text-muted"><?= sprintf(l('global.accessibility.whitelisted_file_extensions'), \Altum\Uploads::get_whitelisted_file_extensions_accept('splash_pages')) . ' ' . sprintf(l('global.accessibility.file_size_limit'), settings()->links->avatar_size_limit) ?></small>
                </div>

                <div class="form-group">
                    <label for="title"><i class="fas fa-fw fa-pen fa-sm text-muted mr-1"></i> <?= l('global.title') ?></label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= $data->values['title'] ?>" maxlength="256" />
                </div>

                <div class="form-group" data-character-counter="textarea">
                    <label for="description" class="d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-fw fa-sm fa-paragraph text-muted mr-1"></i> <?= l('global.description') ?></span>
                        <small class="text-muted" data-character-counter-wrapper></small>
                    </label>
                    <textarea id="description" name="description" class="form-control" maxlength="2048"><?= $data->values['description'] ?></textarea>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="secondary_button_name"><i class="fas fa-fw fa-pen-to-square fa-sm text-muted mr-1"></i> <?= l('splash_pages.secondary_button_name') ?></label>
                            <input type="text" id="secondary_button_name" name="secondary_button_name" class="form-control" value="<?= $data->values['secondary_button_name'] ?>" maxlength="256" />
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="secondary_button_url"><i class="fas fa-fw fa-link fa-sm text-muted mr-1"></i> <?= l('splash_pages.secondary_button_url') ?></label>
                            <input type="url" id="secondary_button_url" name="secondary_button_url" class="form-control" value="<?= $data->values['secondary_button_url'] ?>" placeholder="<?= l('global.url_placeholder') ?>" maxlength="1024" />
                        </div>
                    </div>
                </div>

                <div class="form-group custom-control custom-switch">
                    <input id="auto_redirect" name="auto_redirect" type="checkbox" class="custom-control-input" <?= $data->values['auto_redirect'] ? 'checked="checked"' : null?>>
                    <label class="custom-control-label" for="auto_redirect"><i class="fas fa-fw fa-square-up-right fa-sm text-muted mr-1"></i> <?= l('splash_pages.auto_redirect') ?></label>
                    <small class="form-text text-muted"><?= l('splash_pages.auto_redirect_help') ?></small>
                </div>

                <div class="form-group">
                    <label for="link_unlock_seconds"><i class="fas fa-fw fa-stopwatch fa-sm text-muted mr-1"></i> <?= l('splash_pages.link_unlock_seconds') ?></label>
                    <div class="input-group">
                        <input id="link_unlock_seconds" type="number" min="0" step="1" max="600" name="link_unlock_seconds" class="form-control" value="<?= $data->values['link_unlock_seconds'] ?>" />
                        <div class="input-group-append">
                            <span class="input-group-text"><?= l('global.date.seconds') ?></span>
                        </div>
                    </div>
                    <small class="form-text text-muted"><?= l('splash_pages.link_unlock_seconds_help') ?></small>
                </div>

                <button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#advanced_container" aria-expanded="false" aria-controls="advanced_container">
                    <i class="fas fa-fw fa-user-tie fa-sm mr-1"></i> <?= l('splash_pages.advanced') ?>
                </button>

                <div class="collapse" id="advanced_container">
                    <div class="form-group" data-file-image-input-wrapper data-file-input-wrapper-size-limit="<?= settings()->links->favicon_size_limit ?>" data-file-input-wrapper-size-limit-error="<?= sprintf(l('global.error_message.file_size_limit'), settings()->links->favicon_size_limit) ?>">
                        <label for="favicon"><i class="fas fa-fw fa-sm fa-image text-muted mr-1"></i> <?= l('splash_pages.favicon') ?></label>
                        <?= include_view(THEME_PATH . 'views/partials/file_image_input.php', ['uploads_file_key' => 'splash_pages', 'file_key' => 'favicon', 'already_existing_image' => null, 'input_data' => 'data-crop data-aspect-ratio="1"']) ?>
                        <?= \Altum\Alerts::output_field_error('favicon') ?>
                        <small class="form-text text-muted"><?= sprintf(l('global.accessibility.whitelisted_file_extensions'), \Altum\Uploads::get_whitelisted_file_extensions_accept('splash_pages')) . ' ' . sprintf(l('global.accessibility.file_size_limit'), settings()->links->favicon_size_limit) ?></small>
                    </div>

                    <div class="form-group" data-file-image-input-wrapper data-file-input-wrapper-size-limit="<?= settings()->links->seo_image_size_limit ?>" data-file-input-wrapper-size-limit-error="<?= sprintf(l('global.error_message.file_size_limit'), settings()->links->seo_image_size_limit) ?>">
                        <label for="opengraph"><i class="fas fa-fw fa-sm fa-image text-muted mr-1"></i> <?= l('splash_pages.opengraph') ?></label>
                        <?= include_view(THEME_PATH . 'views/partials/file_image_input.php', ['uploads_file_key' => 'splash_pages', 'file_key' => 'opengraph', 'already_existing_image' => null, 'input_data' => 'data-crop data-aspect-ratio="1.91"']) ?>
                        <?= \Altum\Alerts::output_field_error('opengraph') ?>
                        <small class="form-text text-muted"><?= sprintf(l('global.accessibility.whitelisted_file_extensions'), \Altum\Uploads::get_whitelisted_file_extensions_accept('splash_pages')) . ' ' . sprintf(l('global.accessibility.file_size_limit'), settings()->links->seo_image_size_limit) ?></small>
                    </div>

                    <div <?= $this->user->plan_settings->custom_css_is_enabled ? null : get_plan_feature_disabled_info() ?>>
                        <div class="form-group <?= $this->user->plan_settings->custom_css_is_enabled ? null : 'container-disabled' ?>" data-character-counter="textarea">
                            <label for="custom_css" class="d-flex justify-content-between align-items-center">
                                <span><i class="fab fa-fw fa-sm fa-css3 text-muted mr-1"></i> <?= l('global.custom_css') ?></span>
                                <small class="text-muted" data-character-counter-wrapper></small>
                            </label>
                            <textarea id="custom_css" class="form-control" name="custom_css" maxlength="10000" placeholder="<?= l('global.custom_css_placeholder') ?>"><?= $data->values['custom_css'] ?></textarea>
                            <small class="form-text text-muted"><?= l('global.custom_css_help') ?></small>
                        </div>
                    </div>

                    <div <?= $this->user->plan_settings->custom_js_is_enabled ? null : get_plan_feature_disabled_info() ?>>
                        <div class="form-group <?= $this->user->plan_settings->custom_js_is_enabled ? null : 'container-disabled' ?>" data-character-counter="textarea">
                            <label for="custom_js" class="d-flex justify-content-between align-items-center">
                                <span><i class="fab fa-fw fa-sm fa-js-square text-muted mr-1"></i> <?= l('global.custom_js') ?></span>
                                <small class="text-muted" data-character-counter-wrapper></small>
                            </label>
                            <textarea id="custom_js" class="form-control" name="custom_js" maxlength="10000" placeholder="<?= l('global.custom_js_placeholder') ?>"><?= $data->values['custom_js'] ?></textarea>
                            <small class="form-text text-muted"><?= l('global.custom_js_help') ?></small>
                        </div>
                    </div>

                    <div <?= $this->user->plan_settings->no_ads ? null : get_plan_feature_disabled_info() ?>>
                        <div class="form-group <?= $this->user->plan_settings->no_ads ? null : 'container-disabled' ?>" data-character-counter="textarea">
                            <label for="ads_header" class="d-flex justify-content-between align-items-center">
                                <span><i class="fab fa-fw fa-sm fa-adversal text-muted mr-1"></i> <?= l('splash_pages.ads_header') ?></span>
                                <small class="text-muted" data-character-counter-wrapper></small>
                            </label>
                            <textarea id="ads_header" class="form-control" name="ads_header" maxlength="10000"><?= $data->values['ads_header'] ?></textarea>
                        </div>
                    </div>

                    <div <?= $this->user->plan_settings->no_ads ? null : get_plan_feature_disabled_info() ?>>
                        <div class="form-group <?= $this->user->plan_settings->no_ads ? null : 'container-disabled' ?>" data-character-counter="textarea">
                            <label for="ads_footer" class="d-flex justify-content-between align-items-center">
                                <span><i class="fab fa-fw fa-sm fa-adversal text-muted mr-1"></i> <?= l('splash_pages.ads_footer') ?></span>
                                <small class="text-muted" data-character-counter-wrapper></small>
                            </label>
                            <textarea id="ads_footer" class="form-control" name="ads_footer" maxlength="10000"><?= $data->values['ads_footer'] ?></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn btn-block btn-primary"><?= l('global.create') ?></button>
            </form>

        </div>
    </div>
</div>

<?php include_view(THEME_PATH . 'views/partials/color_picker_js.php') ?>
<?php include_view(THEME_PATH . 'views/partials/js_cropper.php') ?>
