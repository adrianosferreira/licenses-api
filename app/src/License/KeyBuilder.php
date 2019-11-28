<?php

namespace App\License;

use App\Entity\User;

class KeyBuilder {

	public function generate( User $user ) {
		return md5( serialize( $user ) );
	}
}