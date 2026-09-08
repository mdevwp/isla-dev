<?php

/****Block Template ****
*******************
**/


$tab_blocks = get_field('tab_blocks');


?>


<?php if( !empty($tab_blocks) ){ ?>

        <section class="acute_community">

            <div id="referrals"  class="container">

                <div class="tab-container">
				
				<?php foreach($tab_blocks as $key=>$tab){ 
				
					 $tab_id =  mb_strtolower(str_replace(" ", "-", $tab['tab_title'])) ?: 'tab' .$key_tab; 
				?>
				
                    <div class="tab">
                        <h2 data-id="<?= $tab_id; ?>" class="nav__item tab-title <?php if($key==0): ?>active<?php endif; ?>"><?= $tab['tab_title']; ?></h2>
                    </div>
					
				<?php } ?>
                </div>


				<?php foreach($tab_blocks as $key=>$tab){ 
				
						$key_tab = $key;
						$tab_id =  mb_strtolower(str_replace(" ", "-", $tab['tab_title'])) ?: 'tab' .$key_tab;
						
						
				?>

                <div id="<?= $tab_id; ?>" class="tab_block <?php if($key==0): ?>active<?php endif; ?>">

                    <div class="top_wrapp">

                        <div class="main_content">
                            <div class="content_wrapp">
                                <div class="txt_column">
                                    <h3 class="section__title"><?= $tab['subtitle'] ;?></h3>
                                    <p class="section_desc">
                                        <?= $tab['description'] ;?>
                                    </p>
                                </div>
								
								<?php 
								
								$image = $tab['image'];
								if(!empty($image)){
									$image_url = $image["url"];
									$image_alt = $image['alt'] ?: '';
									$image_title = $image['title'] ?: '';
								}
								
								$video_file = $tab['video_file'];
								?>
								
								
								<?php if(!empty($video_file)){ ?>
								
								<div class="video img_column">
									<?php if(!empty($image)){ ?>
										<img src="<?= esc_url($image_url); ?>" class="video__preloader video-image" alt="<?= esc_attr($image_alt); ?>" title="<?= esc_attr($image_title); ?>" <?php if($videoId): ?> data-video="<?= $videoId; ?>" <?php endif; ?>/>
										<img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/Button.png?v2" alt="preview icon" class="prev-icon" />
									<?php } ?>
									
								  <div class="video__element">
								  
										<video class="myVideo" controls>
											<source src="<?= $video_file; ?>" type="video/mp4">
										</video>
									
								  </div>
								</div>
		
								<?php }else{  ?>
		
		
									<?php if(!empty($image_url)){ ?>
										<div class="img_column">

											<img loading="lazy"
												 src="<?= $image_url; ?>"
												 class="foreground-image"
												 alt="Foreground image illustrating acute care technology"/>
										</div>
									<?php } ?>
								
								
								<?php } ?>
								
                            </div>
                        </div>

						<?php
							
							$dev_boxes = $tab['dev_boxes'];
						?>
							<div class="stats-section">
								<div class="stats-container count_up">
								
								<?php if(!empty($dev_boxes)){ ?>
									<?php foreach($dev_boxes as $item){ ?>
									
									<div class="stat_card">
										<p class="stat-value">
											<span class="num"><?= $item['value']; ?></span><?= $item['symbol']; ?>
										</p>
										<p class="stat-description"><?= $item['description']; ?></p>
									</div>
									
									<?php } ?>
								<?php } ?>

								</div>
							</div>
							
						


                    </div>


					<?php 
						$review_categories = $tab['review_categories'];
					
						if(!empty($review_categories)){ ?>
						
						<div class="reviews_tabs">
							<div class="content_wrapper">
								<nav class="nav-tabs">
									<?php foreach($review_categories as $key=>$item){ ?> 
										<h2 data-id="rev_tab<?= $key . $key_tab; ?>" class="nav-item <?php if($key==0): ?>active<?php endif; ?>"><?= $item['title']; ?></h2>
									<?php } ?>
								</nav>

								
								<?php foreach($review_categories as $key=>$item){ ?>
								
									<div id="rev_tab<?= $key . $key_tab; ?>" class="block_content <?php if($key==0): ?>active<?php endif; ?>">
										<div class="content-columns">
											<div class="left-column">
												<div class="info-card">
													<div class="info-content">
														<div class="info-text">
															<p class="info-description">
																<?= $item['description']; ?>
															</p>
														</div>
														<div class="stats-column">
															<div class="stats-wrapper">
															<?php if(!empty($item['dev_boxes'])){ ?>
																<?php foreach($item['dev_boxes'] as $box){ ?>
																	<div class="stats_card new">
																		<p class="stat-number"><span class="num"><?= $box['value']; ?></span><?= $box['symbol']; ?></p>
																		<p class="stat_desc"><?= $box['description']; ?></p>
																	</div>
																<?php } ?>
															<?php } ?>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<div class="right-column">
											
												<?php 
												
												$tst_id = $item['testimonial_case'];
												
												$thumbnail_url = get_the_post_thumbnail_url( $tst_id );

												$thumbnail_id = get_post_thumbnail_id( $tst_id ); 
												if ( $thumbnail_id ) {
													$thumbnail_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
													$thumbnail_title = isset( get_post($thumbnail_id)->post_title ) ? get_post($thumbnail_id)->post_title : '';
												}
												$post_excerpt = get_the_excerpt($tst_id)?: get_the_content($tst_id);
												$customer_info = get_field('customer_info', $tst_id);
												$case_link = get_field('case_link', $tst_id);
												$large_icon = get_field('large_icon', $tst_id);

												
												if($case_link){ 
													$case_url = $case_link['url'];
													$case_title = $case_link['title'];
													$case_target = $case_link['target'] ?: '_self';
												} 
												
												
												?>
												<div class="testimonial-card <?php if($large_icon): ?>large_icon<?php endif; ?>">
													<?php if(!empty($thumbnail_url)){ ?>
														<img src="<?= $thumbnail_url; ?>"
														 alt="<?= $thumbnail_alt; ?>" class="testimonial-image"/>
													<?php } ?>
													<blockquote class="testimonial-text">
														<?= $post_excerpt; ?>
													</blockquote>
													<div>
														<span class="testimonial-author"><?= get_the_title($tst_id); ?></span>
														<p class="testimonial-position">
															<?= $customer_info; ?>
														</p>
													</div>
												</div>
											</div>
											
										</div>
									</div>
								
								<?php } ?>

							</div>
						</div>

					<?php } ?>


					<?php

						$text_block = $tab['text_block'];
						$subtitle = $text_block['subtitle'];
						$description = $text_block['description'];
						$btn = $text_block['cta_button_1'];
						$btn2 = $text_block['cta_button_2'];
						$use_popup = $text_block['use_popup'];
						
						if($btn){ 
							$btn_url = $btn['url'];
							$btn_title = $btn['title'];
							$btn_target = $btn['target'] ?: '_self';
						} 
						if($btn2){ 
							$btn2_url = $btn2['url'];
							$btn2_title = $btn2['title'];
							$btn2_target = $btn['target'] ?: '_self';
						} 

					?>

                    <div class="acute-care-container">

                        <div class="content_wrapper">
                            <div class="two-column-layout">
                                <div class="left-column">
                                    <div class="text__content">
                                        <h2 class="main_heading"><?= $subtitle; ?></h2>
                                        <p class="desc">
                                            <?= $description; ?>
                                        </p>

                                        <div class="cta-button-wrapper">
										<?php if(!empty($btn)){ ?>
										  <a <?php if(!$use_popup): ?>href="<?= esc_url($btn_url); ?>"<?php endif; ?> class="btn cta-button <?php if($use_popup): ?>book-demo-btn<?php endif; ?>" <?php if(!empty($link_target)): ?>target="<?= esc_attr($link_target); ?>"<?php endif; ?>><?= esc_html($btn_title); ?></a>
										<?php } ?>
										
										<?php if(!empty($btn2)){ ?>
										  <a href="<?= esc_url($btn2_url); ?>" class="btn how-it-works-btn" target="<?= esc_attr($btn2_target); ?>"><?= esc_html($btn2_title); ?></a>
										<?php } ?>
		
                                          
                                        </div>

                                    </div>
                                </div>
													
								
								<?php 
								
									$question_answer = $tab['question_answer'];
									if($question_answer){ ?>
									
										<div class="faq-column">
											<div class="question-list">

											<?php foreach ($question_answer as $item){ ?>
												<hr class="divider"/>
												<div class="question-item">
													<p class="question-text"><?= $item['question']; ?></p>
													<img loading="lazy"
														 src="https://cdn.builder.io/api/v1/image/assets/TEMP/d211905736f3aadda13467b32e3d551deb56cb6af12999c8624e9e97bda166f7?apiKey=0397a1af16b741b0acbdb8238571140b&"
														 class="arrow-icon" alt=""/>
												</div>
												<div class="answer">
													<p><?= $item['answer']; ?></p>
												</div>
											<?php } ?>


												<hr class="divider"/>
											</div>
										</div>
								
								<?php } ?>
                            </div>
                        </div>
                    </div>


                </div>
				
				<?php } ?>


            </div>

		</section>
		
		
<?php } ?>