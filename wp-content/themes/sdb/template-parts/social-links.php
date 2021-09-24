<?php $facebook_link = get_option( 'options_mandr_facebook' ); ?>
<?php $twitter_link = get_option( 'options_mandr_twitter' ); ?>
<?php $linkedin_link = get_option( 'options_mandr_linkedin' ); ?>
<?php $instagram_link = get_option( 'options_mandr_instagram' ); ?>
<?php $youtube_link = get_option( 'options_mandr_youtube' ); ?>

<?php if($facebook_link || $twitter_link || $linkedin_link || $instagram_link || $youtube_link ): ?>
	<div class="social-links">
		<?php if( $facebook_link ) : ?>
			<a target="_blank" href="<?= $facebook_link; ?>" class="facebook-link" title="Like us on Facebook!">
				<i class="ikes-facebook" aria-hidden="true"></i>
				<span class="visually-hidden">Open Facebook page in new window</span>
			</a>
		<?php endif; ?>
		<?php if( $twitter_link ) : ?>
			<a target="_blank" href="<?= $twitter_link; ?>" class="twitter-link" title="Follow us on Twtter!">
				<i class="ikes-twitter" aria-hidden="true"></i>
				<span class="visually-hidden">Open Twitter page in new window</span>
			</a>
		<?php endif; ?>
		<?php if( $linkedin_link ) : ?>
			<a target="_blank" href="<?= $linkedin_link; ?>" class="linkedin-link" title="Follow us on LinkedIn!">
				<i class="ikes-linkedin" aria-hidden="true"></i>
				<span class="visually-hidden">Open LinkedIn page in new window</span>
			</a>
		<?php endif; ?>
		<?php if( $instagram_link ) : ?>
			<a target="_blank" href="<?= $instagram_link; ?>" class="instagram-link" title="Follow us on Instagram!">
				<i class="ikes-instagram" aria-hidden="true"></i>
				<span class="visually-hidden">Open Instagram page in new window</span>
			</a>
		<?php endif; ?>
		<?php if( $youtube_link ) : ?>
			<a target="_blank" href="<?= $youtube_link; ?>" class="youtube-link" title="Follow our Youtube channel!">
				<i class="ikes-youtube" aria-hidden="true"></i>
				<span class="visually-hidden">Open Instagram page in new window</span>
			</a>
		<?php endif; ?>
	</div>
<?php endif; ?>