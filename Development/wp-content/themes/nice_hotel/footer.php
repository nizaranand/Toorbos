					<?php 
						// Fetch options stored in $data
						global $data; 
					?>
	
					<!-- BEGIN #footer -->
					<div id="footer">
		
						<div class="clearfix">
							<div class="two-forths">
								<?php dynamic_sidebar( 'footer-widget-area-one' ); ?>
							</div>
							<div class="one-forth">
								<?php dynamic_sidebar( 'footer-widget-area-two' ); ?>
							</div>
							<div class="one-forth last-col">
								<?php dynamic_sidebar( 'footer-widget-area-three' ); ?>
							</div>
						</div>
		
					<!-- END #footer -->
					</div>
	
					<!-- BEGIN #footer-bottom -->
					<div id="footer-bottom" class="clearfix">
	
						<p class="fl">
							<?php // Display footer message
								if ( $data['footer_msg'] ) :
									_e($data['footer_msg'],'qns');
								else :
									_e('&copy; Copyright 2012','qns');
								endif;
							?>
						</p>	
				
						<?php if ( has_nav_menu( 'footer' ) ) { ?>
				
							<!-- Secondary Menu -->
							<?php wp_nav_menu( array(
								'theme_location' => 'footer',
								'container' =>false,
								'items_wrap' => '<ul class="footer-menu fr">%3$s</ul>',
								'echo' => true,
								'before' => '',
								'after' => '<span>/</span>',
								'link_before' => '',
								'link_after' => '',
								'depth' => 0 )
							); ?>
				
						<?php } ?>
	
					<!-- END #footer-bottom -->
					</div>
			
				<!-- END .content-body -->
				</div>
	
			<!-- END .content-wrapper -->
			</div>

		<!-- END .background-wrapper -->
		</div>

	<?php wp_footer(); ?>

	<!-- END body -->
	</body>
</html>