
<?php $__env->startSection('script.head'); ?>
    <style type="text/css">
        .select2-container.select2-container--open .select2-dropdown {
            min-width: 220px !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar"><?php echo e(__('Bookings Statistic')); ?></h1>
        </div>
        <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <div class="bravo-statistic">
            <!-- Original Statistic Chart -->
            <div class="row">
                <div class="col-md-12">
                    <form id="form-filter-statistic" action="" class="form-filter-statistic">
                        <!-- Original Filter Bar -->
                        <div class="header-statistic">
        <div class="item">
            <?php echo e(__("Filter:")); ?>

        </div>
        <div class="item">
            <select name="location_id" id="location_id" class="form-control">
                <option value=""><?php echo e(__("Select Location")); ?></option>
                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="item">
            <label for="hotel_id"><?php echo e(__('RESORT:')); ?></label>
        </div>
        <div class="item">

            <select name="hotel_id" id="hotel_id" class="form-control" disabled>
                <option value=""><?php echo e(__('Select a Location First')); ?></option>
            </select>
        </div>
        <div class="item">
            <div id="reportrange">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span>
                <input type="hidden" name="from">
                <input type="hidden" name="to">
            </div>
        </div>
        <div class="item">
            <button type="submit" class="btn-submit"><?php echo e(__("Apply")); ?></button>
        </div>
    </div>
                    </form>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="col-md-8">
                    <div class="g-statistic">
                        <div class="head"><?php echo e(__("Bookings Statistic")); ?></div>
                        <div class="content">
                            <canvas id="earning_chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="g-statistic">
                        <div class="head"><?php echo e(__("Booking Details")); ?></div>
                        <div class="content">
                            <div class="list-detail" id="list-detail">
                                <?php if(!empty($earning_detail_data)): ?>
                                    <?php $__currentLoopData = $earning_detail_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="item item-<?php echo e($key); ?>">
                                            <span><?php echo e($detail['title']); ?>: </span> <?php echo e($detail['val']); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Duplicate Statistic Chart -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <form id="form-filter-statistic-duplicate" action="" class="form-filter-statistic">
                        <!-- Duplicate Filter Bar -->
                        <div class="header-statistic">
        <div class="item">
            <?php echo e(__("Filter:")); ?>

        </div>
        <div class="item">
            <select name="location_id" id="location_id" class="form-control">
                <option value=""><?php echo e(__("Select Location")); ?></option>
                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="item">
            <label for="hotel_id"><?php echo e(__('RESORT:')); ?></label>
        </div>
        <div class="item">

            <select name="hotel_id" id="hotel_id" class="form-control" disabled>
                <option value=""><?php echo e(__('Select a Location First')); ?></option>
            </select>
        </div>
        <div class="item">
            <div id="reportrange_duplicate">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span>
                <input type="hidden" name="from">
                <input type="hidden" name="to">
            </div>
        </div>
        <div class="item">
            <button type="submit" class="btn-submit"><?php echo e(__("Apply")); ?></button>
        </div>
    </div>
                    </form>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="col-md-8">
                    <div class="g-statistic">
                        <div class="head"><?php echo e(__("Occupancy Statistic")); ?></div>
                        <div class="content">
                            <canvas id="earning_chart_duplicate"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="g-statistic">
                        <div class="head"><?php echo e(__("Occupancy Details")); ?></div>
                        <div class="content">
                            <div class="list-detail" id="list-detail-duplicate">
                                <?php if(!empty($earning_detail_data)): ?>
                                    <?php $__currentLoopData = $earning_detail_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="item item-<?php echo e($key); ?>">
                                            <span><?php echo e($detail['title']); ?>: </span> <?php echo e($detail['val']); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script.body'); ?>
    <script src="<?php echo e(url('libs/chart_js/Chart.min.js')); ?>"></script>
    <script src="<?php echo e(url('libs/daterange/moment.min.js')); ?>"></script>
    <script src="<?php echo e(url('libs/daterange/daterangepicker.min.js?_ver='.config('app.asset_version'))); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(url('libs/daterange/daterangepicker.css')); ?>"/>

    <script>
    jQuery(function ($) {
        // Function to initialize date range picker and set the callback
        function initDateRange(selector, start, end, cb) {
            $(selector).daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    '<?php echo e(__("Today")); ?>': [moment(), moment()],
                    '<?php echo e(__("Yesterday")); ?>': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '<?php echo e(__("Last 7 Days")); ?>': [moment().subtract(6, 'days'), moment()],
                    '<?php echo e(__("Last 30 Days")); ?>': [moment().subtract(29, 'days'), moment()],
                    '<?php echo e(__("This Month")); ?>': [moment().startOf('month'), moment().endOf('month')],
                    '<?php echo e(__("Last Month")); ?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '<?php echo e(__("This Year")); ?>': [moment().startOf('year'), moment().endOf('year')],
                    '<?php echo e(__('This Week')); ?>': [moment().startOf('week'), end]
                }
            }, cb);
        }

        // Callback function for date range picker
        function dateRangeCallback(start, end, selector) {
            $(selector + ' span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $(selector + ' input[name=from]').val(start.format('YYYY-MM-DD'));
            $(selector + ' input[name=to]').val(end.format('YYYY-MM-DD'));
        }

        // Initialize both date range pickers
        var start = moment().startOf('week'), end = moment();
        initDateRange('#reportrange', start, end, function(start, end) { dateRangeCallback(start, end, '#reportrange'); });
        initDateRange('#reportrange_duplicate', start, end, function(start, end) { dateRangeCallback(start, end, '#reportrange_duplicate'); });

        // First chart initialization and form submission
        var ctx = document.getElementById('earning_chart').getContext('2d');
        var myMixedChart = new Chart(ctx, {
            type: 'bar',
            data: <?php echo json_encode($earning_chart_data); ?>,
            options: { responsive: true }
        });

        $('#form-filter-statistic').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: '<?php echo e(route('report.admin.statistic.reloadChart')); ?>',
                data: form.serialize(),
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    if (res.status) {
                        // Update chart data and re-render
                        myMixedChart.data = res.chart_data;
                        myMixedChart.update();
                        
                        // Populate detail section for the first chart
                        $('#list-detail').html(res.detail_data.map(item => 
                            `<div class="item item-${item.key}">
                                <span>${item.title}: </span> ${item.val}
                            </div>`
                        ).join(''));
                    }
                }
            });
        });

        // Duplicate chart initialization and form submission
        var ctxDuplicate = document.getElementById('earning_chart_duplicate').getContext('2d');
        var myMixedChartDuplicate = new Chart(ctxDuplicate, {
            type: 'bar',
            data: <?php echo json_encode($earning_chart_data); ?>,
            options: { responsive: true }
        });

        $('#form-filter-statistic-duplicate').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: '<?php echo e(route('report.admin.statistic.reloadChart')); ?>',
                data: form.serialize(),
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    if (res.status) {
                        // Update chart data and re-render
                        myMixedChartDuplicate.data = res.chart_data;
                        myMixedChartDuplicate.update();

                        // Populate detail section based on detail_data type
                        if (Array.isArray(res.detail_data)) {
                            // If detail_data is an array, use map
                            $('#list-detail-duplicate').html(res.detail_data.map(item =>
                                `<div class="item item-${item.key}">
                                    <span>${item.title}: </span> ${item.val}
                                </div>`
                            ).join(''));
                        } else if (typeof res.detail_data === 'object') {
                            // If detail_data is an object, loop through its properties
                            const detailHtml = Object.keys(res.detail_data).map(key => {
                                const item = res.detail_data[key];
                                return `<div class="item item-${key}">
                                            <span>${item.title}: </span> ${item.val}
                                        </div>`;
                            }).join('');
                            $('#list-detail-duplicate').html(detailHtml);
                        }
                    }
                }
            });
        });

        function updateHotelDropdown(formSelector, locationId) {
    const hotelSelect = $(formSelector).find('#hotel_id');
    hotelSelect.html('<option value=""><?php echo e(__("Loading...")); ?></option>');
    hotelSelect.prop('disabled', true);

    if (locationId) {
        $.ajax({
            url: `/admin/reports/get-hotels-by-location/${locationId}`,
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                hotelSelect.html('<option value=""><?php echo e(__("All Resorts")); ?></option>');
                if (res.hotels && res.hotels.length) {
                    res.hotels.forEach(hotel => {
                        hotelSelect.append(`<option value="${hotel.id}">${hotel.title}</option>`);
                    });
                } else {
                    hotelSelect.append('<option value=""><?php echo e(__("No resorts found")); ?></option>');
                }
                hotelSelect.prop('disabled', false);
            },
            error: function () {
                hotelSelect.html('<option value=""><?php echo e(__("Failed to load resorts")); ?></option>');
            }
        });
    } else {
        hotelSelect.html('<option value=""><?php echo e(__("Select a Location First")); ?></option>');
    }
}


    // Attach handlers to both forms
    $('#form-filter-statistic #location_id').change(function () {
    updateHotelDropdown('#form-filter-statistic', $(this).val());
}).trigger('change');

$('#form-filter-statistic-duplicate #location_id').change(function () {
    updateHotelDropdown('#form-filter-statistic-duplicate', $(this).val());
}).trigger('change');


    function handleFormSubmission(formSelector, chartInstance, detailSelector) {
        $(formSelector).submit(function (e) {
            e.preventDefault();
            const form = $(this);
            $.ajax({
                url: '<?php echo e(route('report.admin.statistic.reloadChart')); ?>',
                data: form.serialize(),
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    if (res.status) {
                        // Update chart data
                        chartInstance.data = res.chart_data || {};
                        chartInstance.update();

                        // Populate detail data
                        const details = res.detail_data || [];
                        if (Array.isArray(details)) {
                            $(detailSelector).html(details.map(item =>
                                `<div class="item item-${item.key}">
                                    <span>${item.title}: </span> ${item.val}
                                </div>`
                            ).join(''));
                        } else if (typeof details === 'object') {
                            const detailHtml = Object.keys(details).map(key => {
                                const item = details[key];
                                return `<div class="item item-${key}">
                                            <span>${item.title}: </span> ${item.val}
                                        </div>`;
                            }).join('');
                            $(detailSelector).html(detailHtml);
                        } else {
                            $(detailSelector).html('<div><?php echo e(__("No details available")); ?></div>');
                        }
                    }
                },
                error: function () {
                    $(detailSelector).html('<div><?php echo e(__("Failed to load data")); ?></div>');
                }
            });
        });
    }

    // Initialize and handle submission for both forms
    handleFormSubmission('#form-filter-statistic', myMixedChart, '#list-detail');
    handleFormSubmission('#form-filter-statistic-duplicate', myMixedChartDuplicate, '#list-detail-duplicate');
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u1595410/public_html/modules/Report/Views/admin/statistic/index.blade.php ENDPATH**/ ?>