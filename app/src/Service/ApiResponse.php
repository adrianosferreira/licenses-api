<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse implements ApiResponseInterface {

	private $objToJson;

	public function __construct( ObjectToJsonResponse $objToJson ) {
		$this->objToJson = $objToJson;
	}

	public function send( $message, $data = null, $errors = [], $status = 200 ): Response {
		if ( \is_object( $data ) || \is_array( $data ) ) {
			return $this->objToJson->send( $message, $data, $errors, $status );
		}

		return new JsonResponse( [ 'message' => $message, 'errors' => $errors, 'data' => $data ], $status );
	}
}