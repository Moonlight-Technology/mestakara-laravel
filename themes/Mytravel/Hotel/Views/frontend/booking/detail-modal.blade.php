<div class="modal fade" id="modal-booking-{{$booking->id}}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{__("Booking Code")}}: #{{$booking->code}}</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#booking-detail-{{$booking->id}}">{{__("Booking Detail")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#booking-customer-{{$booking->id}}">

                            {{__("Customer Information")}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="booking-detail-{{$booking->id}}" class="tab-pane active"><br>
                        <div class="booking-review">
                            <div class="booking-review-content">
                                <div class="review-section">
                                    <div class="info-form">
                                        <ul>
                                            <li>
                                                <div class="label">{{__('Booking Status')}}</div>
                                                <div class="val">{{$booking->statusName}}</div>
                                            </li>
                                            <li>
                                                <div class="label">{{__('Booking Date')}}</div>
                                                <div class="val">{{display_date($booking->created_at)}}</div>
                                            </li>
                                            @if(!empty($booking->gateway))
                                                <?php $gateway = get_payment_gateway_obj($booking->gateway);?>
                                                @if($gateway)
                                                    <li>
                                                        <div class="label">{{__('Payment Method')}}</div>
                                                        <div class="val">{{$gateway->name}}</div>
                                                    </li>
                                                @endif
                                                @if($gateway and $note = $gateway->getOption('payment_note'))
                                                    <li>
                                                        <div class="label">{{__('Payment Note')}}</div>
                                                        <div class="val">{!! clean($note) !!}</div>
                                                    </li>
                                                @endif
                                            @endif
                                            @php $vendor = $service->author; @endphp
                                            @if($vendor->hasPermissionTo('dashboard_vendor_access') and !$vendor->hasPermissionTo('dashboard_access'))
                                                <li>
                                                    <div class="label">{{ __("Vendor") }}</div>
                                                    <div class="val"><a href="{{route('user.profile',['id'=>$vendor->id])}}" target="_blank" >{{$vendor->getDisplayName()}}</a></div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="more-booking-review">
                            @include ($service->checkout_booking_detail_file ?? '')
                        </div>
                    </div>
                    <div id="booking-customer-{{$booking->id}}" class="tab-pane fade"><br>
                        @include ($service->booking_customer_info_file ?? 'Booking::frontend/booking/booking-customer-info')
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <span class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</span>
            </div>
        </div>
    </div>
</div>
