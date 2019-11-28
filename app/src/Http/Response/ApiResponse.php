<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse {

	private $objToJson;

	public function __construct( ObjectToJsonResponse $objToJson ) {
		$this->objToJson = $objToJson;
	}

	public function success( $message ): JsonResponse {
		return new JsonResponse(
			[
				'message' => $message
			],
			200
		);
	}

	public function notFound( $code, $message, $description ): JsonResponse {
		return new JsonResponse(
			[
				'code' => $code,
				'message' => $message,
				'description' => $description
			],
			404 );
	}

	public function notValidated( array $errors, $message, $code ): JsonResponse {
		$errorsFormated = array_map( function( $error ) {
			$key = array_key_first( $error );
			return [
				'field' => $key,
				'message' => $error[ $key ],
			];
		}, $errors );

		return new JsonResponse(
			[
				'code' => $code,
				'message' => $message,
				'errors' => $errorsFormated,
			],
			422
		);
	}

	public function send( $message, $data = null, $errors = [], $status = 200 ): Response {
		if ( \is_object( $data ) || \is_array( $data ) ) {
			return $this->objToJson->send( $message, $data, $errors, $status );
		}

		return new JsonResponse(
			[
				'message' => $message,
				'errors' => $errors,
				'data' => $data
			],
			$status
		);
	}
}