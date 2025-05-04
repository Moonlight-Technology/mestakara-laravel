@extends ('admin.layouts.app')
@section('script.head')
    <style type="text/css">
        .select2-container.select2-container--open .select2-dropdown {
            min-width: 220px !important;
        }
    </style>
@endsection
@section ('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__('Bookings Statistic')}}</h1>
        </div>
        @include('admin.message')
        
        <div class="bravo-statistic">
            <!-- Original Statistic Chart -->
            <div class="row">
                <div class="col-md-12">
                    <form id="form-filter-statistic" action="" class="form-filter-statistic">
                        <!-- Original Filter Bar -->
                        <div class="header-statistic">
        <div class="item">
            {{ __("Filter:") }}
        </div>
        <div class="item">
            <select name="location_id" id="location_id" class="form-control">
                <option value="">{{ __("Select Location") }}</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="item">
            <label for="hotel_id">{{ __('RESORT:') }}</label>
        </div>
        <div class="item">

            <select name="hotel_id" id="hotel_id" class="form-control" disabled>
                <option value="">{{ __('Select a Location First') }}</option>
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
            <button type="submit" class="btn-submit">{{ __("Apply") }}</button>
        </div>
    </div>
                    </form>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="col-md-8">
                    <div class="g-statistic">
                        <div class="head">{{__("Bookings Statistic")}}</div>
                        <div class="content">
                            <canvas id="earning_chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="g-statistic">
                        <div class="head">{{__("Booking Details")}}</div>
                        <div class="content">
                            <div class="list-detail" id="list-detail">
                                @if(!empty($earning_detail_data))
                                    @foreach($earning_detail_data as $key=>$detail)
                                        <div class="item item-{{$key}}">
                                            <span>{{$detail['title']}}: </span> {{$detail['val']}}
                                        </div>
                                    @endforeach
                                @endif
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
            {{ __("Filter:") }}
        </div>
        <div class="item">
            <select name="location_id" id="location_id" class="form-control">
                <option value="">{{ __("Select Location") }}</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="item">
            <label for="hotel_id">{{ __('RESORT:') }}</label>
        </div>
        <div class="item">

            <select name="hotel_id" id="hotel_id" class="form-control" disabled>
                <option value="">{{ __('Select a Location First') }}</option>
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
            <button type="submit" class="btn-submit">{{ __("Apply") }}</button>
        </div>
    </div>
                    </form>
                </div>
            </div>
            <div class="row row-eq-height">
                <div class="col-md-8">
                    <div class="g-statistic">
                        <div class="head">{{__("Occupancy Statistic")}}</div>
                        <div class="content">
                            <canvas id="earning_chart_duplicate"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="g-statistic">
                        <div class="head">{{__("Occupancy Details")}}</div>
                        <div class="content">
                            <div class="list-detail" id="list-detail-duplicate">
                                @if(!empty($earning_detail_data))
                                    @foreach($earning_detail_data as $key=>$detail)
                                        <div class="item item-{{$key}}">
                                            <span>{{$detail['title']}}: </span> {{$detail['val']}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script.body')
    <script src="{{url('libs/chart_js/Chart.min.js')}}"></script>
    <script src="{{url('libs/daterange/moment.min.js')}}"></script>
    <script src="{{url('libs/daterange/daterangepicker.min.js?_ver='.config('app.asset_version'))}}"></script>
    <link rel="stylesheet" href="{{url('libs/daterange/daterangepicker.css')}}"/>

    <script>
    jQuery(function ($) {
        // Function to initialize date range picker and set the callback
        function initDateRange(selector, start, end, cb) {
            $(selector).daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    '{{__("Today")}}': [moment(), moment()],
                    '{{__("Yesterday")}}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '{{__("Last 7 Days")}}': [moment().subtract(6, 'days'), moment()],
                    '{{__("Last 30 Days")}}': [moment().subtract(29, 'days'), moment()],
                    '{{__("This Month")}}': [moment().startOf('month'), moment().endOf('month')],
                    '{{__("Last Month")}}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '{{__("This Year")}}': [moment().startOf('year'), moment().endOf('year')],
                    '{{__('This Week')}}': [moment().startOf('week'), end]
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
            data: {!! json_encode($earning_chart_data) !!},
            options: { responsive: true }
        });

        $('#form-filter-statistic').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: '{{route('report.admin.statistic.reloadChart')}}',
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
            data: {!! json_encode($earning_chart_data) !!},
            options: { responsive: true }
        });

        $('#form-filter-statistic-duplicate').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: '{{route('report.admin.statistic.reloadChart')}}',
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
    hotelSelect.html('<option value="">{{ __("Loading...") }}</option>');
    hotelSelect.prop('disabled', true);

    if (locationId) {
        $.ajax({
            url: `/admin/reports/get-hotels-by-location/${locationId}`,
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                hotelSelect.html('<option value="">{{ __("All Resorts") }}</option>');
                if (res.hotels && res.hotels.length) {
                    res.hotels.forEach(hotel => {
                        hotelSelect.append(`<option value="${hotel.id}">${hotel.title}</option>`);
                    });
                } else {
                    hotelSelect.append('<option value="">{{ __("No resorts found") }}</option>');
                }
                hotelSelect.prop('disabled', false);
            },
            error: function () {
                hotelSelect.html('<option value="">{{ __("Failed to load resorts") }}</option>');
            }
        });
    } else {
        hotelSelect.html('<option value="">{{ __("Select a Location First") }}</option>');
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
                url: '{{route('report.admin.statistic.reloadChart')}}',
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
                            $(detailSelector).html('<div>{{ __("No details available") }}</div>');
                        }
                    }
                },
                error: function () {
                    $(detailSelector).html('<div>{{ __("Failed to load data") }}</div>');
                }
            });
        });
    }

    // Initialize and handle submission for both forms
    handleFormSubmission('#form-filter-statistic', myMixedChart, '#list-detail');
    handleFormSubmission('#form-filter-statistic-duplicate', myMixedChartDuplicate, '#list-detail-duplicate');
});
</script>

@endsection
