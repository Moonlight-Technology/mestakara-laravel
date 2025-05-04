
<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('news.admin.tag.store',['id'=>$row->id])); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="container">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar"><?php echo e($row->id ? 'Edit: '.$row->name : 'Add new tag'); ?></h1>
                    <?php if($row->slug): ?>
                        <p class="item-url-demo"> <?php echo e(__('Permalink:')); ?> <?php echo e(url('news/tag')); ?>/<a href="#" class="open-edit-input" data-name="slug"><?php echo e($row->slug); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="">
                    <?php if($row->slug): ?>
                        <a class="btn btn-primary btn-sm" href="<?php echo e($row->getDetailUrl()); ?>" target="_blank"> <?php echo e(__('View')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('Language::admin.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="panel-body">
                                <h3 class="panel-body-title"> <?php echo e(__('Tag Content')); ?></h3>
                                <?php echo $__env->make('News::admin/tag/form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                        <?php echo $__env->make('Core::admin/seo-meta/seo-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="col-md-3">
                        <div class="panel">
                            <div class="panel-title"><strong><?php echo e(__("Publish")); ?></strong></div>
                            <div class="panel-body">
                                <button class="btn btn-success" type="submit"> <i class="fa fa-save"></i> <?php echo e(__('Save Change')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script.body'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u1595410/public_html/modules/News/Views/admin/tag/detail.blade.php ENDPATH**/ ?>