<div class="item">
    <div class="col dropdown-custom px-0 mb-4 form-select-guests">
        <span class="d-block text-gray-1 text-left font-weight-normal">{{ $field['title'] ?? "" }}</span>
        <div class="flex-horizontal-center border-bottom border-width-2 border-color-1 py-2 d-flex  dropdown-toggle" data-toggle="dropdown">
            <i class="flaticon-add-group d-flex align-items-center mr-3 font-size-20 text-primary font-weight-semi-bold"></i>
            @php
                $adults = request()->query('adults',1);
                // $children = request()->query('children',0);
            @endphp
            <div class="text-black font-size-16 font-weight-semi-bold mr-auto">
               <div class="render">
                    <span class="adults" ><span class="one @if($adults >1) d-none @endif">{{__('1 Person')}}</span> <span class="@if($adults <= 1) d-none @endif multi" data-html="{{__(':count Persons')}}">{{__(':count Persons',['count'=>request()->query('adults',1)])}}</span></span>
                    
                    {{-- <span class="children">
                        <span class="one @if($children >1) d-none @endif" data-html="{{__(':count Child')}}">{{__(':count Child',['count'=>request()->query('children',0)])}}</span>
                        <span class="multi @if($children <=1) d-none @endif" data-html="{{__(':count Children')}}">{{__(':count Children',['count'=>request()->query('children',0)])}}</span>
                    </span> --}}
               </div>
            </div>
        </div>
        <div class="dropdown-menu select-guests-dropdown" >
            <div class="dropdown-item-row">
                <div class="label">{{__('Persons')}}</div>
                <div class="val">
                    <span class="btn-minus" data-input="adults"><i class="icon ion-md-remove"></i></span>
                    <span class="count-display"><input type="number" name="adults" value="{{request()->query('adults',1)}}" min="1"></span>
                    <span class="btn-add" data-input="adults"><i class="icon ion-ios-add"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>