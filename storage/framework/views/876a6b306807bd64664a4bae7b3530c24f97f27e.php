<?php if(is_default_lang()): ?>
    <div class="row">
        <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label"><strong><?php echo e(__('Attribute: :name',['name'=>$attribute->name])); ?></strong></label>
                    <div class="terms-scrollable">
                        <?php $__currentLoopData = $attribute->terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="term-item">
                                <input <?php if(!empty($selected_terms) and $selected_terms->contains($term->id)): ?> checked <?php endif; ?> type="checkbox" name="terms[]" value="<?php echo e($term->id); ?>">
                                <span class="term-name"><?php echo e($term->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <hr>
<?php endif; ?><?php /**PATH /home/u1595410/public_html/modules/Hotel/Views/admin/room/form-detail/attributes.blade.php ENDPATH**/ ?>