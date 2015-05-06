<?php

use Berg\LdapAuthenticator\Auth\DriverInterface;

class TestDriver implements DriverInterface {

    public function validate($username, $password)
    {
        return $username && $password;
    }

    public function authenticate($username, $password = null)
    {
        return (bool) $password;
    }

    public function doesUserExist($username = null)
    {
        return (bool) $username;
    }
}