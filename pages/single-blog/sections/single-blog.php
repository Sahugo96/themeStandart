<?php
$contents = get_field('single-blog_content');
$toc_items = [];
$used_toc_ids = [];
$toc_heading_level = 0;

if (is_array($contents) && $contents) {
  $has_h2 = false;
  $has_h3 = false;

  foreach ($contents as $content) {
    if (($content['acf_fc_layout'] ?? '') !== 'content' || !is_array($content['content_list'] ?? null)) {
      continue;
    }

    foreach ($content['content_list'] as $cont) {
      if (($cont['acf_fc_layout'] ?? '') !== 'redactor') {
        continue;
      }

      $redactor_html = (string) ($cont['redactor'] ?? '');

      if ($redactor_html === '') {
        continue;
      }

      if (!$has_h2 && preg_match('/<h2\b/i', $redactor_html)) {
        $has_h2 = true;
      }

      if (!$has_h3 && preg_match('/<h3\b/i', $redactor_html)) {
        $has_h3 = true;
      }
    }
  }

  if ($has_h2) {
    $toc_heading_level = 2;
  } elseif ($has_h3) {
    $toc_heading_level = 3;
  }

  if ($toc_heading_level) {
    foreach ($contents as $content_index => $content) {
      if (($content['acf_fc_layout'] ?? '') !== 'content' || !is_array($content['content_list'] ?? null)) {
        continue;
      }

      foreach ($content['content_list'] as $cont_index => $cont) {
        if (($cont['acf_fc_layout'] ?? '') !== 'redactor') {
          continue;
        }

        $redactor_html = (string) ($cont['redactor'] ?? '');

        if ($redactor_html === '') {
          continue;
        }

        $heading_pattern = '/<h(' . $toc_heading_level . ')([^>]*)>(.*?)<\/h\1>/isu';

        $redactor_html = preg_replace_callback($heading_pattern, function ($matches) use (&$toc_items, &$used_toc_ids) {
          $level = (int) $matches[1];
          $attrs = (string) $matches[2];
          $body = (string) $matches[3];
          $text = trim(wp_strip_all_tags($body));

          if ($text === '') {
            return $matches[0];
          }

          $base_id = sanitize_title($text);

          if ($base_id === '') {
            $base_id = 'section';
          }

          $unique_id = $base_id;
          $suffix = 2;

          while (isset($used_toc_ids[$unique_id])) {
            $unique_id = $base_id . '-' . $suffix;
            $suffix++;
          }

          $used_toc_ids[$unique_id] = true;
          $toc_items[] = [
            'id' => $unique_id,
            'text' => $text,
            'level' => $level,
          ];

          if (preg_match('/\sid=(["\']).*?\1/i', $attrs)) {
            return $matches[0];
          }

          return '<h' . $level . $attrs . ' id="' . esc_attr($unique_id) . '">' . $body . '</h' . $level . '>';
        }, $redactor_html);

        $contents[$content_index]['content_list'][$cont_index]['redactor'] = $redactor_html;
      }
    }
  }
}
?>

<section class="single-blog section">
  <div class="container">
    <div class="single-blog__wrapper">
      <div class="single-blog__content">
        <div class="single-blog__top">
          <?php
          if (has_post_thumbnail()) {
            $thumbnail_id = get_post_thumbnail_id();

            $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'full');
            $thumbnail_srcset = wp_get_attachment_image_srcset($thumbnail_id, 'full');
          }
          ?>

          <img class="single-blog__top-img lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= esc_url($thumbnail_url); ?>" data-srcset="<?= esc_attr($thumbnail_srcset); ?>" alt="<?= the_title(); ?>" decoding="async" loading="lazy">

          <h2 class="single-blog__title h2"><?= the_title(); ?></h2>

          <div class="single-blog__pretext paragraph-15-25"><?= get_field('single-blog_text'); ?></div>

          <div class="blog-card__stats">
            <?php    get_template_part('modules/stats/stats'); ?>
          </div>

        </div>

        <div class="single-blog__content-blocks">
          <?php if ($toc_items) : ?>
            <div class="single-blog__content-article br-30">
              <div class="single-blog__content-article-title line-caps-bold-16-15">СОДЕРЖАНИЕ СТАТЬИ</div>

              <div class="single-blog__content-article-items">
                <ul class="single-blog__toc">
                  <?php foreach ($toc_items as $item) { ?>
                    <li class="single-blog__toc-item single-blog__toc-item--h<?= (int) $item['level']; ?>">
                      <a class="single-blog__toc-link paragraph-15-25" href="#<?= esc_attr($item['id']); ?>">
                        <?= esc_html($item['text']); ?>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <?php
          if ($contents) {
            foreach ($contents as $content) {
              if ($content['acf_fc_layout'] == 'content') :
          ?>

                <div class="single-blog__content-contents">
                  <?php
                  foreach ($content['content_list'] as $cont) {
                    if ($cont['acf_fc_layout'] == 'redactor') :
                      $redactor = $cont['redactor'];
                  ?>
                      <div class="redactor">
                        <?= $redactor; ?>
                      </div>
                    <?php
                    elseif ($cont['acf_fc_layout'] == 'large_img') :
                      $image = $cont['large_img'];
                      $image = Image::get_image_attrs($image);
                    ?>
                      <img class="single-blog__content-img lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-src="<?= $image['url']; ?>" data-srcset="<?= $image['srcset']; ?>" alt="<?= $image['alt']; ?>" data-sizes="<?= $image['sizes']; ?>">
                    <?php
                    elseif ($cont['acf_fc_layout'] == 'imgs') :
                      $left_img = $cont['left_img'];
                      $left_img = Image::get_image_attrs($left_img);
                      $right_img = $cont['right_img'];
                      $right_img = Image::get_image_attrs($right_img);
                    ?>
                      <div class="single-blog__content-imgs">
                        <img class="lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-src="<?= $left_img['url']; ?>" alt="<?= $left_img['alt']; ?>">

                        <img class="lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-src="<?= $right_img['url']; ?>" alt="<?= $right_img['alt']; ?>">
                      </div>
                    <?php
                    elseif ($cont['acf_fc_layout'] == 'video') :
                      $preview = $cont['preview'];
                      $preview = Image::get_image_attrs($preview);
                      $iframe = $cont['rutube_iframe'];
                    ?>
                      <div class="single-blog__content-video video load-on-vissible--js" data-module="./modules/lazyLoad.js,./modules/video.js">
                        <?php
                        if ($iframe) {
                          echo $iframe;
                        } else {
                        ?>
                          <video class="video__iframe" src="<?= $cont['video_url']; ?>" loop playsinline controls></video>
                        <?php
                        }
                        ?>

                        <img class="video__img lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-src="<?= $preview['url']; ?>" data-srcset="<?= $preview['srcset']; ?>" alt="<?= $preview['alt']; ?>" data-sizes="<?= $preview['sizes']; ?>">

                        <button class="video__btn" data-video="<?php echo esc_url($cont['video_url']); ?>">
                          <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.82263 0.0285661C3.40033 0.0281482 2.98488 0.135329 2.61549 0.339995C2.23667 0.533082 1.91754 0.82562 1.6923 1.18625C1.46706 1.54688 1.34421 1.96201 1.33691 2.38714V17.64C1.34421 18.0651 1.46706 18.4803 1.6923 18.8409C1.91754 19.2015 2.23667 19.4941 2.61549 19.6871C2.99158 19.896 3.41545 20.0038 3.84565 19.9998C4.27584 19.9957 4.69764 19.8802 5.06977 19.6643L17.3983 12.0386C17.7788 11.8468 18.0985 11.5532 18.3219 11.1904C18.5452 10.8276 18.6634 10.4099 18.6633 9.98384C18.6631 9.5578 18.5446 9.14017 18.321 8.77753C18.0974 8.41488 17.7775 8.12146 17.3969 7.92999L5.06834 0.361423L5.04549 0.348566C4.67225 0.138309 4.25101 0.0280782 3.82263 0.0285661Z" />
                          </svg>
                        </button>
                      </div>
                  <?php endif;
                  }
                  ?>
                </div>
              <?
              elseif ($content['acf_fc_layout'] == 'consultation_tg') :
                $cd = tolstenko_get_contact_data();
                  $svg_url = tolstenko_contact_resolve_icon_url($cd['telegram_ico']);
              ?>
                <div class="single-blog__content-block single-blog__content-block--tg tg-block br-30">
                  <h2 class="tg-block__title h2"><?= $content['consultation_tg_title']; ?></h2>
                  <p class="tg-block__content"><?= $content['consultation_tg_text']; ?></p>

                  <div class="tg-block__bottom">
                    <a class="tg-block__btn default-btn default-btn--tg" href="<?= $cd['telegram'];  ?>" target="_blank">
                      <?php
                      if ($svg_url) {
                        $svg_content = file_get_contents($svg_url);

                        if ($svg_content) {
                          echo $svg_content;
                        }
                      }
                      ?>

                      Подписаться
                    </a>

                    <p class="tg-block__text line-13-15"><?= $content['consultation_tg_btn']; ?></p>
                  </div>
                </div>
              <?php
              elseif ($content['acf_fc_layout'] == 'blockquote') :
              ?>
                <blockquote class="single-blog__content-block single-blog__content-block--blockquote br-30 blockquote" cite="<?= $content['blockquote_link']; ?>">

                  <div class="blockquote__content">
                    <svg viewBox="0 0 35 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3571 29.7308C29.866 24.7733 34.0377 19.0027 34.872 12.4193C36.1713 2.17096 27.2564 -2.84506 22.739 1.66146C18.2217 6.16798 20.9291 11.8893 24.1999 13.4537C27.4708 15.018 29.4711 14.4726 29.1221 16.5629C28.7731 18.6532 24.1202 24.4462 20.0316 27.1444C19.887 27.2712 19.7947 27.4499 19.7736 27.6441C19.7524 27.8383 19.8041 28.0336 19.9179 28.1901L20.9291 29.5422C21.3679 30.1286 21.7887 30.106 22.3571 29.7319M2.58657 29.7308C10.0955 24.7733 14.2671 19.0027 15.1015 12.4193C16.4018 2.17096 7.48683 -2.84506 2.96951 1.66146C-1.54782 6.16798 1.15958 11.8893 4.4314 13.4537C7.70322 15.018 9.70261 14.4726 9.35359 16.5629C9.00457 18.6532 4.35063 24.4462 0.2621 27.1444C0.117573 27.2713 0.0254824 27.4501 0.00455495 27.6443C-0.0163763 27.8385 0.0354196 28.0337 0.149414 28.1901L1.15958 29.5422C1.59835 30.1286 2.01917 30.106 2.58657 29.7319" />
                    </svg>

                    <p class="paragraph-15-25"><?= $content['blockquote_text']; ?></p>

                    <svg viewBox="0 0 35 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3571 29.7308C29.866 24.7733 34.0377 19.0027 34.872 12.4193C36.1713 2.17096 27.2564 -2.84506 22.739 1.66146C18.2217 6.16798 20.9291 11.8893 24.1999 13.4537C27.4708 15.018 29.4711 14.4726 29.1221 16.5629C28.7731 18.6532 24.1202 24.4462 20.0316 27.1444C19.887 27.2712 19.7947 27.4499 19.7736 27.6441C19.7524 27.8383 19.8041 28.0336 19.9179 28.1901L20.9291 29.5422C21.3679 30.1286 21.7887 30.106 22.3571 29.7319M2.58657 29.7308C10.0955 24.7733 14.2671 19.0027 15.1015 12.4193C16.4018 2.17096 7.48683 -2.84506 2.96951 1.66146C-1.54782 6.16798 1.15958 11.8893 4.4314 13.4537C7.70322 15.018 9.70261 14.4726 9.35359 16.5629C9.00457 18.6532 4.35063 24.4462 0.2621 27.1444C0.117573 27.2713 0.0254824 27.4501 0.00455495 27.6443C-0.0163763 27.8385 0.0354196 28.0337 0.149414 28.1901L1.15958 29.5422C1.59835 30.1286 2.01917 30.106 2.58657 29.7319" />
                    </svg>
                  </div>

                  <?php
                  if ($content['blockquote_true']) {
                    $blockquote_img = $content['blockquote_img'];
                    $blockquote_img = Image::get_image_attrs($blockquote_img);
                  ?>
                    <div class="blockquote__right">
                      <img class="blockquote__right-img lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="<?= $blockquote_img['url']; ?>" data-srcset="<?= $blockquote_img['srcset']; ?>" alt="<?= $content['blockquote_author']; ?>" data-sizes="<?= $blockquote_img['sizes']; ?>">

                      <div class="blockquote__right-wrapper">
                        <cite class="line-caps-bold-16-15"><?= $content['blockquote_author']; ?></cite>

                        <span><?= $content['blockquote_author_under']; ?></span>
                      </div>
                      
                      <?php
                        if ($content['blockquote_btn']) {
                        ?>
                        <a class="blockquote__right-btn default-btn" href="<?= $content['blockquote_btn']['url']; ?>" target="<?= $content['blockquote_btn']['target']; ?>"><?= $content['blockquote_btn']['title']; ?></a>
                        <?php
                        }
                        ?>
                    </div>
                  <?php
                  }
                  ?>

                </blockquote>
              <?php
              elseif ($content['acf_fc_layout'] == 'number_list') :
                $list = $content['number_list'];
              ?>
                <div class="single-blog__content-block single-blog__content-block--number br-30">

                  <ul class="single-blog__content-list">
                    <?php
                    foreach ($list as $elem) {
                    ?>
                      <li><span></span><?= $elem['text']; ?></li>
                    <?php
                    }
                    ?>
                  </ul>
                </div>
              <?php
              elseif ($content['acf_fc_layout'] == 'warning') :
                $list = $content['warning_items'];
              ?>
                <div class="single-blog__content-block single-blog__content-block--warning br-30">

                  <ul class="single-blog__warnings">
                    <?php
                    foreach ($list as $elem) {
                    ?>
                      <li class="single-blog__warnings-item">
                        <?php
                        if ($elem['type'] == 'Кастомный') {
                          $svg_url = $elem['ico'];
                          $svg_content = file_get_contents($svg_url);

                          if ($svg_content) {
                            echo $svg_content;
                          }
                        } elseif ($elem['type'] == 'Внимание') {
                        ?>
                          <svg class="warn" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M54.7822 27.5005C54.7822 12.4328 42.5682 0.21875 27.5005 0.21875C12.4328 0.21875 0.21875 12.4328 0.21875 27.5005C0.21875 42.5682 12.4328 54.7822 27.5005 54.7822C42.5682 54.7822 54.7822 42.5682 54.7822 27.5005ZM27.5005 13.8596C28.2241 13.8596 28.918 14.1471 29.4296 14.6587C29.9412 15.1703 30.2287 15.8642 30.2287 16.5878V30.2287C30.2287 30.9522 29.9412 31.6461 29.4296 32.1578C28.918 32.6694 28.2241 32.9568 27.5005 32.9568C26.7769 32.9568 26.083 32.6694 25.5714 32.1578C25.0598 31.6461 24.7723 30.9522 24.7723 30.2287V16.5878C24.7723 15.8642 25.0598 15.1703 25.5714 14.6587C26.083 14.1471 26.7769 13.8596 27.5005 13.8596ZM24.7723 38.4132C24.7723 37.6896 25.0598 36.9957 25.5714 36.4841C26.083 35.9725 26.7769 35.685 27.5005 35.685H27.5223C28.2459 35.685 28.9398 35.9725 29.4514 36.4841C29.9631 36.9957 30.2505 37.6896 30.2505 38.4132C30.2505 39.1368 29.9631 39.8307 29.4514 40.3423C28.9398 40.8539 28.2459 41.1414 27.5223 41.1414H27.5005C26.7769 41.1414 26.083 40.8539 25.5714 40.3423C25.0598 39.8307 24.7723 39.1368 24.7723 38.4132Z" />
                          </svg>
                        <?php
                        } elseif ($elem['type'] == 'Подметить') {
                        ?>
                          <svg class="pin" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.5 0C42.6878 0 55 12.3122 55 27.5C55 42.6878 42.6878 55 27.5 55C12.3122 55 0 42.6878 0 27.5C0 12.3122 12.3122 0 27.5 0ZM29.5986 11.0898C29.2604 11.0536 28.9183 11.1011 28.6025 11.2275C28.2865 11.3541 28.0059 11.5565 27.7861 11.8164C27.5664 12.0763 27.4132 12.3862 27.3408 12.7188L25.7607 19.9932C24.4911 19.8691 23.2111 20.0908 22.0566 20.6338C20.9024 21.1767 19.9162 22.0211 19.2021 23.0781L17.4102 25.7246C17.2249 25.999 17.156 26.336 17.2188 26.6611C17.2816 26.9862 17.471 27.2733 17.7451 27.459L21.9287 30.2881L14.3525 41.4961C14.2573 41.632 14.1896 41.7852 14.1543 41.9473C14.119 42.1094 14.1163 42.2772 14.1465 42.4404C14.1767 42.6036 14.2391 42.7596 14.3301 42.8984C14.421 43.0372 14.5393 43.1562 14.6768 43.249C14.8143 43.3418 14.9691 43.407 15.1318 43.4395C15.2945 43.4718 15.4625 43.4715 15.625 43.4385C15.7875 43.4054 15.942 43.3403 16.0791 43.2471C16.2163 43.1537 16.3334 43.0337 16.4238 42.8945L24 31.6865L28.1816 34.5146C28.4561 34.6999 28.793 34.7689 29.1182 34.7061C29.4434 34.6432 29.7304 34.453 29.916 34.1787L31.709 31.5303C32.4238 30.473 32.8401 29.242 32.9131 27.9678C32.986 26.6938 32.7133 25.4238 32.124 24.292L38.2842 20.1123C38.5657 19.9213 38.7958 19.6639 38.9551 19.3633C39.1143 19.0627 39.1974 18.7279 39.1973 18.3877C39.1971 18.0475 39.1136 17.7126 38.9541 17.4121C38.7945 17.1116 38.564 16.8539 38.2822 16.6631L30.5439 11.4355C30.262 11.2449 29.9371 11.1261 29.5986 11.0898Z" />
                          </svg>
                        <?php
                        } elseif ($elem['type'] == 'Идея') {
                        ?>
                          <svg class="ide" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.5 0C12.3122 0 0 12.3122 0 27.5C0 42.6878 12.3122 55 27.5 55C42.6878 55 55 42.6878 55 27.5C55 12.3122 42.6878 0 27.5 0ZM26.5668 10.1648H28.4333V15.6668H26.5668V10.1648ZM18.9331 11.8164L22.0886 16.3214L20.5579 17.3956L17.4024 12.8906L18.9331 11.8164ZM36.0669 11.8164L37.5976 12.8906L34.4421 17.3956L32.9114 16.3214L36.0669 11.8164ZM27.5 17.1707C32.0721 17.1707 35.7782 19.9459 35.7782 23.371L31.0751 37.6145H23.9249L19.2218 23.371C19.2218 19.9458 22.9282 17.1707 27.5 17.1707ZM12.6321 18.8223L17.8018 20.7056L17.1606 22.4613L11.9943 20.578L12.6321 18.8223ZM42.3679 18.8223L43.0057 20.578L37.836 22.4613L37.1982 20.7056L42.3679 18.8223ZM17.5534 26.8555L18.0368 28.6615L12.7228 30.0849L12.2394 28.2788L17.5534 26.8555ZM37.4466 26.8555L42.7606 28.2788L42.2772 30.0849L36.9632 28.6615L37.4466 26.8555ZM23.8208 38.6551H31.1792V41.1291H23.8208V38.6551ZM23.8208 42.3611H31.1792V44.8352H23.8208V42.3611Z" />
                          </svg>
                        <?php
                        }
                        ?>

                        <span><?= $elem['text']; ?></span>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </div>
              <?php
              elseif ($content['acf_fc_layout'] == 'seo') :
              ?>
                <div class="single-blog__content-block single-blog__content-block--seo br-30">
                  <h2 class="single-blog__content-title h2"><?= $content['seo_title']; ?></h2>

                  <a class="single-blog__content-btn default-btn line-caps-bold-16-15" href="#modal"><?= $content['seo_btn']; ?></a>
                </div>
                <?php
              elseif ($content['acf_fc_layout'] == 'table') :
                $table = $content['table'];

                if ($table):
                ?>
                  <div class="single-blog__content-block single-blog__content-block--table br-30 load-on-vissible--js" data-module="./modules/tableScroll.js">
                    <table class="single-blog__content-table" align="left">
                      <?php if ($table['use_header'] && !empty($table['header'])): ?>
                        <thead class="single-blog__content-table-head" align="left">
                          <tr>
                            <?php foreach ($table['header'] as $header): ?>
                              <th class="line-caps-bold-13-15"><?php echo esc_html($header['c']); ?></th>
                            <?php endforeach; ?>
                          </tr>
                        </thead>
                      <?php endif; ?>

                      <tbody class="single-blog__content-table-body">
                        <tr>
                        </tr>
                        <?php foreach ($table['body'] as $row): ?>
                          <tr>
                            <?php foreach ($row as $cell): ?>
                              <td class="line-caps-bold-13-15"><?php echo esc_html($cell['c']); ?></td>
                            <?php endforeach; ?>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
          <?php endif;
              endif;
            }
          }
          ?>
        </div>
      </div>

      <div class="single-blog__right">
        <div class="single-blog__right-info">
          <?php
          $photo = get_field('director_photo', OPTION_ID);
          $photo = Image::get_image_attrs($photo);
          ?>
          <div class="single-blog__right-wrapper">
            <img class="single-blog__right-photo lazyload--js" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==" data-src="<?= $photo['url']; ?>" data-srcset="<?= $photo['srcset']; ?>" alt="<?= $photo['alt']; ?>" data-sizes="<?= $photo['sizes']; ?>">

            <div class="single-blog__right-name line-caps-bold-13-15"><?= get_field('director_name', OPTION_ID) ?></div>

            <div class="single-blog__right-text paragraph-15-25"><?= get_field('director_text', OPTION_ID) ?></div>


            <?php get_template_part('modules/socials/socials-rgb'); ?>


            <a class="single-blog__right-btn default-btn default-btn--red" href="#modal">Бесплатный аудит</a>

            <a class="single-blog__right-btn default-btn" href="#modal">Задать вопрос</a>
          </div>

          <?php
          if (get_field('blog_actions')) {
            ?>
            <div class="single-blog__right-actions splide load-on-vissible--js"
              aria-label="Splide direction"
              data-module="./libs/splide.min.js,./modules/actionsBlogSplideInit.js"
              data-css="<?= THEME_PATH; ?>/assets/css/libs/splide-core.min.css">
              <div class="splide__track">
                <div class="single-blog__right-list splide__list">

                  <?php
                  $blog_actions_field = get_field('blog_actions');

                  if (!empty($blog_actions_field)) {
                    $actions_ids = [];

                    if (is_array($blog_actions_field)) {
                      foreach ($blog_actions_field as $item) {
                        if (is_object($item) && isset($item->ID)) {
                          $actions_ids[] = $item->ID;
                        } elseif (is_numeric($item)) {
                          $actions_ids[] = $item;
                        }
                      }
                    } elseif (is_object($blog_actions_field) && isset($blog_actions_field->ID)) {
                      $actions_ids[] = $blog_actions_field->ID;
                    } elseif (is_numeric($blog_actions_field)) {
                      $actions_ids[] = $blog_actions_field;
                    }

                    if (!empty($actions_ids)) {
                      // Проверяем, существует ли запись с таким ID
                      $post_exists = get_post_status($actions_ids[0]);

                      if ($post_exists) {
                        $args = [
                          'post_type' => 'any', // Временно меняем на 'any' для отладки
                          'post__in' => $actions_ids,
                          'orderby' => 'post__in',
                          'posts_per_page' => -1,
                        ];
                      } else {
                        // Запись не найдена - выводим последние новости
                        $args = [
                          'order' => 'DESC',
                          'orderby' => 'date',
                          'category_name' => 'actions',
                          'posts_per_page' => 5,
                        ];
                      }
                    } else {
                      $args = [
                        'order' => 'DESC',
                        'orderby' => 'date',
                        'category_name' => 'actions',
                        'posts_per_page' => 5,
                      ];
                    }
                  } else {
                    $args = [
                      'order' => 'DESC',
                      'orderby' => 'date',
                      'category_name' => 'actions',
                      'posts_per_page' => 5,
                    ];
                  }

                  $query = new WP_Query($args);

                  // Проверяем, есть ли записи
                  if ($query->have_posts()) {
                    while ($query->have_posts()) {
                      $query->the_post();
                  ?>
                      <article class="single-blog__right-list-item splide__slide">
                        <a class="single-blog__right-list-link line-caps-bold-15-15" href="<?= get_permalink(get_the_ID()); ?>">
                          <div class="single-blog__right-list-img">
                            <?php if (has_post_thumbnail()) : ?>
                              <?php the_post_thumbnail('full'); ?>
                            <?php endif; ?>
                          </div>

                          <span class="single-blog__right-list-name">
                            <?php the_title(); ?>
                          </span>
                        </a>
                      </article>
                      <article class="single-blog__right-list-item splide__slide">
                        <a class="single-blog__right-list-link line-caps-bold-15-15" href="<?= get_permalink(get_the_ID()); ?>">
                          <div class="single-blog__right-list-img">
                            <?php if (has_post_thumbnail()) : ?>
                              <?php the_post_thumbnail('full'); ?>
                            <?php endif; ?>
                          </div>

                          <span class="single-blog__right-list-name">
                            <?php the_title(); ?>
                          </span>
                        </a>
                      </article>
                      <article class="single-blog__right-list-item splide__slide">
                        <a class="single-blog__right-list-link line-caps-bold-15-15" href="<?= get_permalink(get_the_ID()); ?>">
                          <div class="single-blog__right-list-img">
                            <?php if (has_post_thumbnail()) : ?>
                              <?php the_post_thumbnail('full'); ?>
                            <?php endif; ?>
                          </div>

                          <span class="single-blog__right-list-name">
                            <?php the_title(); ?>
                          </span>
                        </a>
                      </article>
                  <?php
                    }
                    wp_reset_postdata();
                  }
                  ?>
                </div>
              </div>

              <div class="splide__bottom">
                <div class="splide__pagination"></div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
      </div>
      </div>
</section>