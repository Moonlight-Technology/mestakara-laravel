<div class="sidebar border border-color-1 rounded-xs">
    <div class="p-4 mb-1">
        <form action="<?php echo e(route("hotel.search")); ?>" class="bravo_form" method="get">
            <?php $search_fields = setting_item_array('hotel_search_fields');
            $search_fields = array_values(\Illuminate\Support\Arr::sort($search_fields, function ($value) {
                return $value['position'] ?? 0;
            }));
            ?>
            <?php if(!empty($search_fields)): ?>
                <?php $__currentLoopData = $search_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $field['title'] = $field['title_'.app()->getLocale()] ?? $field['title'] ?? "" ?>
                    <?php switch($field['field']):
                        case ('service_name'): ?>
                        <?php echo $__env->make('Hotel::frontend.layouts.search.fields.service_name', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php break; ?>
                        <?php case ('location'): ?>
                        <?php echo $__env->make('Hotel::frontend.layouts.search.fields.location', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php break; ?>
                        <?php case ('date'): ?>
                        <?php echo $__env->make('Hotel::frontend.layouts.search.fields.date', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php break; ?>
                        <?php case ('guests'): ?>
                        <?php echo $__env->make('Hotel::frontend.layouts.search.fields.guests', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php break; ?>
                    <?php endswitch; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <div class="text-center">
                <button type="submit" class="btn btn-primary height-60 w-100 font-weight-bold mb-xl-0 mb-lg-1 transition-3d-hover"><i class="flaticon-magnifying-glass mr-2 font-size-17"></i>Search</button>
            </div>
        </form>
    </div>
</div><?php /**PATH /home/u301264826/domains/mestakara.com/public_html/mestakara/themes/Mytravel/Hotel/Views/frontend/layouts/search/form-search-vertical.blade.php ENDPATH**/ ?>