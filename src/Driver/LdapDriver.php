<?php

namespace Berg\LdapAuthenticator\Driver;

use Berg\LdapAuthenticator\Exceptions\ConfigNotSetException;
use Zend\Authentication\Adapter\Ldap as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Ldap\Ldap;
use Zend\Session\Storage\StorageInterface;

class LdapDriver implements DriverInterface
{
    protected $ldap;
    protected $config;

    public function __construct($config)
    {
        if (!$config) {
            throw new ConfigNotSetException;
        }

        $this->config = $config;
        $this->ldap = new Ldap([
            'host'        => $config['host'],
            'useStartTls' => $config['security'] === 'TLS',
            'useSsl'      => $config['security'] === 'SSL',
            'baseDn'      => $config['baseDn'],
            'username'    => $config['username'],
            'password'    => $config['password']
        ]);
    }

    public function validate($username, $password)
    {
        return $username && $password;
    }

    public function authenticate($username, $password)
    {
        $userDn = $this->getUserDn($username);
        $adapter = new AuthAdapter([$this->ldap->getOptions()], $userDn, $password);
        $auth = new AuthenticationService();

        return $auth->authenticate($adapter)->isValid();
    }

    public function doesUserExist($username)
    {
        $searchScope = $this->config['searchScope'] ?: '(objectclass=*)';

        $search = $this->ldap->search('(cn=' . $username . ')', $this->config['baseDn'], $searchScope);
        foreach($search as $item){
            // If contains cn, make sure cn = our username. If it does, user exists
            $cn = isset($item['cn']) ? strtolower($item['cn'][0]) : null;
            if($cn === $username){
                return true;
            }
        }

        return false;
    }

    protected function getUserDn($username)
    {
        $search = $this->ldap->search('(cn=' . $username . ')', $this->config['baseDn']);
        foreach ($search as $item) {
            if ($item['dn']) {
                // Return first found (best solution? might need to update)
                return $item['dn'];
            }
        }

        return null;
    }

}