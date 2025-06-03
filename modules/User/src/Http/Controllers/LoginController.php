<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Actions\LoginUserAction;
use Modules\User\Data\LoginUserData;
use Modules\User\Response\WithResponse;

class LoginController
{
    use WithResponse;

    /**
     * Authenticate user and generate token.
     */
    public function authenticate(
        LoginUserData $credentials,
        LoginUserAction $loginAction
    ) {
        $token = $loginAction->execute($credentials);

        if ($token) {
            return $this->loginResponse($token);
        }

        return $this->validationError(
            "The provided credentials are incorrect."
        );
    }
}
