</div>
<footer id="footer" class="footer triple-padding--top" role="contentinfo">
	<div class="footer__primary">
		<div class="container footer__primary__inner">
			<div class="footer-1">
				<img class="footer__logo" src="<?php bloginfo('template_url'); ?>/assets/images/logo.svg" alt="<?php echo bloginfo('name'); ?> logo" />			
				<?php get_template_part( 'template-parts/social-links' ); ?>
				<a href="https://www.trustedchoice.com/sdb-insurance" target="_blank">
					<img class="footer__trusted-choice" src="<?php bloginfo('template_url'); ?>/assets/images/trusted-choice-logo.png" alt="Trusted Choice logo" />			
				</a>
			</div>
			<div class="footer-2">
				<?= get_field('contact_info','options'); ?>
			</div>
			<div class="footer-3">
				<?php 
				wp_nav_menu( array(
					'container'       => 'ul', 
					'menu_class'      => 'footer-menu', 
					'menu_id'         => 'footer-menu',
					'depth'           => 0,
					'theme_location' => 'footer_menu',
					'link_before' => '<span class="link-text">',
					'link_after' => '</span>'
				)); 
				?>
			</div>
		</div>
	</div>
	<div class="footer__bottom">     
		<?= get_field('copyright_info', 'options'); ?>
	</div>
</footer>

<span id="navigation-overlay" class="navigation-overlay" title="Close navigation menu"></span>
<?php wp_footer(); ?>
</body>
</html>