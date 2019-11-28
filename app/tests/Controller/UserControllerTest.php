<?php

namespace App\Tests\Controller;

use App\Controller\UserController;
use App\Entity\User;
use App\Service\ApiResponseInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserControllerTest extends TestCase {

	public function testSomething() {
		$validator = $this->getMockBuilder( ValidatorInterface::class )
			->getMock();

		$response = $this->getMockBuilder( ApiResponseInterface::class )
			->getMock();

		$userController = new UserController( $validator, $response );
		$this->assertInstanceOf( User::class, $userController );
	}
}