

<?php $__env->startSection('content'); ?>
    <div class="bravo-booking-detail padding-content">
        <div class="bg-gray space-2">
            <div class="container">
                <div class="row booking-detail-notice">
                    <div class="col-lg-12">
                        <div class="mb-5 shadow-soft bg-white rounded-sm">
                            <div class="py-6 px-5 border-bottom">
                                <div class="flex-horizontal-center">
                                    <div class="height-50 width-50 flex-shrink-0 flex-content-center bg-primary rounded-circle">
                                        <i class="flaticon-info text-white font-size-24"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="font-size-18 font-weight-bold text-dark mb-0 text-lh-sm">
                                            <?php echo e(__("Booking Details for Order #:code", ['code' => $booking->code])); ?>

                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <?php echo $__env->make($service->booking_customer_info_file ?? 'Booking::frontend/booking/booking-customer-info', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->make($service->checkout_booking_detail_file ?? '', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <?php if($show_payment_button): ?>
                                <div class="text-right py-4 pr-4">
                                    <button id="pay-button" class="btn btn-primary rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3"><?php echo e(__('Pay Now')); ?></button>
                                </div>
                            <?php else: ?>
                                <div class="text-right py-4 pr-4">
                                    <a href="<?php echo e(route('user.booking_history')); ?>" class="btn btn-primary rounded-sm transition-3d-hover font-size-16 font-weight-bold py-3"><?php echo e(__('Booking History')); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($show_payment_button): ?>
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('midtrans.clientKey')); ?>"></script>
        <script>
            document.getElementById('pay-button').addEventListener('click', function () {
                var snapToken = "<?php echo e($snap_token); ?>";
                snap.pay(snapToken, {
                    onSuccess: function (result) {
                        console.log(result);
                        window.open(result.finish_redirect_url, '_blank');
                    },
                    onPending: function (result) {
                        console.log(result);
                        alert('Transaction pending');
                    },
                    onError: function (result) {
                        console.log(result);
                        alert('Transaction error');
                    }
                });
            });
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u1595410/public_html/themes/Mytravel/Booking/Views/frontend/detail.blade.php ENDPATH**/ ?>