<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

interface ApiResponseInterface {

	public function send( $message, $data = null, $errors = [], $status = 200 ): Response;
}