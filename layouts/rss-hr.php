<?php

if ( !function_exists( 'ucf_rss_display_hr_before' ) ) {

	function ucf_rss_display_hr_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="ucf-rss-feed ucf-rss-feed-hr">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_rss_display_hr_before', 'ucf_rss_display_hr_before', 10, 3 );

}

if ( !function_exists( 'ucf_rss_display_hr_title' ) ) {

	function ucf_rss_display_hr_title( $content, $items, $args ) {
		$formatted_title = '';

		if ( $args['list_title'] ) {
			$formatted_title = '<h2 class="ucf-rss-title">' . $args['list_title'] . '</h2>';
		}

		return $formatted_title;
	}

	add_filter( 'ucf_rss_display_hr_title', 'ucf_rss_display_hr_title', 10, 3 );

}

if ( !function_exists( 'ucf_rss_display_hr' ) ) {

	function ucf_rss_display_hr( $content, $items, $args ) {
		if ( ! is_array( $items ) && $items !== false ) { $items = array( $items ); }
		ob_start();
	?>
		<?php if ( $items ): ?>
		<ul class="ucf-rss-items">
			<?php foreach ( $items as $item ): ?>
			<li class="ucf-rss-item">
				<a class="ucf-rss-item-link" href="<?php echo UCF_RSS_Common::get_simplepie_url( $item ); ?>"
                    title="<?php echo $item->get_date( 'j F Y | g:i a' ); ?>">
                    <?php echo UCF_RSS_Common::get_simplepie_title( $item ); ?>
                </a>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php else: ?>
		<div class="ucf-rss-feed-error">No results found.</div>
		<?php endif; ?>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_rss_display_hr', 'ucf_rss_display_hr', 10, 3 );

}

if ( !function_exists( 'ucf_rss_display_hr_after' ) ) {

	function ucf_rss_display_hr_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_rss_display_hr_after', 'ucf_rss_display_hr_after', 10, 3 );

}
