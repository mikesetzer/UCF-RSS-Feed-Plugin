<?php

if ( !function_exists( 'ucf_rss_display_thumbnail_before' ) ) {

	function ucf_rss_display_thumbnail_before( $items, $args ) {
		ob_start();
	?>
		<div class="ucf-rss-feed ucf-rss-feed-thumbnail">
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_rss_display_thumbnail_before', 'ucf_rss_display_thumbnail_before', 10, 2 );

}

if ( !function_exists( 'ucf_rss_display_thumbnail_title' ) ) {

	function ucf_rss_display_thumbnail_title( $items, $args ) {
		$formatted_title = '';

		if ( $args['list_title'] ) {
			$formatted_title = '<h2 class="ucf-rss-title">' . $args['list_title'] . '</h2>';
		}

		echo $formatted_title;
	}

	add_action( 'ucf_rss_display_thumbnail_title', 'ucf_rss_display_thumbnail_title', 10, 2 );

}

if ( !function_exists( 'ucf_rss_display_thumbnail' ) ) {

	function ucf_rss_display_thumbnail( $items, $args ) {
		if ( ! is_array( $items ) && $items !== false ) { $items = array( $items ); }
		ob_start();
	?>
		<?php if ( $items ): ?>
		<ul class="ucf-rss-items">
			<?php
			foreach ( $items as $item ):
				$thumbnail = UCF_RSS_Common::get_simplepie_thumbnail_or_fallback( $item );
				$url       = esc_url( $item->get_permalink() );
				$title     = wptexturize( sanitize_text_field( $item->get_title() ) );
				// Try to remove "continue"/"more" links at the end of
				// the description
				$desc      = preg_replace( '/<a [^>]+>(Continue Reading|Read more).*?<\/a>/i', '', trim( $item->get_description() ) );
				$desc_formatted = wp_trim_words( wptexturize( strip_shortcodes( strip_tags( $desc, '<p><a><br>' ) ) ), 55, '&hellip;' );
			?>
			<li class="ucf-rss-item">
				<article class="ucf-rss-item-article">
					<div class="ucf-rss-item-details">
						<?php if ( $thumbnail ): ?>
						<a class="ucf-rss-item-link" href="<?php echo $url; ?>" tabindex="-1">
							<img class="ucf-rss-item-thumbnail" src="<?php echo $thumbnail; ?>" alt="">
						</a>
						<?php endif; ?>
						<div class="ucf-rss-item-pubdate">
							<?php echo $item->get_date( 'M j' ); ?>
						</div>
					</div>
					<div class="ucf-rss-item-body">
						<h3 class="ucf-rss-item-title">
							<a class="ucf-rss-item-link" href="<?php echo $url; ?>"
							title="<?php echo $item->get_date( 'j F Y | g:i a' ); ?>">
								<?php echo $title; ?>
							</a>
						</h3>
						<?php if ( $desc ): ?>
						<div class="ucf-rss-item-description">
							<?php echo $desc_formatted; ?>
							<a href="<?php echo $url; ?>" class="ucf-rss-item-link ucf-rss-item-continue">Continue reading &rsaquo;</a>
						</div>
						<?php endif; ?>
					</div>
				</article>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php else: ?>
		<div class="ucf-rss-feed-error">No results found.</div>
		<?php endif; ?>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_rss_display_thumbnail', 'ucf_rss_display_thumbnail', 10, 2 );

}

if ( !function_exists( 'ucf_rss_display_thumbnail_after' ) ) {

	function ucf_rss_display_thumbnail_after( $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		echo ob_get_clean();
	}

	add_action( 'ucf_rss_display_thumbnail_after', 'ucf_rss_display_thumbnail_after', 10, 2 );

}
