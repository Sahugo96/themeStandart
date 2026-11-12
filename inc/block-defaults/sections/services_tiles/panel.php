<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="services_tiles" data-group="post_sliders">
			<?php $st = $all['services_tiles'] ?? array(); ?>
			<p class="description"><?php esc_html_e( 'Блок «Плитка услуг» (страница с шаблоном «Archive service» и рубрики услуг): все услуги карточками по 3 в ряд, как в «Слайдере услуг». Название, текст, стоимость и ссылка «Консультация» карточки — в метабоксе «Карточка услуги» каждой услуги, метка — основная рубрика.', 'tolstenko-theme' ); ?></p>

			<div class="muted"><?php esc_html_e( '1. Надзаголовок', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[services_tiles][subtitle]" value="<?php echo esc_attr( $st['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Услуги"></div>

			<div class="muted"><?php esc_html_e( '2. Заголовок (HTML, акцентная часть — в <span>)', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[services_tiles][title]" rows="2" style="width:100%" placeholder="Собираем решение <span>под вашу задачу</span>"><?php echo esc_textarea( $st['title'] ?? '' ); ?></textarea></div>

			<div class="muted"><?php esc_html_e( '3. Текст под заголовком', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[services_tiles][text]" rows="3" style="width:100%"><?php echo esc_textarea( $st['text'] ?? '' ); ?></textarea></div>

			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[services_tiles][show_filter]" value="1" <?php checked( ! empty( $st['show_filter'] ) ); ?>>
					<?php esc_html_e( 'Табы рубрик над плиткой (ссылки на страницы рубрик услуг)', 'tolstenko-theme' ); ?>
				</label>
			</div>

			<div class="muted"><?php esc_html_e( '4. Первый таб (все услуги)', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[services_tiles][all_label]" value="<?php echo esc_attr( $st['all_label'] ?? '' ); ?>" style="width:100%" placeholder="Все услуги"></div>

			<div class="muted"><?php esc_html_e( '5. Сколько карточек видно сразу (остальные — по кнопке; 0 — все сразу)', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="number" min="0" max="60" name="tolstenko_block_defaults[services_tiles][visible_count]" value="<?php echo esc_attr( (string) ( $st['visible_count'] ?? 6 ) ); ?>" style="width:120px"></div>

			<div class="muted"><?php esc_html_e( '6. Кнопка «Показать ещё»', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[services_tiles][more_text]" value="<?php echo esc_attr( $st['more_text'] ?? '' ); ?>" style="width:100%" placeholder="Показать ещё"></div>

			<div class="muted"><?php esc_html_e( '7. Подписи в карточке: кнопки и приставка к цене', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[services_tiles][card_more]" value="<?php echo esc_attr( $st['card_more'] ?? '' ); ?>" style="width:100%" placeholder="Подробнее"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[services_tiles][card_consult]" value="<?php echo esc_attr( $st['card_consult'] ?? '' ); ?>" style="width:100%" placeholder="Консультация"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[services_tiles][card_price]" value="<?php echo esc_attr( $st['card_price'] ?? '' ); ?>" style="width:120px" placeholder="от"></div>
		</div>
