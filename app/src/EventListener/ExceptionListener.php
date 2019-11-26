<?php

namespace App\EventListener;

use App\Http\ApiResponse;
use App\Service\ApiResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener {

	private $response;

	public function __construct( ApiResponseInterface $response ) {
		$this->response = $response;
	}

	public function onKernelException( ExceptionEvent $event ) {
		$exception = $event->getThrowable();
		$statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
		$event->setResponse( $this->response->send( $exception->getMessage(), null, [], $statusCode ) );
	}
}