<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>
<div class="card mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4">
            <h2 class="h4 text-truncate mb-0"><i class="fas fa-fw fa-credit-card fa-xs text-primary-900 mr-2"></i> <?= l('admin_payment_processors.header') ?></h2>

            <div>
                <span class="badge <?= $data->total['payment_processors'] > 0 ? 'badge-success' : 'badge-secondary' ?>"><?= ($data->total['payment_processors'] > 0 ? '+' : null) . nr($data->total['payment_processors']) ?></span>
            </div>
        </div>

        <div class="chart-container <?= $data->total['payment_processors'] ? null : 'd-none' ?>">
            <canvas id="payment_processors"></canvas>
        </div>
        <?= $data->total['payment_processors'] ? null : include_view(THEME_PATH . 'views/partials/no_chart_data.php', ['has_wrapper' => false]); ?>
    </div>
</div>
<?php $html = ob_get_clean() ?>

<?php ob_start() ?>
<script>
    let color = css.getPropertyValue('--primary');
    let color_gradient = null;

    /* Prepare chart */
    let payment_processors_chart = document.getElementById('payment_processors').getContext('2d');
    color_gradient = payment_processors_chart.createLinearGradient(0, 0, 0, 250);
    color_gradient.addColorStop(0, set_hex_opacity(color, 0.1));
    color_gradient.addColorStop(1, set_hex_opacity(color, 0.025));

    /* Display chart */
    new Chart(payment_processors_chart, {
        type: 'line',
        data: {
            labels: <?= $data->payment_processors_chart['labels'] ?>,
            datasets: [{
                label: <?= json_encode(l('admin_payment_processors.title')) ?>,
                data: <?= $data->payment_processors_chart['payment_processors'] ?? '[]' ?>,
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
