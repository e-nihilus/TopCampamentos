<?php
namespace PowerpackElements\Modules\QueryControl\Types;

use PowerpackElements\Modules\QueryControl\Types\Type_Base;

// Elementor Classes
use Elementor\Core\Base\Document;
use Elementor\TemplateLibrary\Source_Local;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * \Modules\QueryControl\Types\Templates_Page
 *
 * @since  1.4.13.4
 */
class Templates_Page extends Type_Base {

	/**
	 * Get Name
	 *
	 * Get the name of the module
	 *
	 * @since  1.4.13.4
	 * @return string
	 */
	public function get_name() {
		return 'templates-page';
	}

	/**
	 * Gets autocomplete values
	 *
	 * @since  1.4.13.4
	 * @return array
	 */
	public function get_autocomplete_values( array $data ) {
		$results = [];

		$document_types = pp_get_elementor()->documents->get_document_types( [
			'show_in_library' => true,
		] );

		$query_params = [
			's'                 => $data['q'],
			'post_type'         => Source_Local::CPT,
			'posts_per_page'    => -1,
			'post_status'       => [ 'publish' ],
			'tax_query'         => [
				[
					'taxonomy'  => Source_Local::TAXONOMY_TYPE_SLUG,
					'field'     => 'slug',
					'terms'     => 'page',
				],
			],
		];

		$query = new \WP_Query( $query_params );

		foreach ( $query->posts as $post ) {
			$document = pp_get_elementor()->documents->get( $post->ID );
			if ( ! $document ) {
				continue;
			}

			$results[] = [
				'id'    => $post->ID,
				'text'  => $post->post_title . ' (' . ucfirst( $document->get_name() ) . ')',
			];
		}

		return $results;
	}

	/**
	 * Gets control values titles
	 *
	 * @since  1.4.13.4
	 * @return array
	 */
	public function get_value_titles( array $request ) {
		$ids = (array) $request['id'];

		$query = new \WP_Query( [
			'post_type'         => Source_Local::CPT,
			'post__in'          => $ids,
			'posts_per_page'    => -1,
		]);

		foreach ( $query->posts as $post ) {
			$document = pp_get_elementor()->documents->get( $post->ID );
			if ( ! $document ) {
				continue;
			}

			$results[ $post->ID ] = $post->post_title . ' (' . $document->get_post_type_title() . ')';
		}

		return $results;
	}
}
