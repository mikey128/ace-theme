<?php
/**
 * Register Block Patterns
 *
 * @package AceTheme
 */

function ace_register_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern_category(
		'ace-custom',
		array( 'label' => __( 'Ace Custom', 'ace-theme' ) )
	);

	register_block_pattern(
		'ace-theme/custom-video',
		array(
			'title'       => __( 'Custom Video', 'ace-theme' ),
			'description' => _x( 'A custom Custom Video with rounded corners and play button.', 'Block pattern description', 'ace-theme' ),
			'categories'  => array( 'ace-custom' ),
			'content'     => '<!-- wp:carbon-fields/custom-video /-->',
		)
	);
}
add_action( 'init', 'ace_register_patterns' );