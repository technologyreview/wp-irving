<?php
/**
 * Class file for the Social Item component.
 *
 * @package WP_Irving
 */

namespace WP_Irving\Component;

/**
 * Defines the Social Item component.
 */
class Social_Links extends Component {

	use \WP_Irving\Social;

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $name = 'social-links';

	/**
	 * Component constructor.
	 *
	 * @param string $name     Unique component slug or array of name, config,
	 *                         and children value.
	 * @param array  $config   Component config.
	 * @param array  $children Component children.
	 */
	public function __construct( $name = '', array $config = [], array $children = [] ) {
		parent::__construct( $name, $config, $children );

		self::add_services( [
			'facebook'  => __( 'Facebook', 'wp-irving' ),
			'twitter'   => __( 'Twitter', 'wp-irving' ),
			'linkedin'  => __( 'LinkedIn', 'wp-irving' ),
			'pinterest' => __( 'Pinterest', 'wp-irving' ),
			'whatsapp'  => __( 'WhatsApp', 'wp-irving' ),
		] );
	}
}
