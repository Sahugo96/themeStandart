<?php
$cd = tolstenko_get_contact_data();
$socials = $cd['socials_rgb'];
?>
<div class="socials">
  <?php foreach ($socials as $item) : ?>
    <?php
    $link = (string) ($item['link'] ?? '');
    $image = tolstenko_contact_get_image_attrs($item['icon'] ?? '');
    if ($link === '' || $image['url'] === '') {
      continue;
    }
    ?>
    <a href="<?= esc_url($link); ?>" class="socials__link" target="_blank">
      <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
    </a>
  <?php endforeach; ?>
</div>