<?php

use Berg\LdapAuthenticator\Authenticator;
use \Mockery as m;

class AuthenticatorTest extends PHPUnit_Framework_TestCase {

    public function testInvalidCredentials()
    {
        $this->setExpectedException('Berg\LdapAuthenticator\Exceptions\InvalidCredentialsException');
        $driver = m::mock('Berg\LdapAuthenticator\Driver\LdapDriver');
        $driver->shouldReceive('validate')->andReturn(false);
        $authenticator = new Authenticator($driver);
        $authenticator->authenticate('username', 'password');
    }

    public function testUserDoesNotExist()
    {
        $this->setExpectedException('Berg\LdapAuthenticator\Exceptions\UserDoesNotExistException');
        $driver = m::mock('Berg\LdapAuthenticator\Driver\LdapDriver');
        $driver->shouldReceive('validate')->andReturn(true);
        $driver->shouldReceive('doesUserExist')->andReturn(false);
        $authenticator = new Authenticator($driver);
        $authenticator->authenticate('username', 'password');
    }

    public function testAuthenticationFails()
    {
        $this->setExpectedException('Berg\LdapAuthenticator\Exceptions\IncorrectCredentialsException');
        $driver = m::mock('Berg\LdapAuthenticator\Driver\LdapDriver');
        $driver->shouldReceive('validate')->andReturn(true);
        $driver->shouldReceive('doesUserExist')->andReturn(true);
        $driver->shouldReceive('authenticate')->andReturn(false);
        $authenticator = new Authenticator($driver);
        $authenticator->authenticate('username', 'password');
    }

    public function testValidLogin()
    {
        $driver = m::mock('Berg\LdapAuthenticator\Driver\LdapDriver');
        $driver->shouldReceive('validate')->andReturn(true);
        $driver->shouldReceive('doesUserExist')->andReturn(true);
        $driver->shouldReceive('authenticate')->andReturn(true);
        $authenticator = new Authenticator($driver);
        $authenticated = $authenticator->authenticate('username', 'password');
        $this->assertTrue($authenticated);
    }

    public function tearDown()
    {
        m::close();
    }

}