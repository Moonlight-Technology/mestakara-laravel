
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar"><?php echo e(__('All Bookings')); ?></h1>
        </div>
        <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="filter-div d-flex justify-content-between">
            <div class="col-left">
                <?php if(!empty($booking_update)): ?>
                    <form method="post" action="<?php echo e(route('report.admin.booking.bulkEdit')); ?>" class="filter-form filter-form-left d-flex justify-content-start">
                        <?php echo csrf_field(); ?>
                        <select name="action" class="form-control">
                            <option value=""><?php echo e(__("-- Bulk Actions --")); ?></option>
                            <?php if(!empty($statues)): ?>
                                <?php $__currentLoopData = $statues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>"><?php echo e(__('Mark as: :name',['name'=>booking_status_to_text($status)])); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <option value="delete"><?php echo e(__("DELETE booking")); ?></option>
                        </select>
                        <button data-confirm="<?php echo e(__("Do you want to delete?")); ?>" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button"><?php echo e(__('Apply')); ?></button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="col-left">
                <form method="get" action="" class="filter-form filter-form-right d-flex justify-content-end">
                    <input type="text" name="date_range" class="form-control" id="date_range" value="<?php echo e(request()->query('date_range')); ?>" placeholder="<?php echo e(__('Select Date Range')); ?>" />

                    <?php echo csrf_field(); ?>
                    <?php if(!empty($booking_manage_others)): ?>
                        <?php
                        $user = !empty(Request()->vendor_id) ? App\User::find(Request()->vendor_id) : false;
                        \App\Helpers\AdminForm::select2('vendor_id', [
                            'configs' => [
                                'ajax'        => [
                                    'url'      => route('user.admin.getForSelect2'),
                                    'dataType' => 'json'
                                ],
                                'allowClear'  => true,
                                'placeholder' => __('-- Vendor --')
                            ]
                        ], !empty($user->id) ? [
                            $user->id,
                            $user->name_or_email . ' (#' . $user->id . ')'
                        ] : false)
                        ?>
                    <?php endif; ?>
                    <input type="text" name="s" value="<?php echo e(Request()->s); ?>" placeholder="<?php echo e(__('Search by name or ID')); ?>" class="form-control">
                    
                    <button class="btn-info btn btn-icon" type="submit"><?php echo e(__('Filter')); ?></button>
                    <button class="btn-success btn btn-icon" name="export" value="1" type="submit"><i class="fa fa-file-export"></i><?php echo e(__('Export')); ?></button>
                </form>
            </div>
        </div>
        <div class="text-right">
            <p><i><?php echo e(__('Found :total items',['total'=>$rows->total()])); ?></i></p>
        </div>
        <div class="panel booking-history-manager">
            <div class="panel-title"><?php echo e(__('Bookings')); ?></div>
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <table class="table table-hover bravo-list-item">
                        <thead>
                        <tr>
                            <th width="80px"><input type="checkbox" class="check-all"></th>
                            <th><?php echo e(__('Service')); ?></th>
                            <th><?php echo e(__('Customer')); ?></th>

                            <th><?php echo e(__('Payment Information')); ?></th>
                            <th  width="80px" ><?php echo e(__('Commission')); ?></th>
                            <th width="80px"><?php echo e(__('Status')); ?></th>
                            <th width="150px"><?php echo e(__('Payment Method')); ?></th>
                            <th width="120px"><?php echo e(__('Created At')); ?></th>
                            <th width="80px"><?php echo e(__('Actions')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php  $booking = $row; ?>
                            <tr>
                                <td><input type="checkbox" class="check-item" name="ids[]" value="<?php echo e($row->id); ?>">
                                    #<?php echo e($row->id); ?></td>
                                <td>
                                    <?php if($service = $row->service): ?>
                                        <a href="<?php echo e($service->getDetailUrl()); ?>" target="_blank"><?php echo e($service->title ?? ''); ?></a>
                                        <?php if($row->vendor): ?>
                                            <br>
                                            <span><?php echo e(__('by')); ?></span>
                                            <a href="<?php echo e(route('user.admin.detail',['id'=>$row->vendor_id])); ?>"
                                               target="_blank"><?php echo e($row->vendor->name_or_email.' (#'.$row->vendor_id.')'); ?></a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo e(__("[Deleted]")); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <ul>
                                        <li><?php echo e(__("Name:")); ?> <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?> </li>
                                        <li><?php echo e(__("Email:")); ?> <?php echo e($row->email); ?></li>
                                        <li><?php echo e(__("Phone:")); ?> <?php echo e($row->phone); ?></li>
                                        <li><?php echo e(__("Address:")); ?> <?php echo e($row->address); ?></li>
                                        <li><?php echo e(__("Custom Requirement:")); ?> <?php echo e($row->customer_notes); ?></li>
                                    </ul>
                                </td>
                                <td><?php echo e(__("Total")); ?> : <?php echo e(format_money_main($row->total)); ?><br/>
                                    <?php echo e(__("Paid")); ?> : <?php echo e(format_money_main($row->paid)); ?><br/>
                                    <?php echo e(__("Remain")); ?> : <?php echo e(format_money_main($booking->total - $booking->paid)); ?><br/>
                                </td>
                                <td>
                                    <?php echo e(format_money_main($booking->commission)); ?>

                                </td>
                                <td>
                                    <span class="label label-<?php echo e($row->status); ?>"><?php echo e($row->statusName); ?></span>
                                </td>
                                <td>
                                    <?php echo e($row->gatewayObj ? $row->gatewayObj->getDisplayName() : ''); ?>

                                </td>
                                <td><?php echo e(display_datetime($row->updated_at)); ?></td>
                                <td>
                                    <?php if($service = $row->service): ?>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(__('Actions')); ?>

                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-booking-<?php echo e($row->id); ?>"><?php echo e(__('Detail')); ?></a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-paid-<?php echo e($row->id); ?>"><?php echo e(__('Set Paid')); ?></a>
                                                <a class="dropdown-item" href="<?php echo e(route('report.admin.booking.email_preview',['id'=>$row->id])); ?>"><?php echo e(__('Email Preview')); ?></a>
                                            </div>
                                        </div>
                                        <?php echo $__env->make($service->checkout_booking_detail_modal_file ?? '', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php echo $__env->make($service->set_paid_modal_file ?? '', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <?php echo e($rows->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script.body'); ?>
    <script>
        $(document).on('click', '#set_paid_btn', function (e) {
            var id = $(this).data('id');
            $.ajax({
                url:bookingCore.url+'/booking/setPaidAmount',
                data:{
                    id: id,
                    remain: $('#modal-paid-'+id+' #set_paid_input').val(),
                },
                dataType:'json',
                type:'post',
                success:function(res){
                    alert(res.message);
                    window.location.reload();
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('#date_range').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                autoUpdateInput: false
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u301264826/domains/mestakara.com/public_html/mestakara/modules/Report/Views/admin/booking/index.blade.php ENDPATH**/ ?>