<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ObjectToJsonResponse {

	private $serializer;

	public function __construct( SerializerInterface $serializer ) {
		$this->serializer = $serializer;
	}

	public function send( $message, $data, $errors = [], $status = 200 ): Response {
		return new Response( $this->serializer->serialize(
			[ 'message' => $message, 'data' => $data, 'errors' => $errors ],
			'json',
			[
				'circular_reference_handler' => function ($object) {
					return $object->getId();
				}
			] ), $status );
	}
}