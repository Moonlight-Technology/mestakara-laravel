<?php if(is_default_lang()): ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo e(__("Price")); ?> <span class="text-danger">*</span></label>
                <input type="number" required value="<?php echo e($row->price); ?>" min="1" placeholder="<?php echo e(__("Price")); ?>" name="price" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo e(__("Number of room")); ?> <span class="text-danger">*</span></label>
                <input type="number" required value="<?php echo e($row->number ?? 1); ?>" min="1" max="100" placeholder="<?php echo e(__("Number")); ?>" name="number" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <input type="checkbox" id="is_weekend" value="1" name="is_weekend" class="form-control" <?php echo e($row->is_weekend ?'checked' : ''); ?>>
                <span><?php echo e(__("Weekend Price")); ?></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="pricing_weekend" style="display: none;">
            <div class="form-group">
                <span><?php echo e(__("Price")); ?></span>
                <input type="text" value="<?php echo e($row->weekend_price ?? ''); ?>" name="weekend_price" class="form-control">
            </div>
        </div>
    </div>
    <script>
        // Mendapatkan elemen checkbox dan div pricing_weekend
        const isWeekendCheckbox = document.getElementById('is_weekend');
        const pricingWeekendDiv = document.getElementById('pricing_weekend');

        // Fungsi untuk menampilkan atau menyembunyikan pricing_weekend
        function togglePricingWeekend() {
            if (isWeekendCheckbox.checked) {
                pricingWeekendDiv.style.display = 'block'; // Menampilkan div
            } else {
                pricingWeekendDiv.style.display = 'none';  // Menyembunyikan div
            }
        }

        // Jalankan fungsi saat checkbox di klik
        isWeekendCheckbox.addEventListener('change', togglePricingWeekend);

        // Jalankan fungsi saat halaman dimuat (untuk menjaga status yang sudah di-check sebelumnya)
        window.onload = togglePricingWeekend;

    </script>
    <hr>
    <?php if(is_default_lang()): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="control-label"><?php echo e(__("Minimum day stay requirements")); ?></label>
                    <input type="number" name="min_day_stays" class="form-control" value="<?php echo e($row->min_day_stays); ?>" placeholder="<?php echo e(__("Ex: 2")); ?>">
                    <i><?php echo e(__("Leave blank if you dont need to set minimum day stay option")); ?></i>
                </div>
            </div>
        </div>
        <hr>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo e(__("Number of beds")); ?> </label>
                <input type="number"  value="<?php echo e($row->beds ?? 1); ?>" min="1" max="10" placeholder="<?php echo e(__("Number")); ?>" name="beds" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo e(__("Room Size")); ?> </label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="size" value="<?php echo e($row->size ?? 0); ?>" placeholder="<?php echo e(__("Room size")); ?>" >
                    <div class="input-group-append">
                        <span class="input-group-text" ><?php echo size_unit_format(); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label><?php echo e(__("Max Persons")); ?> </label>
                <input type="number" min="1"  value="<?php echo e($row->adults ?? 1); ?>"  name="adults" class="form-control">
            </div>
        </div>
    </div>
    <hr>
<?php endif; ?><?php /**PATH /home/u1595410/public_html/modules/Hotel/Views/admin/room/form-detail/pricing.blade.php ENDPATH**/ ?>