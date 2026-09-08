<?php

/****Block Template ****
*******************
**/



$headline = get_field('headline');
$subtitle = get_field('subtitle');

$tabs = get_field('tabs');  

?>




<section class="solution_feature acute_community">

	<div class="container slf">
		
		<h2 id="solution-tabs" class="solutions-description"><?= $subtitle; ?></h2>


			<?php 
				
			
				if(!empty($tabs)){ ?>
				
				<div class="reviews_tabs">
					<div class="content_wrapper">
						<nav class="nav-tabs">
							<?php foreach($tabs as $key=>$item){ 
							
								$tab_id =  mb_strtolower(str_replace(" ", "-", $item['title'])) ?: 'rev_tab' .$key; ?> 
							  
								<button data-id="<?= $tab_id; ?>" class="nav-item <?php if($key==0): ?>active<?php endif; ?>"><?= $item['title']; ?></button>
							<?php } ?>
						</nav>

						
						<?php foreach($tabs as $key=>$item){ 
						
								$tab_id =  mb_strtolower(str_replace(" ", "-", $item['title'])) ?: 'rev_tab' . $key; ?> 
						
							<div id="<?= $tab_id; ?>" class="block_content <?php if($key==0): ?>active<?php endif; ?>">
							
							
							<?php 
							
							$flexible_content = $item['content_blocks'];
							
							$space_above_list = $item['space_above_list'] ?: '';
							$distance_between = $item['distance_between_points'] ?: '';
							
							if( !empty($space_above_list) && !empty($distance_between) ){ ?>
								<style>
								#<?= $tab_id; ?> ul{margin-top:<?= $space_above_list; ?>px!important;}
								#<?= $tab_id; ?> ul li{margin-bottom:<?= $distance_between; ?>px!important;}
								</style>
							<?php }
							
							if( $flexible_content && is_array($flexible_content) ){
							
							    // Loop through rows.
								foreach ( $flexible_content as $block){
									
									$icon = $block['icon'] ?: '';
									if(!empty($icon)){
										$icon_url = $icon["url"];
										$icon_alt = $icon['alt'] ?: '';
										$icon_title = $icon['title'] ?: '';
									}
									$title = $block['title'] ?: '';
									$description = $block['description'] ?: '';
									$image = $block['image'] ?: '';
									
									
									
									if(!empty($image)){
										$image_url = $image["url"];
										$image_alt = $image['alt'] ?: '';
										$image_title = $image['title'] ?: '';
									}

									// Case: text-image layout.
									if( $block['acf_fc_layout'] == 'text-image' ){
												
													
							?>
							
										<div class="main_content txt_img">
											<div class="content_wrapp">
												<div class="txt_column">
												    <div class="icon_title">
														<?php if(!empty($icon)){ ?>
															<img loading="lazy"
																	 src="<?= $icon_url; ?>"
																	 class="icon-image"
																	 alt=""/>
														<?php } ?>
														<h3 class="section__title"><?= $title ;?></h3>
													</div>
													<div class="section_desc">
														<?= $description ;?>
													</div>
												</div>
											
												<?php if(!empty($image)){ ?>
													<div class="img_column">

														<img loading="lazy"
															 src="<?= $image_url; ?>"
															 class="foreground-image"
															 alt=""/>
													</div>
												<?php } ?>
											</div>
										</div>
								
								
								<?php }  ?>
								
								<?php if( $block['acf_fc_layout'] == 'image-text' ){ ?>

								
										<div class="main_content img_txt">
											<div class="content_wrapp">

												<?php if(!empty($image_url)){ ?>
													<div class="img_column">

														<img loading="lazy"
															 src="<?= $image_url; ?>"
															 class="foreground-image"
															 alt="Foreground image illustrating acute care technology"/>
													</div>
												<?php } ?>
												
												<div class="txt_column">
												    <div class="icon_title">
														<?php if(!empty($icon)){ ?>
															<img loading="lazy"
																	 src="<?= $icon_url; ?>"
																	 class="icon-image"
																	 alt=""/>
														<?php } ?>
														<h3 class="section__title"><?= $title ;?></h3>
													</div>
													<div class="section_desc">
														<?= $description ;?>
													</div>
												</div>
											</div>
										</div>
								
								
								
								
								
								
								<?php }
								
								}
							// End loop.
							}
						
						?>
								
								
								
								
								
							</div>
						
						<?php } ?>

					</div>
				</div>

			<?php } ?>



		



	</div>

</section>
		
		
