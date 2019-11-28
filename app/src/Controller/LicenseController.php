<?php

namespace App\Controller;

use App\Entity\License;
use App\Entity\User;
use App\License\KeyBuilder;
use App\Http\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LicenseController extends AbstractController {

	private $response;
	private $keyBuilder;

	public function __construct( ApiResponse $response, KeyBuilder $keyBuilder ) {
		$this->response   = $response;
		$this->keyBuilder = $keyBuilder;
	}

	/**
	 * @Route("/license", name="create_license", methods={"POST"})
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function create( Request $request ): Response {
		$userId = $request->get( 'user' );

		if ( ! $userId ) {
			return $this->response->notValidated(
				[
					[ 'user' => 'User is missing' ]
				],
				'Validation failed',
				123
			);
		}

		$user = $this->getDoctrine()->getRepository( User::class )->find( $userId );

		if ( ! $user ) {
			return $this->response->notFound(
				123,
				'License not created',
				sprintf( 'User with ID %d not found in the database', $userId )
			);
		}

		$license = new License();
		$license->setStatus( 1 );
		$license->setExpiresAt( new \DateTime() );
		$license->setUser( $user );
		$license->setLicenseKey( $this->keyBuilder->generate( $user ) );

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist( $license );
		$entityManager->flush();

		return $this->response->success( sprintf( 'New license added: %d', $license->getId() ) );
	}
}
