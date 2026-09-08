<?php

/****Block Template ****
 *******************
 **/



$headline = get_field('headline');
$headline_h1 = get_field('headline_h1');
$info_tabs = get_field('info_tabs');


?>



<section id="our-story" class="story-tabs">
	<div class="container">
		<div class="top__wrapp">
			<h1 class="hero-h1">
                <?= $headline_h1; ?>
            </h1>
			<h2 class="headline"><?= $headline; ?></h2>

            <nav class="nav-links">

				<?php if ($info_tabs) { ?>
					<?php foreach ($info_tabs as $key => $tab) { ?>
						<span class="nav-link <?php if ($key == 1) { ?>active<?php } ?>" data-index="<?= $key; ?>"
							data-id="<?php if(!empty($tab['tab_title'])): echo str_replace(' ', '-', $tab['tab_title']); endif; ?>"><?= $tab['tab_title']; ?></span>
					<?php } ?>
				<?php } ?>
			</nav>
		</div>


		<?php if ($info_tabs) { ?>
			<?php foreach ($info_tabs as $key => $tab) {
				$k = $key; ?>

				<div id="<?php if(!empty($tab['tab_title'])): echo str_replace(' ', '-', $tab['tab_title']); endif; ?>"
					class="story-details <?php if ($k == 1) { ?>active<?php } ?>">
					<?php foreach ($tab['tab_content'] as $key => $tab) {

						if ($tab["acf_fc_layout"] == 'text_image'):
							$content = $tab['text'];
							$media = $tab['image'];
							?>

							<div class="details">
								<div class="row">
									<div class="column">
										<?php if ($key == 0) { ?>
											<h2 class="highlighted-box">
												<?php echo $info_tabs[$k]['tab_title']; ?>
											</h2>
										<?php } ?>
                                        <?php if (!empty($content['title'])) : ?>
										    <span class="subtitle"><?= $content['title']; ?></span>
                                        <?php endif; ?>
										<p class="text-block"><?= $content['text']; ?></p>
									</div>
									<div class="column">
										<?php if(!empty($media['title'])){ ?>
											<span class="tag"><?= $media['title']; ?></span>
										<?php } ?>
										<img src="<?= $media['image']['url']; ?>" alt="" />
									</div>
								</div>
							</div>

						<?php endif; ?>

						<?php if ($tab["acf_fc_layout"] == 'image_text'):
							$content = $tab['text'];
							$media = $tab['image'];
							?>
							<div class="details">
								<div class="row">
									<div class="column">
										<img src="<?= $media['image']['url']; ?>" alt="" class="img-2" />
									</div>
									<div class="column">
										<p class="text-block"><?= $content['text']; ?></p>
									</div>
								</div>
							</div>

						<?php endif; ?>

						<?php if ($tab["acf_fc_layout"] == 'text_video'):
							$content = $tab['text'];
							$media = $tab['video'];
							?>

							<div class="details">
								<div class="row">
									<div class="column">
										<?php if ($key == 0) { ?>
											<h2 class="highlighted-box">
												<?php echo $info_tabs[$k]['tab_title']; ?>
											</h2>
										<?php } ?>
                                        <?php if (!empty($content['title'])) : ?>
										    <span class="subtitle"><?= $content['title']; ?></span>
                                        <?php endif; ?>
										<p class="text-block"><?= $content['text']; ?></p>
									</div>


									<div class="video column">
										<?php if(!empty($media['title'])){ ?>
											<span class="tag"><?= $media['title']; ?></span>
										<?php } ?>
										<img src="<?= $media['prev_image']['url']; ?>" alt="video image"
											class="video__preloader video-image" data-video="<?= $media['video_url'] ?>" />
										<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/Button.png" alt="preview icon"
											class="prev-icon" />
										<div class="video__element">
										
										<?php 
											if(!empty($media['video_file'])){ ?>
												<video class="myVideo" controls>
													<source src="<?= $media['video_file']; ?>" type="video/mp4">
												</video>
											<?php }else{ ?>
												<iframe src="https://www.youtube.com/embed/***?rel=0&amp;showinfo=0" width="300"
													height="150" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
											<?php } ?>		
												
										</div>
									</div>

								</div>
							</div>

						<?php endif; ?>



					<?php } ?>

				</div>

			<?php } ?>
		<?php } ?>




	</div>
</section>