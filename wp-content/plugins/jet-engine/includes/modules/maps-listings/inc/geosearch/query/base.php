<?php
namespace Jet_Engine\Modules\Maps_Listings\Geosearch\Query;

use \Jet_Engine\Modules\Maps_Listings\Map_Field;

class Base {

	public $query_type    = null;
	public $distance_term = 'geo_query_distance';

	public $lat_field = 'geo_query_lat.meta_value';
	public $lng_field = 'geo_query_lng.meta_value';

	public function __construct() {
		add_filter( 'jet-engine/query-builder/query/after-query-setup', array( $this, 'prepare_query_args' ), 0 );
	}

	public function prepare_query_args( $query ) {

		if ( $this->query_type !== $query->query_type ) {
			return;
		}

		if ( ! empty( $query->final_query['geosearch_location'] ) && ! empty( $query->final_query['geosearch_field'] ) ) {

			$field  = $query->final_query['geosearch_field'];
			$fields = explode( ',', $field );

			if ( 2 === count( $fields ) ) {
				$lat_field = trim( $fields[0] );
				$lng_field = trim( $fields[1] );
			} else {
				$lat_field = Map_Field::get_field_prefix( $field ) . '_lat';
				$lng_field = Map_Field::get_field_prefix( $field ) . '_lng';
			}
			
			$units    = ! empty( $query->final_query['geosearch_units'] ) ? $query->final_query['geosearch_units'] : 'miles';
			$distance = ! empty( $query->final_query['geosearch_distance'] ) ? $query->final_query['geosearch_distance'] : 10;

			if ( ! is_array( $query->final_query['geosearch_location'] ) ) {
				$coords = $query->final_query['geosearch_location'];
				$coords = is_scalar( $coords ) ? ( string ) $coords : '';
				$coords = explode( ',', $coords );

				if ( count( $coords ) < 2 ) {
					//if coordinates received are incomplete - set such center and distance as to prevent showing wrong results
					$query->final_query['geosearch_location'] = array(
						'lat' => -89.87654321,
						'lng' => 1.23456789,
					);

					$distance = 0;
				} else {
					$query->final_query['geosearch_location'] = array(
						'lat' => ( float ) $coords[0],
						'lng' => ( float ) $coords[1],
					);
				}
			}
			
			$query->final_query['geo_query'] = array(
				'raw_field' => $field,
				'latitude'  => $query->final_query['geosearch_location']['lat'],
				'longitude' => $query->final_query['geosearch_location']['lng'],
				'lat_field' => $lat_field,  // this is the name of the meta field storing latitude
				'lng_field' => $lng_field, // this is the name of the meta field storing longitude
				'distance'  => $distance,
				'units'     => $units,
			);

			unset( $query->final_query['geosearch_location'] );
			unset( $query->final_query['geosearch_field'] );

			if ( ! empty( $query->final_query['geosearch_units'] ) ) {
				unset( $query->final_query['geosearch_units'] );
			}

			if ( ! empty( $query->final_query['geosearch_distance'] ) ) {
				unset( $query->final_query['geosearch_distance'] );
			}

		}

	}

	/**
	 * Get lat field from the geo query (optionally - in select fields or query fields format)
	 *
	 * @param  [type] $geo_query [description]
	 * @param  string $format    [description]
	 * @return [type]            [description]
	 */
	public function lat_field( $geo_query, $format = 'field' ) {
		switch ( $format ) {
			case 'field':
				return $this->lat_field;

			case 'query':
				$lat_field = 'latitude';
				if ( ! empty( $geo_query['lat_field'] ) ) {
					$lat_field =  $geo_query['lat_field'];
				}
				return $lat_field;
		}
	}

	/**
	 * Get lng field from the geo query (optionally - in select fields or query fields format)
	 *
	 * @param  [type] $geo_query [description]
	 * @param  string $format    [description]
	 * @return [type]            [description]
	 */
	public function lng_field( $geo_query, $format = 'field' ) {
		switch ( $format ) {
			case 'field':
				return $this->lng_field;

			case 'query':
				$lng_field = 'longitude';
				if ( ! empty( $geo_query['lng_field'] ) ) {
					$lng_field =  $geo_query['lng_field'];
				}
				return $lng_field;
		}
	}

	public function haversine_term( $geo_query ) {

		global $wpdb;
		$units = "miles";
		
		if ( !empty( $geo_query['units'] ) ) {
			$units = strtolower( $geo_query['units'] );
		}

		$radius = 3959;
		
		if ( in_array( $units, array( 'km', 'kilometers' ) ) ) {
			$radius = 6371;
		}

		$lat_field = $this->lat_field( $geo_query, 'field' );
		$lng_field = $this->lng_field( $geo_query, 'field' );
		$lat = 0;
		$lng = 0;

		if ( isset( $geo_query['latitude'] ) ) {
			$lat = $geo_query['latitude' ];
		}

		if ( isset( $geo_query['longitude'] ) ) {
			$lng = $geo_query['longitude'];
		}

		$haversine  = "( " . $radius . " * ";
		$haversine .=     "acos( cos( radians(%f) ) * cos( radians( " . $lat_field . " ) ) * ";
		$haversine .=     "cos( radians( " . $lng_field . " ) - radians(%f) ) + ";
		$haversine .=     "sin( radians(%f) ) * sin( radians( " . $lat_field . " ) ) ) ";
		$haversine .= ")";
		$haversine  = $wpdb->prepare( $haversine, array( $lat, $lng, $lat ) );
		
		return $haversine;
	}
}
