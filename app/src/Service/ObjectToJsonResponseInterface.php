<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

interface ObjectToJsonResponseInterface {

	public function __construct( SerializerInterface $serializer );

	public function send(): Response;
}