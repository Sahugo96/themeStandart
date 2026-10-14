<?php

defined('ABSPATH') || exit;

/**
 * @var string   $content    Inner blocks HTML.
 * @var array    $attributes Block attributes.
 * @var WP_Block $block      Block instance.
 */

$content = isset($content) ? trim((string) $content) : '';

if ($content === '') {
    return;
}
?>
<div class="hide">
  <?= $content; ?>
</div>
