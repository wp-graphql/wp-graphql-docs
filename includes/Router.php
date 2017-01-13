<?php
namespace WPGraphQLDocs;

/**
 * Class Router
 *
 * This sets up the /graphql-docs endpoint
 *
 * @package WPGraphQLDocs
 * @since 0.0.1
 */
class Router {

	/**
	 * route
	 *
	 * Sets the route to use as the endpoint
	 *
	 * @var string
	 */
	public $route = 'graphql-docs';

	/**
	 * Router constructor.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function __construct() {

		/**
		 * Pass the route through a filter in case the endpoint /graphql-docs should need to be changed
		 *
		 * @since 0.0.1
		 */
		$this->route = apply_filters( 'graphql_docs_endpoint', $this->route );

		/**
		 * Create the rewrite rule for the route
		 *
		 * @since 0.0.1
		 */
		add_action( 'init', array( $this, 'add_rewrite_rule' ), 10 );

		/**
		 * Add the query var for the route
		 *
		 * @since 0.0.1
		 */
		add_filter( 'query_vars', array( $this, 'add_query_var' ), 10, 1 );

		/**
		 * Overrides the template to use the Docs
		 *
		 * @since 0.0.1
		 */
		add_action( 'template_include', array( $this, 'override_template' ), 10 );

	}

	/**
	 * Adds rewrite rule for the route endpoint
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function add_rewrite_rule() {

		add_rewrite_rule(
			$this->route . '/?$',
			'index.php?' . $this->route . '=true',
			'top'
		);

	}

	/**
	 * Adds the query_var for the route
	 *
	 * @since 0.0.1
	 * @param $query_vars
	 * @return array
	 */
	public function add_query_var( $query_vars ) {

		$query_vars[] = $this->route;
		return $query_vars;

	}

	/**
	 * override_template
	 *
	 * This overrides the template if the url matches $this->route (graphql-docs, or filtered value)
	 *
	 * @since 0.0.1
	 */
	public function override_template() {

		/**
		 * Access the $wp_query object
		 */
		global $wp_query;

		/**
		 * Ensure we're on the registered route for graphql-docs route
		 */
		if ( ! $wp_query->get( $this->route ) ) {
			return;
		}

		/**
		 * Set is_home to false
		 */
		$wp_query->is_home = false;

		/**
		 * Render the page
		 */
		return $this->render();

	}

	/**
	 * This renders the page
	 *
	 * @since 0.0.1
	 * @access public
	 * @return mixed
	 */
	public function render() {
		?>
		<html>
		<head>
		</head>
		<body>
			<div id="app"></div>
			<script src="<?php echo WPGRAPHQL_DOCS_PLUGIN_URL . 'client/dist/vendor.js'; ?>" ></script>
			<script src="<?php echo WPGRAPHQL_DOCS_PLUGIN_URL . 'client/dist/bundle.js'; ?>" ></script>
		</body>
		</html>
		<?php

	}

}