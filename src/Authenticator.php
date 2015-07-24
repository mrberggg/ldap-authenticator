<?php

namespace Berg\LdapAuthenticator;

use Berg\LdapAuthenticator\Driver\DriverInterface;
use Berg\LdapAuthenticator\Exceptions\IncorrectCredentialsException;
use Berg\LdapAuthenticator\Exceptions\InvalidCredentialsException;
use Berg\LdapAuthenticator\Exceptions\UserDoesNotExistException;

class Authenticator
{
    protected $driver;
    protected $errors = array();

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function authenticate($username, $password)
    {
        // Is data valid?
        $username = strtolower($username);
        if (!$this->driver->validate($username, $password)){
            throw new InvalidCredentialsException;
        }
        // Does user exist?
        if(!$this->doesUserExist($username)) {
            throw new UserDoesNotExistException;
        }
        // Are username and password correct?
        if(!$this->driver->authenticate($username, $password)){
            throw new IncorrectCredentialsException;
        }

        return true;
    }

    public function doesUserExist($username)
    {
        $username = strtolower($username);
        return $this->driver->doesUserExist($username);
    }

}