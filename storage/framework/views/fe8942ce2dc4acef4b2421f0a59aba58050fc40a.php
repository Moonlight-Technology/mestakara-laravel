<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parallax Search Service</title>
    
    <!-- Parallax CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/parallax.css')); ?>">

    <!-- Debugging CSS (optional, for troubleshooting purposes) -->
    <style>
        /* Force z-index and background color for debugging */
        .foreground-content {
            position: relative;
            z-index: 999; /* Ensure it is above the images */
            background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent to ensure visibility */
        }

        /* Ensure all images are positioned correctly */
        .parahero img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1; /* Set the images behind the content */
        }

        /* Set container z-index higher than the images */
        .parahero {
            position: relative;
            z-index: 2;
            height: 100vh;
            overflow: hidden;
        }

        /* Forcing visibility for the title, subtitle, and form search */
        h1.font-size-60, p.font-size-20, .form-search-container {
            position: relative;
            z-index: 10;
            color: #fff;
        }
        
        .form-search-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Parallax Section -->
    <div class="bravo-form-search-all hero-block hero-v1 bg-img-hero-bottom gradient-overlay-half-black-gradient text-center z-index-2 parahero">
        <!-- Parallax Images -->
        <img src="<?php echo e(asset('assets/img/0.png')); ?>" alt="Layer 0" class="last-img">
        <img src="<?php echo e(asset('assets/img/2.png')); ?>" alt="Layer 3" class="para-img">
        <img src="<?php echo e(asset('assets/img/1.png')); ?>" alt="Layer 1" class="mid-img">
        <img src="<?php echo e(asset('assets/img/4.png')); ?>" alt="Layer 2" class="leaf-img">

        <!-- <section id="landing">
            <h1>W E L C O M E</h1>
        </section> -->
        
        <!-- Foreground content: title, subtitle, and form search -->
        <div class="container space-2 space-top-xl-4 foreground-content">
            <div class="row justify-content-center pb-xl-8">
                <div class="py-8 py-xl-10 pb-5" style="opacity: 0">
                    <!-- <h1 class="font-size-60 font-size-xs-30 text-white font-weight-bold"><?php echo e($title ?? 'Title Goes Here'); ?></h1>
                    <p class="font-size-20 font-weight-normal text-white"><?php echo e($sub_title ?? 'Subtitle Goes Here'); ?></p> -->
                </div>
            </div>

            <!-- Form Search Service in foreground -->
            <?php if(empty($hide_form_search)): ?>
                <div class="form-search-container mb-lg-n1">
                    <ul class="nav tab-nav-rounded flex-nowrap pb-2 pb-md-4 tab-nav <?php if(!empty($single_form_search)): ?> d-none <?php endif; ?>" role="tablist">
                        <?php if(!empty($service_types)): ?>
                            <?php $number = 0; ?>
                            <?php $__currentLoopData = $service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $allServices = get_bookable_services();
                                    if(empty($allServices[$service_type])) continue;
                                    $module = new $allServices[$service_type];
                                ?>
                                <li class="nav-item" role="bravo_<?php echo e($service_type); ?>">
                                    <a class="nav-link font-weight-medium <?php if($number == 0): ?> active <?php endif; ?> pl-md-5 pl-3" id="bravo_<?php echo e($service_type); ?>-tab" data-toggle="pill" href="#bravo_<?php echo e($service_type); ?>" role="tab" aria-controls="bravo_<?php echo e($service_type); ?>" aria-selected="true">
                                        <div class="d-flex flex-column flex-md-row position-relative text-white align-items-center">
                                            <figure class="ie-height-40 d-md-block mr-md-3">
                                                <i class="icon <?php echo e($module->getServiceIconFeatured()); ?> font-size-3"></i>
                                            </figure>
                                            <span class="tabtext mt-2 mt-md-0 font-weight-semi-bold">
                                                <?php echo e(!empty($modelBlock["title_for_".$service_type]) ? $modelBlock["title_for_".$service_type] : $module->getModelName()); ?>

                                            </span>
                                        </div>
                                    </a>
                                </li>
                                <?php $number++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>

                    <div class="tab-content hero-tab-pane">
                        <?php if(!empty($service_types)): ?>
                            <?php $number = 0; ?>
                            <?php $__currentLoopData = $service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $allServices = get_bookable_services();
                                    if(empty($allServices[$service_type])) continue;
                                ?>
                                <div class="tab-pane fade <?php if($number == 0): ?> active show <?php endif; ?>" id="bravo_<?php echo e($service_type); ?>" role="tabpanel" aria-labelledby="bravo_<?php echo e($service_type); ?>-tab">
                                    <div class="card border-0 tab-shadow">
                                        <div class="card-body">
                                            <?php echo $__env->make(ucfirst($service_type).'::frontend.layouts.search.form-search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php $number++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Parallax JS -->
    <script src="<?php echo e(asset('assets/js/parallax.js')); ?>"></script>
    
    <!-- Your other JS files can go here -->
</body>
</html>
<?php /**PATH E:\Projects\Coding\mestakara\mestakara\themes/Mytravel/Template/Views/frontend/blocks/form-search-all-service/style_1.blade.php ENDPATH**/ ?>