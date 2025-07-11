<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="<?php echo e($html_class ?? ''); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php event(new \Modules\Layout\Events\LayoutBeginHead()); ?>
    <?php
        $favicon = setting_item('site_favicon');
    ?>
    <?php if($favicon): ?>
        <?php
            $file = (new \Modules\Media\Models\MediaFile())->findById($favicon);
        ?>
        <?php if(!empty($file)): ?>
            <link rel="icon" type="<?php echo e($file['file_type']); ?>" href="<?php echo e(asset('uploads/'.$file['file_path'])); ?>" />
        <?php else: ?>:
            <link rel="icon" type="image/png" href="<?php echo e(url('images/favicon.png')); ?>" />
        <?php endif; ?>
    <?php endif; ?>

    <?php echo $__env->make('Layout::parts.seo-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="<?php echo e(asset('libs/bootstrap/css/bootstrap.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('libs/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('libs/ionicons/css/ionicons.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('libs/icofont/icofont.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('libs/select2/css/select2.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('themes/mytravel/libs/fancybox/jquery.fancybox.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('themes/mytravel/libs/slick/slick.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('themes/mytravel/libs/custombox/custombox.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('themes/mytravel/dist/frontend/css/notification.css')); ?>" rel="newest stylesheet">
    <link href="<?php echo e(asset('themes/mytravel/dist/frontend/css/app.css?_ver='.config('app.version'))); ?>" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("libs/daterange/daterangepicker.css")); ?>" >
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Rubik:300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Libre+Franklin:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('themes/mytravel/libs/bootstrap-select/dist/css/bootstrap-select.min.css')); ?>">
    <link href="<?php echo e(asset('libs/ion_rangeslider/css/ion.rangeSlider.css')); ?>" rel="stylesheet">
    <style>
        .chat-box{
            position:fixed;
            bottom:20px;
            right:80px;
            width:300px;
            border:1px solid #ccc;
            border-radius: 5px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            background-color:white;
            display:none;
            z-index:1000;
        }

        .chat-toggle{
            position:fixed;
            bottom:100px;
            right:20px;
            background-color:#007bff;
            color:white;
            padding:10px;
            border-radius:5px;
            cursor:pointer;
            z-index:1000;
        }

        .chat-header{
            color:white;
            background-color:#007bff;
            padding:10px;
            border-top-left-radius:5px;
            border-top-right-radius:5px;
            text-align:center;
        }

        .chat-body{
            max-height:300ox;
            overflow-y:auto;
            padding:10px;
        }

        .message{
            margin:5px 0;
            padding:10px;
            border-radius:5px;
        }

        .user{
            background-color:#d1e7dd;
            align-self:flex-end;
        }

        .bot{
            background-color:#f8d7da;
            align-self:flex-start;
        }

        .chat-input{
            width:100%;
            padding:10px;
            border:none;
            border-top:1px solid #ccc;
            border-bottom-left-radius:5px;
            border-bottom-right-radius:5px;
        }
    </style>

    <?php echo \App\Helpers\Assets::css(); ?>

    <?php echo \App\Helpers\Assets::js(); ?>

    <script>
        var bookingCore = {
            url:'<?php echo e(url( app_get_locale() )); ?>',
            url_root:'<?php echo e(url('')); ?>',
            booking_decimals:<?php echo e((int)get_current_currency('currency_no_decimal',2)); ?>,
            thousand_separator:'<?php echo e(get_current_currency('currency_thousand')); ?>',
            decimal_separator:'<?php echo e(get_current_currency('currency_decimal')); ?>',
            currency_position:'<?php echo e(get_current_currency('currency_format')); ?>',
            currency_symbol:'<?php echo e(currency_symbol()); ?>',
			currency_rate:'<?php echo e(get_current_currency('rate',1)); ?>',
            date_format:'<?php echo e(get_moment_date_format()); ?>',
            map_provider:'<?php echo e(setting_item('map_provider')); ?>',
            map_gmap_key:'<?php echo e(setting_item('map_gmap_key')); ?>',
            routes:{
                login:'<?php echo e(route('login')); ?>',
                register:'<?php echo e(route('auth.register')); ?>',
                checkout:'<?php echo e(is_api() ? route('api.booking.doCheckout') : route('booking.doCheckout')); ?>'
            },
            module:{
                hotel:'<?php echo e(route('hotel.search')); ?>',
                car:'<?php echo e(route('car.search')); ?>',
                tour:'<?php echo e(route('tour.search')); ?>',
                space:'<?php echo e(route('space.search')); ?>',
                flight:"<?php echo e(route('flight.search')); ?>"
            },
            currentUser: <?php echo e((int)Auth::id()); ?>,
            isAdmin : <?php echo e(is_admin() ? 1 : 0); ?>,
            //rtl: <?php echo e(setting_item_with_lang('enable_rtl') ? "1" : "0"); ?>,
            rtl: 0,
            markAsRead:'<?php echo e(route('core.notification.markAsRead')); ?>',
            markAllAsRead:'<?php echo e(route('core.notification.markAllAsRead')); ?>',
            loadNotify : '<?php echo e(route('core.notification.loadNotify')); ?>',
            pusher_api_key : '<?php echo e(setting_item("pusher_api_key")); ?>',
            pusher_cluster : '<?php echo e(setting_item("pusher_cluster")); ?>',
        };
        var i18n = {
            warning:"<?php echo e(__("Warning")); ?>",
            success:"<?php echo e(__("Success")); ?>",
        };
        var daterangepickerLocale = {
            "applyLabel": "<?php echo e(__('Apply')); ?>",
            "cancelLabel": "<?php echo e(__('Cancel')); ?>",
            "fromLabel": "<?php echo e(__('From')); ?>",
            "toLabel": "<?php echo e(__('To')); ?>",
            "customRangeLabel": "<?php echo e(__('Custom')); ?>",
            "weekLabel": "<?php echo e(__('W')); ?>",
            "first_day_of_week": <?php echo e(setting_item("site_first_day_of_the_weekin_calendar","1")); ?>,
            "daysOfWeek": [
                "<?php echo e(__('Su')); ?>",
                "<?php echo e(__('Mo')); ?>",
                "<?php echo e(__('Tu')); ?>",
                "<?php echo e(__('We')); ?>",
                "<?php echo e(__('Th')); ?>",
                "<?php echo e(__('Fr')); ?>",
                "<?php echo e(__('Sa')); ?>"
            ],
            "monthNames": [
                "<?php echo e(__('January')); ?>",
                "<?php echo e(__('February')); ?>",
                "<?php echo e(__('March')); ?>",
                "<?php echo e(__('April')); ?>",
                "<?php echo e(__('May')); ?>",
                "<?php echo e(__('June')); ?>",
                "<?php echo e(__('July')); ?>",
                "<?php echo e(__('August')); ?>",
                "<?php echo e(__('September')); ?>",
                "<?php echo e(__('October')); ?>",
                "<?php echo e(__('November')); ?>",
                "<?php echo e(__('December')); ?>"
            ],
        };
    </script>
    <!-- Styles -->
    <?php echo $__env->yieldContent('head'); ?>
    
    <link href="<?php echo e(route('core.style.customCss')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('libs/carousel-2/owl.carousel.css')); ?>" rel="stylesheet">
    <?php if(setting_item_with_lang('enable_rtl')): ?>
<!--        <link href="<?php echo e(asset('dist/frontend/css/rtl.css')); ?>" rel="stylesheet">-->
    <?php endif; ?>
    <?php echo setting_item('head_scripts'); ?>

    <?php echo setting_item_with_lang_raw('head_scripts'); ?>


    <?php event(new \Modules\Layout\Events\LayoutEndHead()); ?>

</head>
<body class="frontend-page <?php echo e($body_class ?? ''); ?> <?php if(!empty($is_home) or !empty($header_transparent)): ?> header_transparent <?php endif; ?> <?php if(setting_item_with_lang('enable_rtl')): ?> is-rtl <?php endif; ?> <?php if(is_api()): ?> is_api <?php endif; ?>">
    <?php event(new \Modules\Layout\Events\LayoutBeginBody()); ?>

    <?php echo setting_item('body_scripts'); ?>

    <?php echo setting_item_with_lang_raw('body_scripts'); ?>

    <div class="bravo_wrap">
        <?php if(!is_api()): ?>
            <?php echo $__env->make('Layout::parts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>

        <?php echo $__env->make('Layout::parts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php echo setting_item('footer_scripts'); ?>

    <?php echo setting_item_with_lang_raw('footer_scripts'); ?>

    <?php event(new \Modules\Layout\Events\LayoutEndBody()); ?>
    <?php echo $__env->make('demo_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /home/u301264826/domains/mestakara.com/public_html/mestakara/themes/Mytravel/Layout/app.blade.php ENDPATH**/ ?>