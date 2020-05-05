<?php
/**
 * Registration for post related commponents.
 *
 * @package WP_Irving
 */

namespace WP_Irving\Components;

/**
 * Get the post title.
 *
 * @param array $component Component
 * @return string
 */
register_component(
	'post/title',
	[
		'callback' => function( $component ) {

			// Use the data provider, or fallback to global.
			$post_id = $component['data_provider']['postId'] ?? get_the_ID();

			$title = get_the_title( $post_id );

			if ( ! empty( $title ) ) {
				return html_entity_decode( $title );
			}

			return __( 'Error: no global post context found', 'wp-irving' );
		},
		'data_provider' => [
			'postId' => [
				'type' => 'integer',
			],
		],
	]
);

/**
 * Post content.
 *
 * @todo Reference the Gutenberg Content component in wp-components to
 *       determine some better logic around this process.
 *
 * @param array $component['data_provider']['postId'] Post ID, defaults to global.
 * @return array
 */
register_component(
	'post/content',
	[
		'callback' => function( $component ) {

			// Use the data provider, or fallback to global.
			$post_id               = $component['data_provider']['postId'] ?? get_the_ID();
			$post                  = get_post( $post_id );
			$component['children'] = \WP_Irving\Templates\convert_blocks_to_components( parse_blocks( $post->post_content ) );

			// Ensure the data provider executes on these new children.
			$component = \WP_Irving\Templates\handle_data_provider( $component );

			// Placeholders. Replace with a better FE component.
			$component['name']                = 'irving/container';
			$component['config']['themeName'] = 'fullBleed';

			return $component;
		},
		'data_provider' => [
			'postId' => [
				'type' => 'integer',
			],
		],
	]
);

/**
 * Post permalink.
 *
 * @todo Figure out a better way of doing this. Right now we're just mapping to
 *       a material UI link component.
 *
 * @param array $component['data_provider']['postId'] Post ID, defaults to global.
 * @return array
 */
register_component(
	'post/permalink',
	[
		'callback' => function( $component ) {

			// Use the data provider, or fallback to global.
			$post_id                     = $component['data_provider']['postId'] ?? get_the_ID();
			$component['config']['href'] = get_the_permalink( $post_id );
			$component['name']           = 'material/link';
			return $component;
		},
		'data_provider' => [
			'postId' => [
				'type' => 'integer',
			],
		],
	]
);

/**
 * Post excerpt.
 *
 * @param array $component['data_provider']['postId'] Post ID, defaults to global.
 * @return string
 */
register_component(
	'post/excerpt',
	[
		'callback' => function( $component ) {
			$post_id = $component['data_provider']['postId'] ?? get_the_ID();

			return esc_html( get_the_excerpt( $post_id ) );
		},
	]
);

/**
 * Post tags.
 *
 * Loop through the tags for a given post and set as child HTML components.
 *
 * @param array $component['data_provider']['postId'] Post ID, defaults to global.
 * @return array
 */
register_component(
	'post/tags',
	[
		'callback' => function( $component ) {

			// Use the data provider, or fallback to global.
			$post_id = $component['data_provider']['postId'] ?? get_the_ID();

			$tags = get_the_tags( $post_id );

			if ( ! is_array( $tags ) || empty( $tags ) ) {
				$component['name'] = '';
				return $component;
			}

			$component['children'] = array_map(
				function( $term ) {
					return [
						'name'     => 'irving/html',
						'config' => [
							'content' => sprintf(
								'<a href="%2$s">%1$s</a>',
								$term->name,
								get_term_link( $term )
							),
						],
					];
				},
				$tags
			);

			$component['name'] = '';

			return $component;
		},
		'data_provider' => [
			'postId' => [
				'type' => 'integer',
			],
		],
	]
);

/**
 * Get the post byline.
 *
 * @param array $component Component
 * @return string
 */
register_component(
	'post/byline',
	[
		'callback' => function( $component ) {

			$post_id = $component['data_provider']['postId'] ?? get_the_ID();

			$component['name'] = 'html';
			$component['config']['content'] = get_the_author_meta( 'user_nicename', get_post( $post_id )->post_author );

			return $component;
		},
		'data_provider' => [
			'postId' => [
				'type' => 'integer',
			],
		],
	]
);

/**
 * Get the post social sharing.
 *
 * @param array $component Component
 * @return string
 */
register_component(
	'post/social-sharing',
	[
		'callback' => function( $component ) {
			$post_id = $component['data_provider']['postId'] ?? get_the_ID();

			$component['name'] = 'html';
			$component['config']['content'] = 'Share post';

			return $component;
		},
		'data_provider' => [
			'postId' => [
				'type' => 'integer',
			],
		],
	]
);

/**
 * Get the post social sharing.
 *
 * @param array $component Component
 * @return string
 */
register_component(
	'post/next-post',
	[
		'callback' => function( $component ) {
			the_post();
			$component['name'] = '';
			return $component;
		},
		'data_provider' => [
			'postId' => [
				'type' => 'integer',
			],
		],
	]
);
