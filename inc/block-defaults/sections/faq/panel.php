<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
		$faq = $all['faq'] ?? array();
?>
<div class="tolstenko-df-panel" data-panel="faq" data-group="landing">
			<div class="row"><input type="text" name="tolstenko_block_defaults[faq][badge]" value="<?php echo esc_attr( $faq['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[faq][title]" value="<?php echo esc_attr( $faq['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок"></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Вопросы и ответы', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="faq-list">
					<?php foreach ( (array) ( $faq['items'] ?? array() ) as $idx => $it ) : ?>
						<?php $it = is_array( $it ) ? $it : array( 'quest' => '', 'unswer' => '' ); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[faq][items][<?php echo (int) $idx; ?>][quest]" value="<?php echo esc_attr( $it['quest'] ?? '' ); ?>" placeholder="Вопрос" style="width:100%">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row tolstenko-faq-editor-wrap">
								<p class="description" style="margin:0 0 6px;"><?php esc_html_e( 'Ответ', 'tolstenko-theme' ); ?></p>
								<?php tolstenko_faq_answer_editor( (string) ( $it['unswer'] ?? '' ), (int) $idx ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="faq-list"><?php esc_html_e( 'Добавить вопрос', 'tolstenko-theme' ); ?></button></div>
			</div>
			<hr>
			<div class="muted"><?php esc_html_e( 'Форма справа', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[faq][form_title]" value="<?php echo esc_attr( $faq['form_title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок формы"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[faq][form_text]" value="<?php echo esc_attr( $faq['form_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст формы"></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Контактная карточка — член команды', 'tolstenko-theme' ); ?></div>
				<?php
				$faq_teammates = get_posts( array(
					'post_type'      => 'teammate',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'orderby'        => 'title',
					'order'          => 'ASC',
				) );
				$faq_teammate_id = isset( $faq['teammate_id'] ) ? (int) $faq['teammate_id'] : 0;
				?>
				<select name="tolstenko_block_defaults[faq][teammate_id]" style="min-width:320px;max-width:100%">
					<option value="0"><?php esc_html_e( '— Не выбрано —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $faq_teammates as $faq_teammate ) : ?>
						<option value="<?php echo (int) $faq_teammate->ID; ?>" <?php selected( $faq_teammate_id, (int) $faq_teammate->ID ); ?>><?php echo esc_html( get_the_title( $faq_teammate ) ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php if ( empty( $faq_teammates ) ) : ?>
					<p class="description"><?php esc_html_e( 'Сначала добавьте записи в разделе «Команда».', 'tolstenko-theme' ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		