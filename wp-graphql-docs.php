<?php
/**
 * Plugin Name: WP GraphQL Docs
 * Plugin URI: https://github.com/wp-graphql/wp-graphql-docs
 * Description: Outputs dynamic documentation for the site's WP GraphQL Schema
 * Author: Jason Bahl, Digital First Media
 * Author URI: http://www.wpgraphql.com
 * Version: 0.0.1
 * Text Domain: wp-graphql-docs
 * Domain Path: /languages/
 * Requires at least: 4.5.0
 * Tested up to: 4.5.3
 *
 * @package WPGraphQLDocs
 * @category Core
 * @author Digital First Media, Jason Bahl
 * @version 0.0.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class WPGraphQLDocs
 * @package WPGraphQLDocs
 * @since 0.0.1
 */
class WPGraphQLDocs {

	/**
	 * @var WPGraphQLDocs The one true WPGraphQL
	 * @since 0.0.1
	 */
	private static $instance;

	/**
	 * @return object|WPGraphQLDocs - The one true WPGraphQLDocs
	 * @since 0.0.1
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPGraphQLDocs ) ) {

			self::$instance = new WPGraphQLDocs;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->setup();
			self::$instance->router = new \WPGraphQLDocs\Router();

		}

		return self::$instance;

	}

	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @return void
	 */
	public function __clone() {

		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-graphql-docs' ), '1.6' );

	}

	/**
	 * Disable unserializing of the class.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {

		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wp-graphql-docs' ), '1.6' );

	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @since 0.0.1
	 * @return void
	 */
	public function setup_constants() {

		// Plugin version.
		if ( ! defined( 'WPGRAPHQL_DOCS_VERSION' ) ) {
			define( 'WPGRAPHQL_DOCS_VERSION', '0.0.1' );
		}

		// Plugin Folder Path.
		if ( ! defined( 'WPGRAPHQL_DOCS_PLUGIN_DIR' ) ) {
			define( 'WPGRAPHQL_DOCS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'WPGRAPHQL_DOCS_PLUGIN_URL' ) ) {
			define( 'WPGRAPHQL_DOCS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File.
		if ( ! defined( 'WPGRAPHQL_DOCS_PLUGIN_FILE' ) ) {
			define( 'WPGRAPHQL_DOCS_PLUGIN_FILE', __FILE__ );
		}

	}

	/**
	 * Include required files.
	 *
	 * Uses composer's autoload
	 *
	 * @access private
	 * @since 0.0.1
	 * @return void
	 */
	public function includes() {

		// Autoload Required Classes
		require_once( WPGRAPHQL_DOCS_PLUGIN_DIR . 'vendor/autoload.php');

	}

	/**
	 * setup
	 *
	 * This sets up the RootQueryType for the GraphQL Schema
	 *
	 * @access private
	 * @since 0.0.2
	 * @return void
	 */
	public function setup() {



	}

}

/**
 * // Only instantiate if WPGraphQL has already been instantiated
 * @return object|WPGraphQLDocs
 */
function wp_graphql_docs_init() {
	return \WPGraphQLDocs::instance();
}

// Instantiate the plugin, after themes have loaded so that
// themes have a chance to filter things as well.
add_action( 'graphql_init', 'wp_graphql_docs_init', 10 );