<?php

use Berg\LdapAuthenticator\Authenticator;

class AuthenticatorTest extends PHPUnit_Framework_TestCase {

    protected $authenticator;

    public function setUp()
    {
        $driver = new TestDriver();
        $params = array(
            'hostname'      => '',
            'port'          => '',
            'security'      => '',
            'bind_dn'       => '',
            'bind_password' => '',
            'base_dn'       => '',
            'group_dn'      => '',
            'search_scope'  => ''
        );
        $this->authenticator = new Authenticator($params, $driver);
    }

    public function testTest()
    {
        $this->assertTrue(true);
    }

}