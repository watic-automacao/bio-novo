<?php defined('ALTUMCODE') || die() ?>

<?php $payment_processors = require APP_PATH . 'includes/payment_processors.php'; ?>

<section class="container">
    <?= \Altum\Alerts::output_alerts() ?>

    <div class="row mb-4">
        <div class="col-12 col-lg d-flex align-items-center mb-3 mb-lg-0 text-truncate">
            <h1 class="h4 m-0 text-truncate"><i class="fas fa-fw fa-xs fa-coins mr-1"></i> <?= l('guests_payments.header') ?></h1>

            <div class="ml-2">
                <span data-toggle="tooltip" title="<?= l('guests_payments.subheader') ?>">
                    <i class="fas fa-fw fa-info-circle text-muted"></i>
                </span>
            </div>
        </div>

        <div class="col-12 col-lg-auto d-flex flex-wrap gap-3 d-print-none">
            <div>
                <div class="dropdown">
                    <button type="button" class="btn btn-light dropdown-toggle-simple <?= count($data->guests_payments) ? null : 'disabled' ?>" data-toggle="dropdown" data-boundary="viewport" data-tooltip title="<?= l('global.export') ?>" data-tooltip-hide-on-click>
                        <i class="fas fa-fw fa-sm fa-download"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right d-print-none">
                        <a href="<?= url('guests-payments?' . $data->filters->get_get() . '&export=csv')  ?>" target="_blank" class="dropdown-item <?= $this->user->plan_settings->export->csv ? null : 'disabled' ?>">
                            <i class="fas fa-fw fa-sm fa-file-csv mr-2"></i> <?= sprintf(l('global.export_to'), 'CSV') ?>
                        </a>
                        <a href="<?= url('guests-payments?' . $data->filters->get_get() . '&export=json') ?>" target="_blank" class="dropdown-item <?= $this->user->plan_settings->export->json ? null : 'disabled' ?>">
                            <i class="fas fa-fw fa-sm fa-file-code mr-2"></i> <?= sprintf(l('global.export_to'), 'JSON') ?>
                        </a>
                        <a href="#" onclick="window.print();return false;" class="dropdown-item <?= $this->user->plan_settings->export->pdf ? null : 'disabled' ?>">
                            <i class="fas fa-fw fa-sm fa-file-pdf mr-2"></i> <?= sprintf(l('global.export_to'), 'PDF') ?>
                        </a>
                    </div>
                </div>
            </div>

            <div>
                <div class="dropdown">
                    <button type="button" class="btn <?= $data->filters->has_applied_filters ? 'btn-dark' : 'btn-light' ?> filters-button dropdown-toggle-simple <?= count($data->guests_payments) || $data->filters->has_applied_filters ? null : 'disabled' ?>" data-toggle="dropdown" data-boundary="viewport" data-tooltip title="<?= l('global.filters.header') ?>" data-tooltip-hide-on-click>
                        <i class="fas fa-fw fa-sm fa-filter"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right filters-dropdown">
                        <div class="dropdown-header d-flex justify-content-between">
                            <span class="h6 m-0"><?= l('global.filters.header') ?></span>

                            <?php if($data->filters->has_applied_filters): ?>
                                <a href="<?= url(\Altum\Router::$original_request) ?>" class="text-muted"><?= l('global.filters.reset') ?></a>
                            <?php endif ?>
                        </div>

                        <div class="dropdown-divider"></div>

                        <form action="" method="get" role="form">
                            <div class="form-group px-4">
                                <label for="filters_search" class="small"><?= l('global.filters.search') ?></label>
                                <input type="search" name="search" id="filters_search" class="form-control form-control-sm" value="<?= $data->filters->search ?>" />
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_search_by" class="small"><?= l('global.filters.search_by') ?></label>
                                <select name="search_by" id="filters_search_by" class="custom-select custom-select-sm">
                                    <option value="name" <?= $data->filters->search_by == 'name' ? 'selected="selected"' : null ?>><?= l('global.name') ?></option>
                                    <option value="email" <?= $data->filters->search_by == 'email' ? 'selected="selected"' : null ?>><?= l('global.email') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="type" class="small">
                                    <?= l('global.type') ?>
                                </label>
                                <select name="type" id="type" class="custom-select custom-select-sm">
                                    <option value=""><?= l('global.all') ?></option>
                                    <?php foreach(['donation', 'product', 'service',] as $value): ?>
                                        <option value="<?= $value ?>" <?= isset($data->filters->filters['type']) && $data->filters->filters['type'] == $value ? 'selected="selected"' : null ?>><?= l('link.biolink.blocks.' . $value) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="processor" class="small"><?= l('guests_payments.processor') ?></label>
                                <select name="processor" id="processor" class="custom-select custom-select-sm">
                                    <option value=""><?= l('global.all') ?></option>
                                    <?php foreach(['paypal', 'stripe', 'crypto_com', 'razorpay', 'paystack', 'mollie'] as $processor): ?>
                                        <option value="<?= $processor ?>" <?= isset($data->filters->filters['processor']) && $data->filters->filters['processor'] == $processor ? 'selected="selected"' : null ?>><?= l('pay.custom_plan.' . $processor) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_by" class="small"><?= l('global.filters.order_by') ?></label>
                                <select name="order_by" id="filters_order_by" class="custom-select custom-select-sm">
                                    <option value="guest_payment_id" <?= $data->filters->order_by == 'guest_payment_id' ? 'selected="selected"' : null ?>><?= l('global.id') ?></option>
                                    <option value="datetime" <?= $data->filters->order_by == 'datetime' ? 'selected="selected"' : null ?>><?= l('global.filters.order_by_datetime') ?></option>
                                    <option value="total_amount" <?= $data->filters->order_by == 'total_amount' ? 'selected="selected"' : null ?>><?= l('guests_payments.total_amount') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_order_type" class="small"><?= l('global.filters.order_type') ?></label>
                                <select name="order_type" id="filters_order_type" class="custom-select custom-select-sm">
                                    <option value="ASC" <?= $data->filters->order_type == 'ASC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_asc') ?></option>
                                    <option value="DESC" <?= $data->filters->order_type == 'DESC' ? 'selected="selected"' : null ?>><?= l('global.filters.order_type_desc') ?></option>
                                </select>
                            </div>

                            <div class="form-group px-4">
                                <label for="filters_results_per_page" class="small"><?= l('global.filters.results_per_page') ?></label>
                                <select name="results_per_page" id="filters_results_per_page" class="custom-select custom-select-sm">
                                    <?php foreach($data->filters->allowed_results_per_page as $key): ?>
                                        <option value="<?= $key ?>" <?= $data->filters->results_per_page == $key ? 'selected="selected"' : null ?>><?= $key ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group px-4 mt-4">
                                <button type="submit" name="submit" class="btn btn-sm btn-primary btn-block"><?= l('global.submit') ?></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div>
                <button id="bulk_enable" type="button" class="btn btn-light" data-toggle="tooltip" title="<?= l('global.bulk_actions') ?>"><i class="fas fa-fw fa-sm fa-list"></i></button>

                <div id="bulk_group" class="btn-group d-none" role="group">
                    <div class="btn-group dropdown" role="group">
                        <button id="bulk_actions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            <?= l('global.bulk_actions') ?> <span id="bulk_counter" class="d-none"></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="bulk_actions">
                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#bulk_delete_modal"><i class="fas fa-fw fa-sm fa-trash-alt mr-2"></i> <?= l('global.delete') ?></a>
                        </div>
                    </div>

                    <button id="bulk_disable" type="button" class="btn btn-secondary" data-toggle="tooltip" title="<?= l('global.close') ?>"><i class="fas fa-fw fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>

    <?php if(count($data->guests_payments)): ?>

        <form id="table" action="<?= SITE_URL . 'guests-payments/bulk' ?>" method="post" role="form">
            <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" />
            <input type="hidden" name="type" value="" data-bulk-type />
            <input type="hidden" name="original_request" value="<?= base64_encode(\Altum\Router::$original_request) ?>" />
            <input type="hidden" name="original_request_query" value="<?= base64_encode(\Altum\Router::$original_request_query) ?>" />

            <div class="table-responsive table-custom-container">
                <table class="table table-custom">
                    <thead>
                    <tr>
                        <th data-bulk-table class="d-none">
                            <div class="custom-control custom-checkbox">
                                <input id="bulk_select_all" type="checkbox" class="custom-control-input" />
                                <label class="custom-control-label" for="bulk_select_all"></label>
                            </div>
                        </th>
                        <th><?= l('global.name') ?></th>
                        <th><?= l('guests_payments.biolink_block') ?></th>
                        <th><?= l('global.type') ?></th>
                        <th><?= l('guests_payments.total_amount') ?></th>
                        <th><?= l('guests_payments.processor') ?></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($data->guests_payments as $row): ?>

                        <tr>
                            <td data-bulk-table class="d-none">
                                <div class="custom-control custom-checkbox">
                                    <input id="selected_guest_payment_id_<?= $row->guest_payment_id ?>" type="checkbox" class="custom-control-input" name="selected[]" value="<?= $row->guest_payment_id ?>" />
                                    <label class="custom-control-label" for="selected_guest_payment_id_<?= $row->guest_payment_id ?>"></label>
                                </div>
                            </td>

                            <td class="text-nowrap">
                                <div class="d-flex flex-column text-truncate">
                                    <div><?= $row->name ?: l('global.unknown') ?></div>
                                    <div class="small text-muted"><?= $row->email ?: l('global.unknown') ?></div>
                                </div>
                            </td>

                            <td class="text-nowrap">
                                <a href="<?= url('link/' . $row->link_id . '?tab=blocks&biolink_block_id=' . $row->biolink_block_id . '#biolink_block_expanded_content_' . $row->biolink_block_id) ?>" class="font-weight-bold">
                                    <span data-toggle="tooltip" title="<?= $row->settings->name ?? l('global.unknown') ?>"><?= string_truncate($row->settings->name ?? l('global.unknown'), 30) ?></span>
                                </a>
                            </td>

                            <td class="text-nowrap">
                                <span class="badge badge-secondary">
                                    <i class="<?= $data->biolink_blocks[$row->type]['icon'] ?> fa-fw fa-sm mr-1"></i>

                                    <?= l('link.biolink.blocks.' . $row->type) ?>
                                </span>
                            </td>

                            <td class="text-nowrap">
                                <span class="badge badge-success">
                                    <?php if($row->total_amount): ?>
                                        <?= $row->total_amount ?> <?= $row->currency ?>
                                    <?php else: ?>
                                        <?= l('guests_payments.free') ?>
                                    <?php endif ?>
                                </span>
                            </td>

                            <td class="text-nowrap">
                                <span class="badge badge-light">
                                    <?php if($row->processor): ?>
                                        <i class="<?= $payment_processors[$row->processor]['icon'] ?> fa-sm fa-fw mr-1" style="color: <?= $payment_processors[$row->processor]['color'] ?>"></i> <?= l('pay.custom_plan.' . $row->processor) ?>
                                    <?php else: ?>
                                        <?= l('global.none') ?>
                                    <?php endif ?>
                                </span>
                            </td>

                            <td class="text-nowrap text-muted">
                                <a href="<?= url('link/' . $row->link_id . '?tab=blocks') ?>" class="mr-2 text-decoration-none" data-toggle="tooltip" title="<?= l('guests_payments.biolink') ?>">
                                    <i class="fas fa-fw fa-hashtag text-muted"></i>
                                </a>

                                <span class="mr-2" data-toggle="tooltip" data-html="true" title="<?= sprintf(l('global.datetime_tooltip'), '<br />' . \Altum\Date::get($row->datetime, 2) . '<br /><small>' . \Altum\Date::get($row->datetime, 3) . '</small>' . '<br /><small>(' . \Altum\Date::get_timeago($row->datetime) . ')</small>') ?>">
                                    <i class="fas fa-fw fa-calendar text-muted"></i>
                                </span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-end">
                                    <?= include_view(THEME_PATH . 'views/guests-payments/guest_payment_dropdown_button.php', ['id' => $row->guest_payment_id]) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>

                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-3"><?= $data->pagination ?></div>

    <?php else: ?>
        <?= include_view(THEME_PATH . 'views/partials/no_data.php', [
            'filters_get' => $data->filters->get ?? [],
            'name' => 'guests_payments',
            'has_secondary_text' => false,
        ]); ?>
    <?php endif ?>

</section>

<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/universal_delete_modal_form.php', [
    'name' => 'guest_payment',
    'resource_id' => 'guest_payment_id',
    'has_dynamic_resource_name' => false,
    'path' => 'guests-payments/delete'
]), 'modals'); ?>
<?php require THEME_PATH . 'views/partials/js_bulk.php' ?>
<?php \Altum\Event::add_content(include_view(THEME_PATH . 'views/partials/bulk_delete_modal.php'), 'modals'); ?>

