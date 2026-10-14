<?php
$cd = tolstenko_get_contact_data();
$socials = $cd['socials'];
?>
<div class="socials">
  <?php foreach ($socials as $item) : ?>
    <?php
    $link = (string) ($item['link'] ?? '');
    $icon = (string) ($item['icon'] ?? '');
    if ($link === '' || $icon === '') {
      continue;
    }
    $svg = tolstenko_contact_get_inline_svg($icon);
    ?>
    <?php if ($svg !== '') : ?>
      <a href="<?= esc_url($link); ?>" class="socials__link" target="_blank"><?= $svg; ?></a>
    <?php else : ?>
      <a href="<?= esc_url($link); ?>" class="socials__link" target="_blank"><img src="<?= esc_url(tolstenko_contact_resolve_icon_url($icon)); ?>" alt="<?= esc_attr((string) ($item['text'] ?? '')); ?>"></a>
    <?php endif; ?>
  <?php endforeach; ?>
</div>