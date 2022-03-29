<?php

namespace Gravity_Flow\Gravity_Flow\Ajax;

use Gravity_Forms\Gravity_Forms\GF_Service_Provider;
use Gravity_Forms\Gravity_Forms\GF_Service_Container;

class Ajax_Service_Provider extends GF_Service_Provider {

	const STRATEGY         = 'ajax_response_strategy';
	const RESPONSE_FACTORY = 'ajax_response_factory';

	public function register( GF_Service_Container $container ) {
		$container->add( self::STRATEGY, function() {
			return new WP_Ajax_Return_Strategy();
		} );

		$container->add( self::RESPONSE_FACTORY, function() use ( $container ) {
			return new Response_Factory( $container->get( self::STRATEGY ) );
		} );
	}

}