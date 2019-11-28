<?php

namespace App\Controller;

use App\Entity\User;
use App\Http\Response\ApiResponse;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController {

	private $validator;
	private $response;

	public function __construct( ValidatorInterface $validator, ApiResponse $response ) {
		$this->response  = $response;
		$this->validator = $validator;
	}

	/**
	 * @Route("/user", name="create_user", methods={"POST"})
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function createUser( Request $request ): Response {
		$entityManager = $this->getDoctrine()->getManager();

		if ( ! $request->get( 'name' ) ) {
			return $this->response->send( '', [], [ 'name' => 'Name is required' ], 500 );
		}

		$user = new User();
		$user->setName( $request->get( 'name' ) );
		$user->setCreatedAt( new \DateTime() );
		$user->setUpdatedAt( new \DateTime() );

		$errors = $this->validator->validate( $user );

		if ( \count( $errors ) > 0 ) {
			return $this->response->send( '', null, $errors );
		}

		$entityManager->persist( $user );
		$entityManager->flush();

		return $this->response->send( sprintf( 'New user %d added', $user->getId() ) );
	}

	/**
	 * @Route("/user/{id}", name="user_show", methods={"GET"}, requirements={"id"="\d+"})
	 *
	 * @param $id
	 *
	 * @return Response
	 */
	public function show( $id ): Response {
		$user = $this->getUserRepository()->find( $id );

		if ( ! $user ) {
			return $this->response->send( sprintf( 'User %d not found', $user->getId() ) );
		}

		return $this->response->send( '', $user );
	}

	/**
	 * @Route("/user/{id}/licenses", name="user_licenses_show", methods={"GET"}, requirements={"id"="\d+"})
	 *
	 * @param $id
	 *
	 * @return Response
	 */
	public function show_licenses( $id ): Response {
		$user = $this->getUserRepository()->find( $id );

		if ( ! $user ) {
			return $this->response->send( sprintf( 'User %d not found', $user->getId() ) );
		}

		return $this->response->send( '', $user->getLicenses() );
	}

	/**
	 * @Route("/user/{name}", name="user_show_by_name", methods={"GET"})
	 *
	 * @param $name
	 *
	 * @return Response
	 */
	public function showByName( $name ): Response {
		$users = $this->getUserRepository()->findByName( $name );

		if ( ! $users ) {
			return $this->response->send( sprintf( 'User %s not found', $name ) );
		}

		return $this->response->send( '', $users );
	}

	private function getUserRepository(): ObjectRepository {
		return $this->getDoctrine()->getRepository( User::class );
	}
}
