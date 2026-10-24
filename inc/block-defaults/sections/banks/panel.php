<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="banks" data-group="landing">
			<?php $bnk = $all['banks'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[banks][badge]" value="<?php echo esc_attr( $bnk['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[banks][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $bnk['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[banks][lead]" rows="3" placeholder="Текст под заголовком (HTML)"><?php echo esc_textarea( $bnk['lead'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Банки', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="banks-items-list">
				<?php foreach ( (array) ( $bnk['items'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it = is_array( $it ) ? $it : array();
					$logo_id = (int) ( $it['logo'] ?? 0 );
					$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заголовок карточки">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][logo]" value="<?php echo (int) $logo_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Логотип', 'tolstenko-theme' ); ?></button>
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $logo_url ) : ?><img src="<?php echo esc_url( $logo_url ); ?>" alt=""><?php endif; ?></div>
						<div class="row"><input type="text" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][type_text]" value="<?php echo esc_attr( $it['type_text'] ?? '' ); ?>" style="width:100%" placeholder="Тип счёта"></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][fact_1_label]" value="<?php echo esc_attr( $it['fact_1_label'] ?? '' ); ?>" placeholder="Факт 1 — подпись">
							<input type="text" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][fact_1_value]" value="<?php echo esc_attr( $it['fact_1_value'] ?? '' ); ?>" placeholder="Факт 1 — значение">
						</div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][fact_2_label]" value="<?php echo esc_attr( $it['fact_2_label'] ?? '' ); ?>" placeholder="Факт 2 — подпись">
							<input type="text" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][fact_2_value]" value="<?php echo esc_attr( $it['fact_2_value'] ?? '' ); ?>" placeholder="Факт 2 — значение">
						</div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][link_text]" value="<?php echo esc_attr( $it['link_text'] ?? '' ); ?>" placeholder="Кнопка">
							<input type="text" name="tolstenko_block_defaults[banks][items][<?php echo (int) $idx; ?>][link_url]" value="<?php echo esc_attr( $it['link_url'] ?? '' ); ?>" placeholder="Ссылка кнопки">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="banks-items-list"><?php esc_html_e( 'Добавить банк', 'tolstenko-theme' ); ?></button></div>
		</div>

