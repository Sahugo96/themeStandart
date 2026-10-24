<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="service_section_filters" data-group="post_sliders">
			<?php
			$filters_data = $all['service_section_filters'] ?? array();
			if ( ! array_key_exists( 'service_section_filters', $saved ) && ! empty( $all['service_section'] ) && is_array( $all['service_section'] ) ) {
				$filters_data = array_replace_recursive( $filters_data, $all['service_section'] );
			}
			tolstenko_render_service_section_defaults_fields( 'service_section_filters', $filters_data );
			?>
		</div>

		