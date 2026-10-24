<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="infra" data-group="landing">
			<?php $lp = $all['infra'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[infra][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[infra][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="muted"><?php esc_html_e( 'Текст под заголовком (визуальный редактор)', 'tolstenko-theme' ); ?></div>
			<div class="row tolstenko-faq-editor-wrap"><?php tolstenko_field_template_editor( (string) ( $lp['text'] ?? '' ), 'tolstenko_field_template_infra_text', 'tolstenko_block_defaults[infra][text]' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[infra][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[infra][btn_url]" value="<?php echo esc_attr( $lp['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
			<div class="row">
				<div class="muted">Список услуг (выводится в две колонки)</div>
				<div data-repeater-list="infra-items-list">
					<?php foreach ( (array) ( $lp['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[infra][items][<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $it['text'] ?? '' ); ?>" placeholder="Пункт">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="infra-items-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		