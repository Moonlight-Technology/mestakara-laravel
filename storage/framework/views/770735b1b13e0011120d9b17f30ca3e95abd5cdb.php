<?php
$main_color =setting_item('style_main_color','#5291fa')
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <title></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' id='google-font-css-css'  href='https://fonts.googleapis.com/css?family=Poppins%3A400%2C500%2C600' type='text/css' media='all' />
        <style>
            .b-email-wrap{
                background: #ebeef2;
                padding: 40px 0px;
                color: #1A2B48;
                font-size: 14px;
                font-family: 'Poppins', sans-serif !important;
                font-weight: normal;
                line-height: 1.5;
                overflow-x: hidden;
                margin: 0px;
            }
            .b-header{
                background: <?php echo e($main_color); ?>;
                padding: 30px;
                color: white;
            }
            .b-header .site-title,
            .b-header h1,
            .b-header h2,
            .b-header h3,
            .b-header h4,
            .b-header h5,
            .b-header p
            {
                margin:0px;
                display: block;
                text-align: center;
            }
            .b-container{
                max-width: 600px;
                margin: 0px auto;
            }

            .b-panel{
                border: 1px solid rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
                padding: 30px;
                background: white;
            }
            .b-panel .b-panel{
                padding: 0px;
                box-shadow: none;
            }
            .b-panel-title{
                text-align: center;
                margin-bottom: 30px;
                font-size: 24px;
                font-weight: 500;
            }
            .b-table-wrap{
                overflow-x:auto;
            }
            .b-table{
                width: 100%;
            }
            .b-table tr td,
            .b-table .b-tr,
            .b-table tr th{
                padding: 10px;
            }
            .b-table .b-tr{
                clear: both;
                border-bottom: 1px solid #EAEEF3;
            }
            .b-table .b-tr:after{
                display: table;
                clear: both;
                content:'';
            }
            .b-table tr td{
                border-bottom: 1px solid #EAEEF3;
            }
            .b-table tbody tr:nth-child(even) td{
                /*background: #f5f7fd;*/
            }
            .b-table tbody tr td.label,
            .b-table .b-tr .label{
                font-weight: 500;
            }
            .b-table tbody tr td.val,
            .b-table .b-tr .val{
                text-align: right;
            }

            .b-table tbody tr td.val p,
            .b-table .b-tr .val p{
                padding: 0;
                margin: 0;
            }

            .b-table .b-tr .label,
            .b-table .b-tr .val{
                float: left;
                width: 50%;
            }
            .pricing-list{
                text-align: left;
                margin: 0px;
                padding: 0px;
                list-style: none;
            }
            .pricing-list td{
                padding: 7px 0px;
            }
            .pricing-list td .val{
                text-align: right;
            }
            .pricing-list .no-flex{
                display: block;
            }
            .email-headline{
                margin-top: 0px;
            }

            .text-center{
                text-align: center;
            }

            .btn{
                display: inline-block;
                color: #212529;
                text-align: center;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-color: #ebeef2;
                line-height: 1.5;
                border: none;
                -webkit-box-shadow: none;
                box-shadow: none;
                border-radius: 3px;
                padding: 7px 20px;
                -webkit-transition: background .2s, color .2s;
                transition: background .2s, color .2s;
                font-size: 14px;
                font-weight: 500;
                text-decoration: none;
            }
            .btn.btn-primary{

                background: #5191FA;
                color: white;
            }
            .mt20{
                margin-top: 20px;
            }
            .no-padding{
                padding: 0px;
            }
            .no-r-padding{
                padding-right: 0px!important;
            }
            .fsz21{
                font-size: 21px;
            }
            .no-b-border{
                border-bottom: 0px!important;
            }
            @media  screen and (max-width: 768px) {
                .b-panel{
                    padding: 15px;
                }
                .b-table tr td,
                .b-table tr th{
                    padding-right: 2px;
                    padding-left: 2px;
                }
                .b-panel-title{
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 15px;
                }
                .b-email-wrap{
                    padding: 0px;
                }

                .b-table .b-tr .label,
                .b-table .b-tr .val{
                    float:none;
                }

                .b-table .b-tr .val{
                    text-align: left;
                }
            }
            <?php if(setting_item_with_lang('enable_rtl')): ?>
                .b-email-wrap{
                    direction: rtl;
                }
                .b-table tbody tr td.val, .b-table .b-tr .val {
                    text-align: left;
                }
                .b-table .b-tr .label, .b-table .b-tr .val {
                    float: right;
                }
            <?php endif; ?>
        </style>
    </head>
    <body>
        <div class="b-email-wrap">
            <?php echo $__env->make('Email::parts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->yieldContent('content'); ?>

            <?php echo $__env->make('Email::parts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </body>
</html>
<?php /**PATH /home/u301264826/domains/mestakara.com/public_html/mestakara/modules/Email/Views/layout.blade.php ENDPATH**/ ?>