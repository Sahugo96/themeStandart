<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="flagship" data-group="landing">
			<?php $flg = $all['flagship'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[flagship][badge]" value="<?php echo esc_attr( $flg['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[flagship][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $flg['title'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Карточки программ', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="flagship-cards-list">
				<?php foreach ( (array) ( $flg['cards'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it = is_array( $it ) ? $it : array();
					$flag_id = (int) ( $it['flag'] ?? 0 );
					$flag_url = $flag_id ? wp_get_attachment_image_url( $flag_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][country]" value="<?php echo esc_attr( $it['country'] ?? '' ); ?>" placeholder="Страна">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][flag]" value="<?php echo (int) $flag_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Флаг', 'tolstenko-theme' ); ?></button>
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $flag_url ) : ?><img src="<?php echo esc_url( $flag_url ); ?>" alt=""><?php endif; ?></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][price]" value="<?php echo esc_attr( $it['price'] ?? '' ); ?>" placeholder="Цена (HTML)">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название программы">
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][text]" rows="3" placeholder="Описание (HTML)"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
						<div class="row"><textarea name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][facts]" rows="3" placeholder="Факты (по одному в строке: «Подпись: значение»)"><?php echo esc_textarea( $it['facts'] ?? '' ); ?></textarea></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][btn_text]" value="<?php echo esc_attr( $it['btn_text'] ?? '' ); ?>" placeholder="Кнопка">
							<input type="text" name="tolstenko_block_defaults[flagship][cards][<?php echo (int) $idx; ?>][btn_url]" value="<?php echo esc_attr( $it['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="flagship-cards-list"><?php esc_html_e( 'Добавить программу', 'tolstenko-theme' ); ?></button></div>

			<div class="muted"><?php esc_html_e( 'Кнопки-ссылки в карточках (иконка + ссылка, как в карточке «Команды»). Пусто = WhatsApp и Telegram из «Контактных данных».', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="flagship-links-list">
				<?php foreach ( (array) ( $flg['links'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it = is_array( $it ) ? $it : array();
					$link_icon_id  = (int) ( $it['icon'] ?? 0 );
					$link_icon_url = $link_icon_id ? wp_get_attachment_image_url( $link_icon_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[flagship][links][<?php echo (int) $idx; ?>][icon]" value="<?php echo (int) $link_icon_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Иконка', 'tolstenko-theme' ); ?></button>
							<input type="text" name="tolstenko_block_defaults[flagship][links][<?php echo (int) $idx; ?>][url]" value="<?php echo esc_attr( $it['url'] ?? '' ); ?>" placeholder="Ссылка (https://wa.me/…, https://t.me/…)" style="flex:1">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $link_icon_url ) : ?><img src="<?php echo esc_url( $link_icon_url ); ?>" alt=""><?php endif; ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="flagship-links-list"><?php esc_html_e( 'Добавить ссылку', 'tolstenko-theme' ); ?></button></div>

			<div class="muted"><?php esc_html_e( 'Таблица «Другие программы»', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[flagship][table_title]" value="<?php echo esc_attr( $flg['table_title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок таблицы (HTML, акцент — <span>)"></div>
			<div class="cols">
				<input type="text" name="tolstenko_block_defaults[flagship][col_country]" value="<?php echo esc_attr( $flg['col_country'] ?? '' ); ?>" placeholder="Колонка: Страна">
				<input type="text" name="tolstenko_block_defaults[flagship][col_price]" value="<?php echo esc_attr( $flg['col_price'] ?? '' ); ?>" placeholder="Колонка: Стоимость">
				<input type="text" name="tolstenko_block_defaults[flagship][col_term]" value="<?php echo esc_attr( $flg['col_term'] ?? '' ); ?>" placeholder="Колонка: Срок оформления">
				<input type="text" name="tolstenko_block_defaults[flagship][col_benefits]" value="<?php echo esc_attr( $flg['col_benefits'] ?? '' ); ?>" placeholder="Колонка: Преимущества">
			</div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[flagship][row_btn_text]" value="<?php echo esc_attr( $flg['row_btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки в строках (Проконсультироваться)"></div>
			<div data-repeater-list="flagship-rows-list">
				<?php foreach ( (array) ( $flg['rows'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it          = is_array( $it ) ? $it : array();
					$row_prefix  = 'tolstenko_block_defaults[flagship][rows][' . (int) $idx . ']';
					$row_flag_id = (int) ( $it['flag'] ?? 0 );
					$row_flag    = $row_flag_id ? wp_get_attachment_image_url( $row_flag_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[name]" value="<?php echo esc_attr( $it['name'] ?? '' ); ?>" placeholder="Название (подпись — в &lt;span&gt;)" style="flex:1">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="<?php echo esc_attr( $row_prefix ); ?>[flag]" value="<?php echo (int) $row_flag_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Флаг', 'tolstenko-theme' ); ?></button>
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $row_flag ) : ?><img src="<?php echo esc_url( $row_flag ); ?>" alt=""><?php endif; ?></div>
						<div class="cols">
							<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[price]" value="<?php echo esc_attr( $it['price'] ?? '' ); ?>" placeholder="Стоимость">
							<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[term]" value="<?php echo esc_attr( $it['term'] ?? '' ); ?>" placeholder="Срок оформления">
							<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[link]" value="<?php echo esc_attr( $it['link'] ?? '' ); ?>" placeholder="Ссылка кнопки (пусто = #modal)">
						</div>
						<div class="muted"><?php esc_html_e( 'Преимущества', 'tolstenko-theme' ); ?></div>
						<div data-repeater-list="flagship-benefits-list" data-name-prefix="<?php echo esc_attr( $row_prefix ); ?>[benefits]">
							<?php foreach ( (array) ( $it['benefits'] ?? array() ) as $b_idx => $benefit ) : ?>
								<div class="repeater-item" data-repeater-item>
									<div class="cols">
										<input type="text" name="<?php echo esc_attr( $row_prefix ); ?>[benefits][<?php echo (int) $b_idx; ?>][text]" value="<?php echo esc_attr( is_array( $benefit ) ? ( $benefit['text'] ?? '' ) : '' ); ?>" placeholder="Преимущество" style="flex:1">
										<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
										<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
										<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="actions"><button type="button" class="button" data-add-item="flagship-benefits-list"><?php esc_html_e( 'Добавить преимущество', 'tolstenko-theme' ); ?></button></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="flagship-rows-list"><?php esc_html_e( 'Добавить страну', 'tolstenko-theme' ); ?></button></div>

			<div class="muted"><?php esc_html_e( 'Под таблицей', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[flagship][foot_text]" rows="2" style="width:100%" placeholder="Текст под таблицей (HTML)"><?php echo esc_textarea( $flg['foot_text'] ?? '' ); ?></textarea></div>
			<div class="cols">
				<input type="text" name="tolstenko_block_defaults[flagship][btn_text]" value="<?php echo esc_attr( $flg['btn_text'] ?? '' ); ?>" placeholder="Кнопка под таблицей">
				<input type="text" name="tolstenko_block_defaults[flagship][btn_url]" value="<?php echo esc_attr( $flg['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки (пусто = #modal)">
			</div>
		</div>