<?php defined('ALTUMCODE') || die() ?>

<div id="<?= 'biolink_block_id_' . $data->link->biolink_block_id ?>" data-biolink-block-id="<?= $data->link->biolink_block_id ?>" data-biolink-block-type="<?= $data->link->type ?>" class="col-12 my-<?= $data->biolink->settings->block_spacing ?? '2' ?>">
    <div class="card <?= 'link-btn-' . $data->link->settings->border_radius ?>" style="<?= 'border-width: ' . ($data->link->settings->border_width ?? '1') . 'px;' . 'border-color: ' . ($data->link->settings->border_color ?? 'transparent') . ';' . 'border-style: ' . ($data->link->settings->border_style ?? 'solid') . ';' . 'background: ' . ($data->link->settings->background_color ?? 'transparent') . ';' . 'box-shadow: ' . ($data->link->settings->border_shadow_offset_x ?? '0') . 'px ' . ($data->link->settings->border_shadow_offset_y ?? '0') . 'px ' . ($data->link->settings->border_shadow_blur ?? '0') . 'px ' . ($data->link->settings->border_shadow_spread ?? '0') . 'px ' . ($data->link->settings->border_shadow_color ?? '#00000010') ?>" data-border-width data-border-radius data-border-style data-border-color data-border-shadow data-background-color>
        <div class="<?= $data->link->settings->border_width == 0 && in_array($data->link->settings->background_color, ['#00000000', '#FFFFFF00']) && in_array($data->link->settings->border_shadow_color, ['#00000000', '#FFFFFF00']) ? null : 'card-body' ?> text-break" style="color: <?= $data->link->settings->text_color ?>;" data-text data-text-color>

            <div class="ql-content">
                <?= $data->link->settings->text ?>
            </div>

        </div>
    </div>
</div>
