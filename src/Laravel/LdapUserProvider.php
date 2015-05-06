<?php namespace Berg\LdapAuthenticator\Laravel;

use Berg\LdapAuthenticator\Authenticator;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Log\Writer as Logger;
use Monolog\Logger as Monolog;

class LdapUserProvider implements UserProvider {

    public function __construct()
    {
        $this->model = App::make(Config::get('auth.model'));
        $monolog = new Monolog('ldap_user');
        $logger = new Logger($monolog);
        $this->auth = new Authenticator(Config::get('ldap'), $logger);
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