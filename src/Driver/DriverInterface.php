<?php namespace Berg\LdapAuthenticator\Driver;


interface DriverInterface
{
    // Validate data
    public function validate($username, $password);
    // Authenticate user
    public function authenticate($username, $password);
    // Check if user exists
    public function doesUserExist($username);
}