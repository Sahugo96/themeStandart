<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tolstenko-df-panel" data-panel="quiz" data-group="landing">
			<?php $qz = $all['quiz'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[quiz][badge]" value="<?php echo esc_attr( $qz['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[quiz][title]" value="<?php echo esc_attr( $qz['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[quiz][text]" rows="3" style="width:100%" placeholder="Текст (HTML)"><?php echo esc_textarea( $qz['text'] ?? '' ); ?></textarea></div>

			<div class="muted"><?php esc_html_e( 'Цифры под текстом', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="quiz-stats-list">
				<?php foreach ( (array) ( $qz['stats'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[quiz][stats][<?php echo (int) $idx; ?>][value]" value="<?php echo esc_attr( $it['value'] ?? '' ); ?>" placeholder="Значение (1 мин)">
							<input type="text" name="tolstenko_block_defaults[quiz][stats][<?php echo (int) $idx; ?>][label]" value="<?php echo esc_attr( $it['label'] ?? '' ); ?>" placeholder="Подпись (на прохождение)" style="flex:1">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="quiz-stats-list"><?php esc_html_e( 'Добавить цифру', 'tolstenko-theme' ); ?></button></div>

			<div class="muted"><?php esc_html_e( 'Шаги квиза (номер добавляется автоматически)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="quiz-steps-list">
				<?php foreach ( (array) ( $qz['steps'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it          = is_array( $it ) ? $it : array();
					$step_prefix = 'tolstenko_block_defaults[quiz][steps][' . (int) $idx . ']';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="<?php echo esc_attr( $step_prefix ); ?>[question]" value="<?php echo esc_attr( $it['question'] ?? '' ); ?>" placeholder="Вопрос" style="flex:1">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="muted"><?php esc_html_e( 'Варианты ответа', 'tolstenko-theme' ); ?></div>
						<div data-repeater-list="quiz-options-list" data-name-prefix="<?php echo esc_attr( $step_prefix ); ?>[options]">
							<?php foreach ( (array) ( $it['options'] ?? array() ) as $o_idx => $option ) : ?>
								<div class="repeater-item" data-repeater-item>
									<div class="cols">
										<input type="text" name="<?php echo esc_attr( $step_prefix ); ?>[options][<?php echo (int) $o_idx; ?>][text]" value="<?php echo esc_attr( is_array( $option ) ? ( $option['text'] ?? '' ) : '' ); ?>" placeholder="Вариант ответа" style="flex:1">
										<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
										<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
										<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="actions"><button type="button" class="button" data-add-item="quiz-options-list"><?php esc_html_e( 'Добавить вариант', 'tolstenko-theme' ); ?></button></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="quiz-steps-list"><?php esc_html_e( 'Добавить шаг', 'tolstenko-theme' ); ?></button></div>

			<div class="muted"><?php esc_html_e( 'Финальный экран (общий для всех)', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[quiz][final_thanks]" value="<?php echo esc_attr( $qz['final_thanks'] ?? '' ); ?>" style="width:100%" placeholder="Благодарность (Спасибо! Мы получили ваши ответы)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[quiz][final_title]" value="<?php echo esc_attr( $qz['final_title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[quiz][final_text]" rows="2" style="width:100%" placeholder="Текст"><?php echo esc_textarea( $qz['final_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[quiz][form_shortcode]" value="<?php echo esc_attr( $qz['form_shortcode'] ?? '' ); ?>" style="width:100%" placeholder='Шорткод формы CF7 с полем телефона, например [contact-form-7 id="a80aad5" title="Телефон"]'></div>
			<p class="description"><?php esc_html_e( 'Ответы квиза добавляются в письмо формы автоматически.', 'tolstenko-theme' ); ?></p>
			<div class="row"><input type="text" name="tolstenko_block_defaults[quiz][btn_text]" value="<?php echo esc_attr( $qz['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки формы (пусто = как в форме CF7)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[quiz][final_note]" rows="2" style="width:100%" placeholder="Подпись под кнопкой"><?php echo esc_textarea( $qz['final_note'] ?? '' ); ?></textarea></div>
		</div>

		
