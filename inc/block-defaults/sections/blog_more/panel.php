<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="blog_more" data-group="landing">
			<?php $bm = $all['blog_more'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_more][text]" value="<?php echo esc_attr( $bm['text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_more][url]" value="<?php echo esc_attr( $bm['url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка"></div>
		</div>

