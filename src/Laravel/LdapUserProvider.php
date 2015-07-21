<?php

namespace Berg\LdapAuthenticator\Laravel;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class LdapUserProvider implements UserProvider
{

    public function __construct()
    {
        $this->model = app(config('auth.model'));
        $this->auth = app('LdapAuthenticateService');
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->auth->authenticate($credentials['username'], $credentials['password']);
    }

    public function retrieveById($identifier)
    {
        return $this->model->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->model
            ->where($this->model->getKeyName(), $identifier)
            ->where($this->model->getRememberTokenName(), $token)
            ->first();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->model->whereUsername($credentials['username'])->first();
    }

}