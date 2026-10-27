<?php
$translations = pll_the_languages(['raw' => 1]);

$alternate_lang = '';
$alternate_url = '';
$query_string = '';

if (!empty($_GET)) {
    $query_string = '?' . http_build_query($_GET);
}

foreach ($translations as $slug => $translation) {
    if (!$translation['current_lang']) {
        $alternate_lang = $slug;
        $alternate_url = $translation['url'] . $query_string;
        break;
    }
}

$current_option_id = Get::option_id();
$alternate_option_id = pll_get_post($current_option_id, $alternate_lang);
$header_lang_img = get_field('header_lang_img', $alternate_option_id);
?>

<?php if ($alternate_lang && $alternate_url): ?>
    <div class="lang">
        <a class="lang__item" href="<?= esc_url($alternate_url); ?>">
            <?= esc_html($alternate_lang); ?>
            <?php if (!empty($header_lang_img)): ?>
                <img src="<?= esc_url($header_lang_img); ?>" alt="Lang image">
            <?php endif; ?>
        </a>
    </div>
<?php endif; ?>
