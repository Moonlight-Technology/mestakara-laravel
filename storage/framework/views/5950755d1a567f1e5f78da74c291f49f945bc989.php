<div class="item">
	<span class="d-block text-gray-1  font-weight-normal mb-0 text-left">
		<?php echo e($field['title'] ?? ""); ?>

	</span>
	<?php if(setting_item('hotel_location_search_style')=='autocompletePlace'): ?>
		<div class="mb-4">
			<div class="input-group border-bottom border-width-2 border-color-1 py-2">
				<i class="flaticon-pin-1 d-flex align-items-center mr-2 text-primary font-weight-semi-bold font-size-22"></i>
				<div class="g-map-place border-0 p-0 form-control  height-40 d-flex" >
					<input type="text" name="map_place" placeholder="<?php echo e(__("Where are you going?")); ?>"  value="<?php echo e(request()->input('map_place')); ?>" class="font-weight-bold font-size-16 shadow-none hero-form font-weight-bold border-0 p-0">
					<div class="map d-none" id="map-<?php echo e(\Illuminate\Support\Str::random(10)); ?>"></div>
					<input type="hidden" name="map_lat" value="<?php echo e(request()->input('map_lat')); ?>">
					<input type="hidden" name="map_lgn" value="<?php echo e(request()->input('map_lgn')); ?>">
				</div>
			</div>
		</div>
	<?php else: ?>
		<div class="mb-4">
			<div class="input-group border-bottom border-width-2 border-color-1 py-2">
				<i class="flaticon-pin-1 d-flex align-items-center mr-2 text-primary font-weight-semi-bold font-size-22"></i>
				<?php
				$location_name = "";
				$list_json = [];
				$traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json, &$location_name) {
					foreach ($locations as $location) {
						$translate = $location->translateOrOrigin(app()->getLocale());
						if (Request::query('location_id') == $location->id) {
							$location_name = $translate->name;
						}
						$list_json[] = [
								'id'    => $location->id,
								'title' => $prefix.' '.$translate->name,
						];
						$traverse($location->children, $prefix.'-');
					}
				};
				$traverse($list_location);
				?>
				<div class="smart-search border-0 p-0 form-control  height-40">
					<input type="text" class="smart-search-location parent_text  font-weight-bold font-size-16 shadow-none hero-form font-weight-bold border-0 p-0" <?php echo e(( empty(setting_item("hotel_location_search_style")) or setting_item("hotel_location_search_style") == "normal" ) ? "readonly" : ""); ?> placeholder="<?php echo e(__("Where are you going?")); ?>" value="<?php echo e($location_name); ?>" data-onLoad="<?php echo e(__("Loading...")); ?>"
						   data-default="<?php echo e(json_encode($list_json)); ?>">
					<input type="hidden" class="child_id" name="location_id" value="<?php echo e(Request::query('location_id')); ?>">
				</div>
			</div>
		</div>
	<?php endif; ?>
</div><?php /**PATH /home/u301264826/domains/mestakara.com/public_html/mestakara/themes/Mytravel/Hotel/Views/frontend/layouts/search/fields/location.blade.php ENDPATH**/ ?>