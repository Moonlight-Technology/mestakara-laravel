
<?php $__env->startSection('content'); ?>
    <?php if($row->template_id): ?>
        <div class="page-template-content">
            <?php echo $row->getProcessedContent(); ?>

        </div>
    <?php else: ?>
        <div class="container " style="padding-top: 40px;padding-bottom: 40px;">
            <h1><?php echo clean($translation->title); ?></h1>
            <div class="blog-content">
                <?php echo $translation->content; ?>

            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u301264826/domains/mestakara.com/public_html/mestakara/themes/Mytravel/Page/Views/frontend/detail.blade.php ENDPATH**/ ?>