<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="team" data-group="landing">
			<?php $team_defaults = $all['team'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[team][badge]" value="<?php echo esc_attr( $team_defaults['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[team][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $team_defaults['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[team][text]" rows="3" placeholder="Текст под заголовком"><?php echo esc_textarea( $team_defaults['text'] ?? '' ); ?></textarea></div>
			<p class="description"><?php esc_html_e( 'Карточки команды берутся из записей «Команда» (CPT teammate).', 'tolstenko-theme' ); ?></p>
		</div>

		