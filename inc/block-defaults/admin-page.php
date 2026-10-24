<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'tolstenko_register_block_defaults_admin_page' );
add_action( 'admin_enqueue_scripts', 'tolstenko_block_defaults_admin_assets' );

function tolstenko_register_block_defaults_admin_page() {
	add_menu_page(
		__( 'Настройки сайта', 'tolstenko-theme' ),
		__( 'Настройки сайта', 'tolstenko-theme' ),
		'manage_options',
		'tolstenko-site-settings',
		'tolstenko_render_block_defaults_admin_page',
		'dashicons-admin-generic',
		58
	);
	add_submenu_page(
		'tolstenko-site-settings',
		__( 'Дефолты блоков', 'tolstenko-theme' ),
		__( 'Дефолты блоков', 'tolstenko-theme' ),
		'manage_options',
		'tolstenko-site-settings',
		'tolstenko_render_block_defaults_admin_page'
	);
}

function tolstenko_block_defaults_admin_assets( $hook ) {
	if ( $hook !== 'toplevel_page_tolstenko-site-settings' ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_editor();
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'wp-components' );
}

/**
 * Визуальный редактор ответа FAQ в дефолтах блоков.
 */
function tolstenko_faq_answer_editor( $content, $idx ) {
	$idx       = (int) $idx;
	$editor_id = 'tolstenko_faq_redactor_' . $idx;
	wp_editor(
		(string) $content,
		$editor_id,
		array(
			'textarea_name' => 'tolstenko_block_defaults[faq][items][' . $idx . '][unswer]',
			'textarea_rows' => 8,
			'media_buttons' => true,
			'teeny'         => false,
			'quicktags'     => true,
			'editor_height' => 180,
		)
	);
}

/**
 * Универсальный визуальный редактор (rich text) для шаблона полей в дефолтах блоков.
 *
 * @param string $content       HTML-содержимое редактора.
 * @param string $editor_id     Уникальный id редактора (tinymce/quicktags).
 * @param string $textarea_name Значение атрибута name у textarea.
 */
function tolstenko_field_template_editor( $content, $editor_id, $textarea_name ) {
	wp_editor(
		(string) $content,
		(string) $editor_id,
		array(
			'textarea_name' => $textarea_name,
			'textarea_rows' => 8,
			'media_buttons' => true,
			'teeny'         => false,
			'quicktags'     => true,
			'editor_height' => 180,
		)
	);
}

function tolstenko_render_block_defaults_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['tolstenko_block_defaults_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tolstenko_block_defaults_nonce'] ) ), 'tolstenko_block_defaults_save' ) ) {
		tolstenko_save_block_defaults_from_request();
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Дефолты блоков сохранены.', 'tolstenko-theme' ) . '</p></div>';
	}

	$all = tolstenko_block_defaults_schema();
	$saved = get_option( 'tolstenko_block_defaults', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	foreach ( $saved as $block_key => $block_saved ) {
		if ( ! is_array( $block_saved ) ) {
			continue;
		}
		$base_block = isset( $all[ $block_key ] ) && is_array( $all[ $block_key ] ) ? $all[ $block_key ] : array();
		$all[ $block_key ] = tolstenko_merge_block_defaults_data( $base_block, $block_saved );
	}
	if ( empty( $all['documents']['items'] ) || ! is_array( $all['documents']['items'] ) ) {
		$all['documents']['items'] = array();
	}
	?>
	<div class="wrap">
	<h1><?php esc_html_e( 'Настройки сайта: дефолты блоков', 'tolstenko-theme' ); ?></h1>
	<form method="post" action="">
	<?php wp_nonce_field( 'tolstenko_block_defaults_save', 'tolstenko_block_defaults_nonce' ); ?>
	<p class="description"><?php esc_html_e( 'Редактируйте дефолтные значения блоков. Они используются, когда у конкретной страницы/блока нет своих значений.', 'tolstenko-theme' ); ?></p>
	<link rel="stylesheet" href="<?php echo esc_url( tolstenko_block_defaults_asset_url( 'assets/css/admin/block-defaults.css' ) ); ?>">
	<?php tolstenko_post_select_print_assets(); ?>
	<div class="tolstenko-df">
		<div class="tolstenko-df-tabs-group is-active" data-group="main">
			<div class="tolstenko-df-tabs-group-title"><?php esc_html_e( 'Основные блоки', 'tolstenko-theme' ); ?></div>
			<div class="tolstenko-df-tabs">
				<button type="button" class="tolstenko-df-tab active" data-panel="field_template" data-group="main"><?php esc_html_e( 'Шаблон всех полей', 'tolstenko-theme' ); ?></button>
			</div>
			<div class="tolstenko-df-group-panels" data-group-panels="main"></div>
		</div>
		<div class="tolstenko-df-tabs-group" data-group="post_sliders">
			<div class="tolstenko-df-tabs-group-title"><?php esc_html_e( 'Слайдера записей', 'tolstenko-theme' ); ?></div>
			<div class="tolstenko-df-tabs">
				<button type="button" class="tolstenko-df-tab" data-panel="case_section" data-group="post_sliders"><?php esc_html_e( 'Кейсы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="reviews" data-group="post_sliders"><?php esc_html_e( 'Отзывы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="service_section" data-group="post_sliders"><?php esc_html_e( 'Слайдер услуг', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="service_section_filters" data-group="post_sliders"><?php esc_html_e( 'Слайдер услуг (фильтры)', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="blog_section" data-group="post_sliders"><?php esc_html_e( 'Слайдер статей', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="blog_section_filters" data-group="post_sliders"><?php esc_html_e( 'Статьи', 'tolstenko-theme' ); ?></button>
			</div>
			<div class="tolstenko-df-group-panels" data-group-panels="post_sliders"></div>
		</div>

		<div class="tolstenko-df-tabs-group" data-group="landing">
			<div class="tolstenko-df-tabs-group-title"><?php esc_html_e( 'Секции лендинга', 'tolstenko-theme' ); ?></div>
			<div class="tolstenko-df-tabs">
				<button type="button" class="tolstenko-df-tab" data-panel="main_hero" data-group="landing"><?php esc_html_e( 'Главный баннер', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="result" data-group="landing"><?php esc_html_e( 'Результат', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="compare" data-group="landing"><?php esc_html_e( 'Сравнение', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="why_us" data-group="landing"><?php esc_html_e( 'Почему именно мы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="infra" data-group="landing"><?php esc_html_e( 'Для клиентов с капиталом и бизнесом', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="about" data-group="landing"><?php esc_html_e( 'Кратко о нас', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="guide" data-group="landing"><?php esc_html_e( 'Подробнее', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="consult" data-group="landing"><?php esc_html_e( 'Начните с бесплатной консультации', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="documents" data-group="landing"><?php esc_html_e( 'Документы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="team" data-group="landing"><?php esc_html_e( 'Команда', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="faq" data-group="landing"><?php esc_html_e( 'FAQ', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="hero_stats" data-group="landing"><?php esc_html_e( 'Цифры под hero', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="situations" data-group="landing"><?php esc_html_e( 'Ситуации', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="process" data-group="landing"><?php esc_html_e( 'Как проходит работа', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="cost" data-group="landing"><?php esc_html_e( 'Стоимость', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="blog_more" data-group="landing"><?php esc_html_e( 'Кнопка в блог', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="cases" data-group="landing"><?php esc_html_e( 'Кейсы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="programs" data-group="landing"><?php esc_html_e( 'Сравнение программ', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="banks" data-group="landing"><?php esc_html_e( 'Банки-партнёры', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="flagship" data-group="landing"><?php esc_html_e( 'Флагманские программы', 'tolstenko-theme' ); ?></button>
				<button type="button" class="tolstenko-df-tab" data-panel="europe" data-group="landing"><?php esc_html_e( 'ВНЖ в Европе', 'tolstenko-theme' ); ?></button>
			</div>
			<div class="tolstenko-df-group-panels" data-group-panels="landing"></div>
		</div>

		<div class="tolstenko-df-panels-source">

		<div class="tolstenko-df-panel" data-panel="reviews" data-group="post_sliders">
			<?php
			$rv      = $all['reviews'] ?? array();
			$rv_ids  = isset( $rv['ids'] ) && is_array( $rv['ids'] ) ? array_map( 'intval', $rv['ids'] ) : array();
			$rv_cards = isset( $rv['cards'] ) && is_array( $rv['cards'] ) ? $rv['cards'] : array();
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[reviews][subtitle]" value="<?php echo esc_attr( $rv['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[reviews][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $rv['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[reviews][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $rv['text'] ?? '' ); ?></textarea></div>
			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[reviews][show_items]" value="1" <?php checked( ! empty( $rv['show_items'] ) ); ?>>
					<?php esc_html_e( 'Показывать блок рейтингов (reviews__items)', 'tolstenko-theme' ); ?>
				</label>
			</div>
			<div class="row">
				<?php tolstenko_render_post_select( 
					'tolstenko_block_defaults[reviews][ids]',
					$rv_ids,
					'review',
					'Отзывы (пусто = все)'
				); ?>
			</div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Карточки рейтингов (reviews__items)', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="reviews-cards-list">
					<?php foreach ( $rv_cards as $idx => $card ) : ?>
						<?php
						$card    = is_array( $card ) ? $card : array();
						$c_title = (string) ( $card['title'] ?? '' );
						$c_url   = (string) ( $card['url'] ?? '' );
						$c_rating = isset( $card['rating'] ) ? (int) $card['rating'] : 5;
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $c_title ); ?>" placeholder="Название (Яндекс, 2ГИС…)" style="flex:1">
								<input type="url" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][url]" value="<?php echo esc_attr( $c_url ); ?>" placeholder="Ссылка" style="flex:1">
								<input type="number" min="1" max="5" name="tolstenko_block_defaults[reviews][cards][<?php echo (int) $idx; ?>][rating]" value="<?php echo (int) $c_rating; ?>" style="width:80px" title="Рейтинг">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<button type="button" class="button" data-add-item="reviews-cards-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="documents" data-group="landing">
			<div class="row"><input type="text" name="tolstenko_block_defaults[documents][subtitle]" value="<?php echo esc_attr( $all['documents']['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[documents][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $all['documents']['title'] ?? '' ); ?></textarea></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Документы (картинка + заглавие + описание + атрибуты)', 'tolstenko-theme' ); ?></div>
				<div data-repeater-list="documents-list">
					<?php foreach ( (array) ( $all['documents']['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						$img_id = isset( $it['image'] ) ? (int) $it['image'] : 0;
						$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заглавие">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][image]" value="<?php echo (int) $img_id; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Описание"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
							<div class="row"><textarea name="tolstenko_block_defaults[documents][items][<?php echo (int) $idx; ?>][attributes]" rows="2" placeholder="Атрибуты (по одному в строке)"><?php echo esc_textarea( $it['attributes'] ?? '' ); ?></textarea></div>
							<div class="icon-preview cert-preview" style="margin-top:8px;"><?php if ( $img_url ) : ?><img src="<?php echo esc_url( $img_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="documents-list"><?php esc_html_e( 'Добавить документ', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="team" data-group="landing">
			<?php $team_defaults = $all['team'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[team][badge]" value="<?php echo esc_attr( $team_defaults['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[team][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $team_defaults['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[team][text]" rows="3" placeholder="Текст под заголовком"><?php echo esc_textarea( $team_defaults['text'] ?? '' ); ?></textarea></div>
			<p class="description"><?php esc_html_e( 'Карточки команды берутся из записей «Команда» (CPT teammate).', 'tolstenko-theme' ); ?></p>
		</div>

		<div class="tolstenko-df-panel" data-panel="case_section" data-group="post_sliders">
			<?php
			$cs = $all['case_section'] ?? array();
			$cs_ids = isset( $cs['ids'] ) && is_array( $cs['ids'] ) ? array_map( 'intval', $cs['ids'] ) : array();
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[case_section][subtitle]" value="<?php echo esc_attr( $cs['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[case_section][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML)"><?php echo esc_textarea( $cs['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[case_section][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $cs['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="number" min="-1" name="tolstenko_block_defaults[case_section][posts_per_page]" value="<?php echo esc_attr( (string) ( $cs['posts_per_page'] ?? 4 ) ); ?>" style="width:100%" placeholder="Количество кейсов (4, -1 = все)"></div>
			<div class="row">
				<?php tolstenko_render_post_select( 
					'tolstenko_block_defaults[case_section][ids]',
					$cs_ids,
					'case',
					'Кейсы (пусто = все)'
				); ?>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="service_section" data-group="post_sliders">
			<?php tolstenko_render_service_section_defaults_fields( 'service_section', $all['service_section'] ?? array() ); ?>
		</div>

		<div class="tolstenko-df-panel" data-panel="service_section_filters" data-group="post_sliders">
			<?php
			$filters_data = $all['service_section_filters'] ?? array();
			if ( ! array_key_exists( 'service_section_filters', $saved ) && ! empty( $all['service_section'] ) && is_array( $all['service_section'] ) ) {
				$filters_data = array_replace_recursive( $filters_data, $all['service_section'] );
			}
			tolstenko_render_service_section_defaults_fields( 'service_section_filters', $filters_data );
			?>
		</div>

		<div class="tolstenko-df-panel" data-panel="blog_section" data-group="post_sliders">
			<?php tolstenko_render_blog_section_defaults_fields( 'blog_section', $all['blog_section'] ?? array() ); ?>
		</div>

		<div class="tolstenko-df-panel" data-panel="blog_section_filters" data-group="post_sliders">
			<?php
			$bsf = $all['blog_section_filters'] ?? array();
			tolstenko_render_blog_section_defaults_fields( 'blog_section_filters', $bsf );
			?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_section_filters][btn_text]" value="<?php echo esc_attr( $bsf['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки под списком (Все статьи)"></div>
			<p class="description"><?php esc_html_e( 'Слайдер с фильтром по рубрикам blog_cat. Кнопка всегда ведёт на страницу блога.', 'tolstenko-theme' ); ?></p>
		</div>


		<?php
		$faq = $all['faq'] ?? array();
		$ftpl = $all['field_template'] ?? array();
		$ftpl_img_id = isset( $ftpl['image'] ) ? (int) $ftpl['image'] : 0;
		$ftpl_img_url = $ftpl_img_id ? wp_get_attachment_image_url( $ftpl_img_id, 'medium' ) : '';
		$ftpl_post_ids = isset( $ftpl['post_ids'] ) && is_array( $ftpl['post_ids'] ) ? array_map( 'intval', $ftpl['post_ids'] ) : array();
		$ftpl_single_post_id = isset( $ftpl['single_post_id'] ) ? (int) $ftpl['single_post_id'] : 0;
		$ftpl_action_posts = get_posts(
			array(
				'post_type'      => 'actions',
				'posts_per_page' => 100,
				'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);
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

		<div class="tolstenko-df-panel" data-panel="field_template">
			<p class="description"><?php esc_html_e( 'Эталонная панель со всеми типами полей: чекбокс, текстовое поле, текстовая область, визуальный редактор, изображение, повторитель, множественный выбор записей и выбор одной записи. Ключ панели (field_template) совпадает с ключом блока my-theme/field-template.', 'tolstenko-theme' ); ?></p>
			<div class="muted"><?php esc_html_e( '0. Чекбокс', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<label>
					<input type="checkbox" name="tolstenko_block_defaults[field_template][enabled]" value="1" <?php checked( ! empty( $ftpl['enabled'] ) ); ?>>
					<?php esc_html_e( 'Включить / показывать блок', 'tolstenko-theme' ); ?>
				</label>
			</div>
			<div class="muted"><?php esc_html_e( '1. Текстовое поле', 'tolstenko-theme' ); ?></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[field_template][text_field]" value="<?php echo esc_attr( $ftpl['text_field'] ?? '' ); ?>" style="width:100%" placeholder="Однострочное текстовое поле"></div>
			<div class="muted"><?php esc_html_e( '2. Текстовая область', 'tolstenko-theme' ); ?></div>
			<div class="row"><textarea name="tolstenko_block_defaults[field_template][textarea_field]" rows="3" style="width:100%" placeholder="Многострочная текстовая область"><?php echo esc_textarea( $ftpl['textarea_field'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( '3. Редактор (rich text)', 'tolstenko-theme' ); ?></div>
			<div class="row tolstenko-faq-editor-wrap"><?php tolstenko_field_template_editor( (string) ( $ftpl['editor_field'] ?? '' ), 'tolstenko_field_template_editor_0', 'tolstenko_block_defaults[field_template][editor_field]' ); ?></div>
			<div class="muted"><?php esc_html_e( '4. Изображение', 'tolstenko-theme' ); ?></div>
			<div class="row tolstenko-defaults-image-row">
				<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[field_template][image]" value="<?php echo (int) $ftpl_img_id; ?>">
				<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
				<div class="icon-preview field-template-preview"><?php if ( $ftpl_img_url ) : ?><img src="<?php echo esc_url( $ftpl_img_url ); ?>" alt=""><?php endif; ?></div>
			</div>
			<div class="muted"><?php esc_html_e( '5. Повторитель', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<div data-repeater-list="field-template-list">
					<?php foreach ( (array) ( $ftpl['items'] ?? array() ) as $idx => $it ) : ?>
						<?php $it = is_array( $it ) ? $it : array( 'title' => '', 'text' => '' ); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[field_template][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Текстовое поле (заголовок)" style="flex:1">
								<button type="button" class="button move-btn" data-move-up title="<?php esc_attr_e( 'Вверх', 'tolstenko-theme' ); ?>">&uarr;</button>
								<button type="button" class="button move-btn" data-move-down title="<?php esc_attr_e( 'Вниз', 'tolstenko-theme' ); ?>">&darr;</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[field_template][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="<?php esc_attr_e( 'Текстовая область', 'tolstenko-theme' ); ?>"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="field-template-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
			<div class="muted"><?php esc_html_e( '6. Множественный выбор записей', 'tolstenko-theme' ); ?></div>
			<div class="row">
				<?php tolstenko_render_post_select(
					'tolstenko_block_defaults[field_template][post_ids]',
					$ftpl_post_ids,
					'case',
					'Записи (пусто = все)'
				); ?>
			</div>
			<div class="muted"><?php esc_html_e( '7. Выбор одной записи', 'tolstenko-theme' ); ?></div>
			<div class="cols">
				<select name="tolstenko_block_defaults[field_template][single_post_id]" style="min-width:220px">
					<option value="0"><?php esc_html_e( '— Без ссылки —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $ftpl_action_posts as $ap ) : ?>
						<option value="<?php echo (int) $ap->ID; ?>" <?php selected( $ftpl_single_post_id, (int) $ap->ID ); ?>><?php echo esc_html( get_the_title( $ap ) ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			</div>
		</div>

		<?php $lp_blog_posts = tolstenko_get_posts_for_select( 'blog' ); ?>
		<?php $mh = $all['main_hero'] ?? array(); ?>
		<?php $mh_img_id = isset( $mh['image'] ) ? (int) $mh['image'] : 0; ?>
		<?php $mh_img_url = $mh_img_id ? wp_get_attachment_image_url( $mh_img_id, 'medium' ) : ''; ?>
		<?php $mh_present_id = isset( $mh['present_image'] ) ? (int) $mh['present_image'] : 0; ?>
		<?php $mh_present_url = $mh_present_id ? wp_get_attachment_image_url( $mh_present_id, 'medium' ) : ''; ?>

		<div class="tolstenko-df-panel" data-panel="main_hero" data-group="landing">
		<?php $mh = $all['main_hero'] ?? array(); ?>
		<?php $mh_img_id = (int) ( $mh['image'] ?? 0 ); $mh_img_url = $mh_img_id ? wp_get_attachment_image_url( $mh_img_id, 'medium' ) : ''; ?>
		<?php $mh_present_id = (int) ( $mh['present_image'] ?? 0 ); $mh_present_url = $mh_present_id ? wp_get_attachment_image_url( $mh_present_id, 'medium' ) : ''; ?>

		<div class="muted"><?php esc_html_e( '1. Тег заголовка', 'tolstenko-theme' ); ?></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[main_hero][title_tag]" value="<?php echo esc_attr( $mh['title_tag'] ?? 'h1' ); ?>" style="width:100%" placeholder="h1"></div>

		<div class="muted"><?php esc_html_e( '2. Заголовок (HTML)', 'tolstenko-theme' ); ?></div>
		<div class="row"><textarea name="tolstenko_block_defaults[main_hero][title]" rows="2" style="width:100%" placeholder="Заголовок баннера"><?php echo esc_textarea( $mh['title'] ?? '' ); ?></textarea></div>

		<div class="muted"><?php esc_html_e( '3. Текст (HTML)', 'tolstenko-theme' ); ?></div>
		<div class="row"><textarea name="tolstenko_block_defaults[main_hero][text]" rows="3" style="width:100%" placeholder="Текст баннера"><?php echo esc_textarea( $mh['text'] ?? '' ); ?></textarea></div>

		<div class="muted"><?php esc_html_e( '4. Пункты списка (HTML)', 'tolstenko-theme' ); ?></div>
		<div data-repeater-list="main-hero-list">
			<?php foreach ( (array) ( $mh['items'] ?? array() ) as $idx => $it ) : ?>
				<?php $it = is_array( $it ) ? $it : array(); ?>
				<div class="repeater-item" data-repeater-item>
					<div class="cols">
						<input type="text" name="tolstenko_block_defaults[main_hero][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Пункт списка" style="flex:1">
						<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
						<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
						<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
					</div>
					<div class="row"><textarea name="tolstenko_block_defaults[main_hero][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст пункта"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="actions"><button type="button" class="button" data-add-item="main-hero-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>

		<div class="muted"><?php esc_html_e( '5. Текст кнопки', 'tolstenko-theme' ); ?></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[main_hero][btn_text]" value="<?php echo esc_attr( $mh['btn_text'] ?? 'Оставить заявку' ); ?>" style="width:100%" placeholder="Оставить заявку"></div>

		<div class="muted"><?php esc_html_e( '6. Показывать промо у кнопки', 'tolstenko-theme' ); ?></div>
		<div class="row">
			<label>
				<input type="checkbox" name="tolstenko_block_defaults[main_hero][show_promo]" value="1" <?php checked( ! empty( $mh['show_promo'] ) ); ?>>
				<?php esc_html_e( 'Включить промо', 'tolstenko-theme' ); ?>
			</label>
		</div>

		<div class="muted"><?php esc_html_e( '7. Текст промо (HTML)', 'tolstenko-theme' ); ?></div>
		<div class="row"><textarea name="tolstenko_block_defaults[main_hero][promo_text]" rows="2" style="width:100%" placeholder="Текст промо"><?php echo esc_textarea( $mh['promo_text'] ?? '' ); ?></textarea></div>

		<div class="muted"><?php esc_html_e( '8. Иконка подарка (изображение)', 'tolstenko-theme' ); ?></div>
		<div class="row tolstenko-defaults-image-row">
			<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[main_hero][present_image]" value="<?php echo (int) $mh_present_id; ?>">
			<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
			<div class="icon-preview"><?php if ( $mh_present_url ) : ?><img src="<?php echo esc_url( $mh_present_url ); ?>" alt=""><?php endif; ?></div>
		</div>

		<div class="muted"><?php esc_html_e( '9. Имя персоны', 'tolstenko-theme' ); ?></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[main_hero][person_name]" value="<?php echo esc_attr( $mh['person_name'] ?? '' ); ?>" style="width:100%" placeholder="Имя"></div>

		<div class="muted"><?php esc_html_e( '10. Должность', 'tolstenko-theme' ); ?></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[main_hero][person_position]" value="<?php echo esc_attr( $mh['person_position'] ?? '' ); ?>" style="width:100%" placeholder="Должность"></div>

		<div class="muted"><?php esc_html_e( '11. Изображение баннера', 'tolstenko-theme' ); ?></div>
		<div class="row tolstenko-defaults-image-row">
			<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[main_hero][image]" value="<?php echo (int) $mh_img_id; ?>">
			<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
			<div class="icon-preview"><?php if ( $mh_img_url ) : ?><img src="<?php echo esc_url( $mh_img_url ); ?>" alt=""><?php endif; ?></div>
		</div>
		</div>

<div class="tolstenko-df-panel" data-panel="result" data-group="landing">
			<?php $lp = $all['result'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[result][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[result][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок"></div>
			<div class="row">
				<div class="muted">Карточки (иконка + название + текст)</div>
				<div data-repeater-list="result-items-list">
					<?php foreach ( (array) ( $lp['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						$it_img_id  = isset( $it['icon'] ) ? (int) $it['icon'] : 0;
						$it_img_url = $it_img_id ? wp_get_attachment_image_url( $it_img_id, 'thumbnail' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][icon]" value="<?php echo (int) $it_img_id; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать иконку', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[result][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
							<div class="icon-preview" style="margin-top:8px;"><?php if ( $it_img_url ) : ?><img src="<?php echo esc_url( $it_img_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="result-items-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="compare" data-group="landing">
			<?php $lp = $all['compare'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[compare][lead]" rows="3" style="width:100%" placeholder="Текст под заголовком (перенос строки = новая строка)"><?php echo esc_textarea( $lp['lead'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_criterion]" value="<?php echo esc_attr( $lp['th_criterion'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: критерий"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_self]" value="<?php echo esc_attr( $lp['th_self'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 1"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_mediator]" value="<?php echo esc_attr( $lp['th_mediator'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 2"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][th_us]" value="<?php echo esc_attr( $lp['th_us'] ?? '' ); ?>" style="width:100%" placeholder="Шапка таблицы: колонка 3 (золотая)"></div>
			<div class="row">
				<div class="muted">Строки таблицы</div>
				<div data-repeater-list="compare-rows-list">
					<?php foreach ( (array) ( $lp['rows'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][criterion]" value="<?php echo esc_attr( $it['criterion'] ?? '' ); ?>" placeholder="Критерий">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][self]" value="<?php echo esc_attr( $it['self'] ?? '' ); ?>" placeholder="Сам">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][mediator]" value="<?php echo esc_attr( $it['mediator'] ?? '' ); ?>" placeholder="Через посредника">
								<input type="text" name="tolstenko_block_defaults[compare][rows][<?php echo (int) $idx; ?>][us]" value="<?php echo esc_attr( $it['us'] ?? '' ); ?>" placeholder="Напрямую с нами">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="compare-rows-list"><?php esc_html_e( 'Добавить строку', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row"><textarea name="tolstenko_block_defaults[compare][foot_text]" rows="3" style="width:100%" placeholder="Текст под таблицей (перенос строки = новая строка)"><?php echo esc_textarea( $lp['foot_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[compare][btn_url]" value="<?php echo esc_attr( $lp['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
		</div>

		<div class="tolstenko-df-panel" data-panel="why_us" data-group="landing">
			<?php $lp = $all['why_us'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[why_us][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[why_us][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row">
				<div class="muted">Карточки (иконка + название + текст)</div>
				<div data-repeater-list="why_us-items-list">
					<?php foreach ( (array) ( $lp['items'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						$it_img_id  = isset( $it['icon'] ) ? (int) $it['icon'] : 0;
						$it_img_url = $it_img_id ? wp_get_attachment_image_url( $it_img_id, 'thumbnail' ) : '';
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[why_us][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название">
								<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[why_us][items][<?php echo (int) $idx; ?>][icon]" value="<?php echo (int) $it_img_id; ?>">
								<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать иконку', 'tolstenko-theme' ); ?></button>
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[why_us][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
							<div class="icon-preview" style="margin-top:8px;"><?php if ( $it_img_url ) : ?><img src="<?php echo esc_url( $it_img_url ); ?>" alt=""><?php endif; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="why_us-items-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

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

		<div class="tolstenko-df-panel" data-panel="about" data-group="landing">
			<?php $lp = $all['about'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[about][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[about][title]" value="<?php echo esc_attr( $lp['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="muted">Текст (визуальный редактор)</div>
			<div class="row tolstenko-faq-editor-wrap"><?php tolstenko_field_template_editor( (string) ( $lp['text'] ?? '' ), 'tolstenko_field_template_about_text', 'tolstenko_block_defaults[about][text]' ); ?></div>
			<div class="row">
				<div class="muted">Фото слева</div>
				<?php $lp_img_id = (int) ( $lp['image'] ?? 0 ); $lp_img_url = $lp_img_id ? wp_get_attachment_image_url( $lp_img_id, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[about][image]" value="<?php echo (int) $lp_img_id; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $lp_img_url ) : ?><img src="<?php echo esc_url( $lp_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
			<div class="row">
				<div class="muted">Цифры (число + подпись)</div>
				<div data-repeater-list="about-stats-list">
					<?php foreach ( (array) ( $lp['stats'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[about][stats][<?php echo (int) $idx; ?>][num]" value="<?php echo esc_attr( $it['num'] ?? '' ); ?>" placeholder="Число">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
							<div class="row"><textarea name="tolstenko_block_defaults[about][stats][<?php echo (int) $idx; ?>][label]" rows="2" placeholder="Подпись (перенос строки = новая строка)"><?php echo esc_textarea( $it['label'] ?? '' ); ?></textarea></div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="about-stats-list"><?php esc_html_e( 'Добавить цифру', 'tolstenko-theme' ); ?></button></div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="guide" data-group="landing">
			<?php $lp = $all['guide'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][subtitle]" value="<?php echo esc_attr( $lp['subtitle'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[guide][title]" rows="3" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $lp['title'] ?? '' ); ?></textarea></div>
			<div class="muted">Статья (запись блога)</div>
			<div class="row">
				<select name="tolstenko_block_defaults[guide][post_id]" style="min-width:320px;max-width:100%">
					<option value="0"><?php esc_html_e( '— Не выбрано —', 'tolstenko-theme' ); ?></option>
					<?php foreach ( $lp_blog_posts as $lp_post ) : ?>
						<option value="<?php echo (int) $lp_post['id']; ?>" <?php selected( (int) ( $lp['post_id'] ?? 0 ), (int) $lp_post['id'] ); ?>><?php echo esc_html( $lp_post['title'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="muted">Карточка статьи</div>
			<div class="row">
				<div data-repeater-list="guide-tags-list">
					<?php foreach ( (array) ( $lp['tags'] ?? array() ) as $idx => $it ) : ?>
						<?php $it = is_array( $it ) ? $it : array(); ?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[guide][tags][<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $it['text'] ?? '' ); ?>" placeholder="Тег">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="guide-tags-list"><?php esc_html_e( 'Добавить тег', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][time]" value="<?php echo esc_attr( $lp['time'] ?? '' ); ?>" style="width:100%" placeholder="Время чтения"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][views]" value="<?php echo esc_attr( $lp['views'] ?? '' ); ?>" style="width:100%" placeholder="Просмотры"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][date_label]" value="<?php echo esc_attr( $lp['date_label'] ?? '' ); ?>" style="width:100%" placeholder="Дата (подпись)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][date]" value="<?php echo esc_attr( $lp['date'] ?? '' ); ?>" style="width:100%" placeholder="Дата ISO (2026-07-19)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][card_title]" value="<?php echo esc_attr( $lp['card_title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок карточки"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[guide][text]" rows="5" placeholder="Текст карточки (HTML)"><?php echo esc_textarea( $lp['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[guide][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row">
				<div class="muted">Изображение</div>
				<?php $g_img = (int) ( $lp['image'] ?? 0 ); $g_url = $g_img ? wp_get_attachment_image_url( $g_img, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[guide][image]" value="<?php echo (int) $g_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $g_url ) : ?><img src="<?php echo esc_url( $g_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="consult" data-group="landing">
			<?php $lp = $all['consult'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][badge]" value="<?php echo esc_attr( $lp['badge'] ?? '' ); ?>" style="width:100%" placeholder="Подзаголовок (badge)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[consult][title]" rows="3" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $lp['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[consult][text]" rows="3" style="width:100%" placeholder="Текст под заголовком"><?php echo esc_textarea( $lp['text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][contact_label]" value="<?php echo esc_attr( $lp['contact_label'] ?? '' ); ?>" style="width:100%" placeholder="Подпись перед телефоном"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][phone]" value="<?php echo esc_attr( $lp['phone'] ?? '' ); ?>" style="width:100%" placeholder="Телефон"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][input_placeholder]" value="<?php echo esc_attr( $lp['input_placeholder'] ?? '' ); ?>" style="width:100%" placeholder="Плейсхолдер поля"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[consult][btn_text]" value="<?php echo esc_attr( $lp['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row">
				<div class="muted">Согласия (текст + ссылка)</div>
				<div data-repeater-list="consult-consents-list">
					<?php foreach ( (array) ( $lp['consents'] ?? array() ) as $idx => $it ) : ?>
						<?php
						$it = is_array( $it ) ? $it : array();
						?>
						<div class="repeater-item" data-repeater-item>
							<div class="cols">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][text]" value="<?php echo esc_attr( $it['text'] ?? '' ); ?>" placeholder="Текст перед ссылкой">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][link_text]" value="<?php echo esc_attr( $it['link_text'] ?? '' ); ?>" placeholder="Текст ссылки">
								<input type="text" name="tolstenko_block_defaults[consult][consents][<?php echo (int) $idx; ?>][link_url]" value="<?php echo esc_attr( $it['link_url'] ?? '' ); ?>" placeholder="URL ссылки">
								<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
								<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
								<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="actions"><button type="button" class="button" data-add-item="consult-consents-list"><?php esc_html_e( 'Добавить согласие', 'tolstenko-theme' ); ?></button></div>
			</div>
			<div class="row">
				<div class="muted">Фото справа</div>
				<?php $lp_img_id = (int) ( $lp['image'] ?? 0 ); $lp_img_url = $lp_img_id ? wp_get_attachment_image_url( $lp_img_id, 'medium' ) : ''; ?>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[consult][image]" value="<?php echo (int) $lp_img_id; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $lp_img_url ) : ?><img src="<?php echo esc_url( $lp_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>

		<div class="tolstenko-df-panel" data-panel="hero_stats" data-group="landing">
			<?php $hs = $all['hero_stats'] ?? array(); ?>
			<div class="muted"><?php esc_html_e( 'Пункты (значение + подпись)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="hero-stats-list">
				<?php foreach ( (array) ( $hs['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[hero_stats][items][<?php echo (int) $idx; ?>][num]" value="<?php echo esc_attr( $it['num'] ?? '' ); ?>" placeholder="Значение">
							<input type="text" name="tolstenko_block_defaults[hero_stats][items][<?php echo (int) $idx; ?>][label]" value="<?php echo esc_attr( $it['label'] ?? '' ); ?>" placeholder="Подпись">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="hero-stats-list"><?php esc_html_e( 'Добавить пункт', 'tolstenko-theme' ); ?></button></div>
		</div>
		<div class="tolstenko-df-panel" data-panel="situations" data-group="landing">
			<?php $st = $all['situations'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[situations][badge]" value="<?php echo esc_attr( $st['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[situations][title]" value="<?php echo esc_attr( $st['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="muted"><?php esc_html_e( 'Карточки (по две в слайде)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="situations-list">
				<?php foreach ( (array) ( $st['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[situations][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Заголовок">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[situations][items][<?php echo (int) $idx; ?>][text]" rows="2" placeholder="Текст (можно <span>)"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="situations-list"><?php esc_html_e( 'Добавить карточку', 'tolstenko-theme' ); ?></button></div>
		</div>
		<div class="tolstenko-df-panel" data-panel="process" data-group="landing">
			<?php $pr2 = $all['process'] ?? array(); $pr2_img = (int) ( $pr2['image'] ?? 0 ); $pr2_img_url = $pr2_img ? wp_get_attachment_image_url( $pr2_img, 'medium' ) : ''; ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[process][badge]" value="<?php echo esc_attr( $pr2['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[process][title]" value="<?php echo esc_attr( $pr2['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Изображение', 'tolstenko-theme' ); ?></div>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[process][image]" value="<?php echo (int) $pr2_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $pr2_img_url ) : ?><img src="<?php echo esc_url( $pr2_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
			<div class="muted"><?php esc_html_e( 'Шаги (нумерация автоматически)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="process-list">
				<?php foreach ( (array) ( $pr2['items'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[process][items][<?php echo (int) $idx; ?>][title]" value="<?php echo esc_attr( $it['title'] ?? '' ); ?>" placeholder="Название шага">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[process][items][<?php echo (int) $idx; ?>][text]" rows="3" placeholder="Описание (HTML)"><?php echo esc_textarea( $it['text'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="process-list"><?php esc_html_e( 'Добавить шаг', 'tolstenko-theme' ); ?></button></div>
		</div>

		<div class="tolstenko-df-panel" data-panel="cost" data-group="landing">
			<?php $cst = $all['cost'] ?? array(); $cst_img = (int) ( $cst['image'] ?? 0 ); $cst_img_url = $cst_img ? wp_get_attachment_image_url( $cst_img, 'medium' ) : ''; ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][badge]" value="<?php echo esc_attr( $cst['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][title]" value="<?php echo esc_attr( $cst['title'] ?? '' ); ?>" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][lead]" rows="3" placeholder="Текст под заголовком (HTML)"><?php echo esc_textarea( $cst['lead'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Цены', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="cost-prices-list">
				<?php foreach ( (array) ( $cst['prices'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[cost][prices][<?php echo (int) $idx; ?>][name]" value="<?php echo esc_attr( $it['name'] ?? '' ); ?>" placeholder="Услуга">
							<input type="text" name="tolstenko_block_defaults[cost][prices][<?php echo (int) $idx; ?>][value]" value="<?php echo esc_attr( $it['value'] ?? '' ); ?>" placeholder="Значение (HTML)">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="cost-prices-list"><?php esc_html_e( 'Добавить цену', 'tolstenko-theme' ); ?></button></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][card_title]" rows="2" placeholder="Заголовок карточки (HTML)"><?php echo esc_textarea( $cst['card_title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cost][card_text]" rows="2" placeholder="Текст карточки"><?php echo esc_textarea( $cst['card_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cost][btn_text]" value="<?php echo esc_attr( $cst['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
		<div class="row"><input type="text" name="tolstenko_block_defaults[cost][btn_url]" value="<?php echo esc_attr( $cst['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
		<div class="muted"><?php esc_html_e( 'Ссылки с иконками (под кнопкой)', 'tolstenko-theme' ); ?></div>
		<div id="cost-links-template" style="display:none;">
			<div class="cost-link-row" style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
				<input type="hidden" name="tolstenko_block_defaults[cost][links][__INDEX__][icon_id]" class="cost-link-icon-id" value="" />
				<img src="" class="cost-link-icon-preview" style="max-width:32px;max-height:32px;display:none;" />
				<button type="button" class="button cost-link-choose-icon">Загрузить SVG</button>
				<button type="button" class="button cost-link-remove-icon hidden" style="margin-left:4px;">Удалить иконку</button>
				<input type="text" name="tolstenko_block_defaults[cost][links][__INDEX__][title]" placeholder="Название" style="min-width:120px;" />
				<input type="text" name="tolstenko_block_defaults[cost][links][__INDEX__][link]" placeholder="Ссылка" style="flex:1; min-width:220px;" />
				<button type="button" class="button cost-remove-link">Удалить строку</button>
			</div>
		</div>

		<div class="cost-links-repeater">
			<?php foreach ( (array) ( $cst['links'] ?? array() ) as $idx => $lk ) : ?>
				<?php
				$lk       = is_array( $lk ) ? $lk : array();
				$icon_raw = $lk['icon_id'] ?? '';
				$icon_url = tolstenko_contact_resolve_icon_url( $icon_raw );
				?><div class="cost-link-row" style="margin-top:8px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
					<input type="hidden" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][icon_id]" class="cost-link-icon-id" value="<?php echo esc_attr( $icon_raw ); ?>" />
					<img src="<?php echo esc_url( $icon_url ); ?>" class="cost-link-icon-preview" style="max-width:32px;max-height:32px;<?php echo empty( $icon_url ) ? 'display:none;' : ''; ?>" />
					<button type="button" class="button cost-link-choose-icon">Загрузить SVG</button>
					<button type="button" class="button cost-link-remove-icon<?php echo empty( $icon_url ) ? ' hidden' : ''; ?>" style="margin-left:4px;">Удалить иконку</button>
					<input type="text" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][title]" placeholder="Название" value="<?php echo esc_attr( $lk['title'] ?? '' ); ?>" style="min-width:120px;" />
					<input type="text" name="tolstenko_block_defaults[cost][links][<?php echo (int) $idx; ?>][link]" placeholder="Ссылка" value="<?php echo esc_attr( $lk['link'] ?? '' ); ?>" style="flex:1; min-width:220px;" />
					<button type="button" class="button cost-remove-link">Удалить строку</button>
				</div>
			<?php endforeach; ?>
		</div>

		<button type="button" class="button cost-add-link" style="margin-top:8px;"><?php esc_html_e( 'Добавить ссылку', 'tolstenko-theme' ); ?></button>
			<div class="row">
				<div class="muted"><?php esc_html_e( 'Изображение', 'tolstenko-theme' ); ?></div>
				<div class="tolstenko-defaults-image-row">
					<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[cost][image]" value="<?php echo (int) $cst_img; ?>">
					<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Выбрать изображение', 'tolstenko-theme' ); ?></button>
					<div class="icon-preview"><?php if ( $cst_img_url ) : ?><img src="<?php echo esc_url( $cst_img_url ); ?>" alt=""><?php endif; ?></div>
				</div>
			</div>
		</div>
		<div class="tolstenko-df-panel" data-panel="blog_more" data-group="landing">
			<?php $bm = $all['blog_more'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_more][text]" value="<?php echo esc_attr( $bm['text'] ?? '' ); ?>" style="width:100%" placeholder="Текст кнопки"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[blog_more][url]" value="<?php echo esc_attr( $bm['url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка"></div>
		</div>

<div class="tolstenko-df-panel" data-panel="cases" data-group="landing">
			<?php $csd = $all['cases'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][badge]" value="<?php echo esc_attr( $csd['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cases][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $csd['title'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][all_text]" value="<?php echo esc_attr( $csd['all_text'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка «Все кейсы» — текст"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][all_url]" value="<?php echo esc_attr( $csd['all_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка «Все кейсы» — URL"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[cases][foot_text]" rows="2" placeholder="Текст под слайдером"><?php echo esc_textarea( $csd['foot_text'] ?? '' ); ?></textarea></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][btn_text]" value="<?php echo esc_attr( $csd['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Кнопка под слайдером"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[cases][btn_url]" value="<?php echo esc_attr( $csd['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
			<p class="description"><?php esc_html_e( 'Карточки берутся из записей «Кейсы» (CPT case), фильтр — по категориям кейсов.', 'tolstenko-theme' ); ?></p>
		</div><div class="tolstenko-df-panel" data-panel="programs" data-group="landing">
			<?php $prg = $all['programs'] ?? array(); ?>
			<div class="row"><input type="text" name="tolstenko_block_defaults[programs][badge]" value="<?php echo esc_attr( $prg['badge'] ?? '' ); ?>" style="width:100%" placeholder="Надзаголовок (бейдж)"></div>
			<div class="row"><textarea name="tolstenko_block_defaults[programs][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $prg['title'] ?? '' ); ?></textarea></div>
			<div class="row"><textarea name="tolstenko_block_defaults[programs][lead]" rows="3" placeholder="Текст под заголовком (HTML)"><?php echo esc_textarea( $prg['lead'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Колонки (первая — категория; «Акцент» = 1 — золотая)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="programs-columns-list">
				<?php foreach ( (array) ( $prg['columns'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it = is_array( $it ) ? $it : array();
					$flag_id = (int) ( $it['flag'] ?? 0 );
					$flag_url = $flag_id ? wp_get_attachment_image_url( $flag_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[programs][columns][<?php echo (int) $idx; ?>][name]" value="<?php echo esc_attr( $it['name'] ?? '' ); ?>" placeholder="Название">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[programs][columns][<?php echo (int) $idx; ?>][flag]" value="<?php echo (int) $flag_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Флаг', 'tolstenko-theme' ); ?></button>
							<input type="text" name="tolstenko_block_defaults[programs][columns][<?php echo (int) $idx; ?>][accent]" value="<?php echo esc_attr( $it['accent'] ?? '' ); ?>" placeholder="Акцент (1)" style="width:110px">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $flag_url ) : ?><img src="<?php echo esc_url( $flag_url ); ?>" alt=""><?php endif; ?></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="programs-columns-list"><?php esc_html_e( 'Добавить колонку', 'tolstenko-theme' ); ?></button></div>
			<div class="muted"><?php esc_html_e( 'Строки таблицы', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="programs-rows-list">
				<?php foreach ( (array) ( $prg['rows'] ?? array() ) as $idx => $it ) : ?>
					<?php $it = is_array( $it ) ? $it : array(); ?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[programs][rows][<?php echo (int) $idx; ?>][criterion]" value="<?php echo esc_attr( $it['criterion'] ?? '' ); ?>" placeholder="Критерий">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[programs][rows][<?php echo (int) $idx; ?>][values]" rows="4" placeholder="Значения по колонкам (по одному в строке)"><?php echo esc_textarea( $it['values'] ?? '' ); ?></textarea></div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="programs-rows-list"><?php esc_html_e( 'Добавить строку', 'tolstenko-theme' ); ?></button></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[programs][btn_text]" value="<?php echo esc_attr( $prg['btn_text'] ?? '' ); ?>" style="width:100%" placeholder="Кнопка"></div>
			<div class="row"><input type="text" name="tolstenko_block_defaults[programs][btn_url]" value="<?php echo esc_attr( $prg['btn_url'] ?? '' ); ?>" style="width:100%" placeholder="Ссылка кнопки"></div>
		</div><div class="tolstenko-df-panel" data-panel="banks" data-group="landing">
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
		</div><div class="tolstenko-df-panel" data-panel="europe" data-group="landing">
			<?php $eur = $all['europe'] ?? array(); ?>
			<div class="row"><textarea name="tolstenko_block_defaults[europe][title]" rows="2" style="width:100%" placeholder="Заголовок (HTML, акцент — <span>&hellip;</span>)"><?php echo esc_textarea( $eur['title'] ?? '' ); ?></textarea></div>
			<div class="muted"><?php esc_html_e( 'Страны (таблица)', 'tolstenko-theme' ); ?></div>
			<div data-repeater-list="europe-rows-list">
				<?php foreach ( (array) ( $eur['rows'] ?? array() ) as $idx => $it ) : ?>
					<?php
					$it = is_array( $it ) ? $it : array();
					$flag_id = (int) ( $it['flag'] ?? 0 );
					$flag_url = $flag_id ? wp_get_attachment_image_url( $flag_id, 'thumbnail' ) : '';
					?>
					<div class="repeater-item" data-repeater-item>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][country]" value="<?php echo esc_attr( $it['country'] ?? '' ); ?>" placeholder="Страна">
							<input type="hidden" class="tolstenko-defaults-icon-id" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][flag]" value="<?php echo (int) $flag_id; ?>">
							<button type="button" class="button tolstenko-defaults-pick-icon"><?php esc_html_e( 'Флаг', 'tolstenko-theme' ); ?></button>
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][note]" value="<?php echo esc_attr( $it['note'] ?? '' ); ?>" placeholder="Примечание">
							<button type="button" class="button move-btn" data-move-up title="Вверх">↑</button>
							<button type="button" class="button move-btn" data-move-down title="Вниз">↓</button>
							<button type="button" class="button" data-remove-item><?php esc_html_e( 'Удалить', 'tolstenko-theme' ); ?></button>
						</div>
						<div class="icon-preview" style="margin-top:8px;"><?php if ( $flag_url ) : ?><img src="<?php echo esc_url( $flag_url ); ?>" alt=""><?php endif; ?></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][price]" value="<?php echo esc_attr( $it['price'] ?? '' ); ?>" placeholder="Стоимость">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][term]" value="<?php echo esc_attr( $it['term'] ?? '' ); ?>" placeholder="Срок оформления">
						</div>
						<div class="row"><textarea name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][benefits]" rows="3" placeholder="Преимущества (по одному в строке)"><?php echo esc_textarea( $it['benefits'] ?? '' ); ?></textarea></div>
						<div class="cols">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][link_text]" value="<?php echo esc_attr( $it['link_text'] ?? '' ); ?>" placeholder="Ссылка — текст">
							<input type="text" name="tolstenko_block_defaults[europe][rows][<?php echo (int) $idx; ?>][link_url]" value="<?php echo esc_attr( $it['link_url'] ?? '' ); ?>" placeholder="Ссылка — URL">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="actions"><button type="button" class="button" data-add-item="europe-rows-list"><?php esc_html_e( 'Добавить страну', 'tolstenko-theme' ); ?></button></div>
			<div class="cols">
				<input type="text" name="tolstenko_block_defaults[europe][link_text]" value="<?php echo esc_attr( $eur['link_text'] ?? '' ); ?>" placeholder="Ссылка по умолчанию — текст">
				<input type="text" name="tolstenko_block_defaults[europe][link_url]" value="<?php echo esc_attr( $eur['link_url'] ?? '' ); ?>" placeholder="Ссылка по умолчанию — URL">
			</div>
			<div class="row"><textarea name="tolstenko_block_defaults[europe][foot_text]" rows="2" placeholder="Текст под таблицей"><?php echo esc_textarea( $eur['foot_text'] ?? '' ); ?></textarea></div>
			<div class="cols">
				<input type="text" name="tolstenko_block_defaults[europe][btn_text]" value="<?php echo esc_attr( $eur['btn_text'] ?? '' ); ?>" placeholder="Кнопка под таблицей">
				<input type="text" name="tolstenko_block_defaults[europe][btn_url]" value="<?php echo esc_attr( $eur['btn_url'] ?? '' ); ?>" placeholder="Ссылка кнопки">
			</div>
		</div>

		</div><!-- .tolstenko-df-panels-source -->
	</div>
	<div class="actions">
		<!-- <button type="submit" name="tolstenko_defaults_reset_all" value="1" class="button"><?php esc_html_e( 'Сбросить всё к заводским', 'tolstenko-theme' ); ?></button> -->
	</div>
	<?php submit_button( __( 'Сохранить дефолты', 'tolstenko-theme' ) ); ?>
	<script src="<?php echo esc_url( tolstenko_block_defaults_asset_url( 'assets/js/admin/block-defaults.js' ) ); ?>"></script>
	</form>
	</div>
	<?php
}

