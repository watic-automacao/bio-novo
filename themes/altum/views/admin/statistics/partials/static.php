<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>
<div class="card mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4">
            <h2 class="h4 text-truncate mb-0"><i class="fas fa-fw fa-file-code fa-xs text-primary-900 mr-2"></i> <?= l('links.menu.static') ?></h2>

            <div>
                <span class="badge <?= $data->total['static'] > 0 ? 'badge-success' : 'badge-secondary' ?>"><?= ($data->total['static'] > 0 ? '+' : null) . nr($data->total['static']) ?></span>
            </div>
        </div>

        <div class="chart-container <?= $data->total['static'] ? null : 'd-none' ?>">
            <canvas id="static"></canvas>
        </div>
        <?= $data->total['static'] ? null : include_view(THEME_PATH . 'views/partials/no_chart_data.php', ['has_wrapper' => false]); ?>
    </div>
</div>
<?php $html = ob_get_clean() ?>

<?php ob_start() ?>
<script>
    let color = css.getPropertyValue('--primary');
    let color_gradient = null;

    /* Prepare chart */
    let static_chart = document.getElementById('static').getContext('2d');
    color_gradient = static_chart.createLinearGradient(0, 0, 0, 250);
    color_gradient.addColorStop(0, set_hex_opacity(color, 0.1));
    color_gradient.addColorStop(1, set_hex_opacity(color, 0.025));

    /* Display chart */
    new Chart(static_chart, {
        type: 'line',
        data: {
            labels: <?= $data->static_chart['labels'] ?>,
            datasets: [{
                label: <?= json_encode(l('links.menu.static')) ?>,
                data: <?= $data->static_chart['static'] ?? '[]' ?>,
                backgroundColor: color_gradient,
                borderColor: color,
                fill: true
            }]
        },
        options: chart_options
    });
</script>
<?php $javascript = ob_get_clean() ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>
