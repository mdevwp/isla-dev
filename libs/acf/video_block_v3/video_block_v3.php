<?php

/****Video Block V3****
*******************
**/

$data = get_field('video_fields'); ?>
<section class="video-section v3">
  <div class="container">
      <div class="video-wrap">
          <div class="heading">
              <?php if (isset($data['title']) && !empty($data['title'])) : ?>
                  <h2><?= $data['title']; ?></h2>
              <?php endif; ?>
              <?php echo (isset($data['description']) && !empty($data['description'])) ? $data['description'] : ''; ?>
              <?php if (isset($data['cta_button']['url']) && isset($data['cta_button']['title']) && !empty($data['cta_button']['title'])) :
                  $target = (isset($data['cta_button']['target']) && !empty($data['cta_button']['target'])) ? 'target="'. $data['cta_button']['target'] .'"' : ''; ?>
                  <div class="video-cta-wrapper">
                      <a href="<?= esc_url($data['cta_button']['url']); ?>" class="btn button find-out-more primary large" <?= $target; ?>><?= esc_html($data['cta_button']['title']); ?></a>
                  </div>
              <?php endif; ?>
          </div>
          <div class="video-content">
              <?php if (isset($data['video_file_1']) && !empty($data['video_file_1']) || isset($data['video_file_2']) && !empty($data['video_file_2'])): ?>
                  <video autoplay loop muted playsinline webkit-playsinline preload="auto" width="100%" height="auto">
                      <?php if (isset($data['video_file_2']) && !empty($data['video_file_2'])) : ?>
                         <source src="<?= $data['video_file_2']; ?>" type="video/webm">
                      <?php endif; ?>
                      <?php if (isset($data['video_file_1']) && !empty($data['video_file_1'])) : ?>
                          <source src="<?= $data['video_file_1']; ?>" type="video/mp4">
                      <?php endif; ?>
                  </video>
              <?php endif; ?>
          </div>
      </div>
  </div>
</section>