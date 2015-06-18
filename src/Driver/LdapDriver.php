<?php namespace Berg\LdapAuthenticator\Driver;


use Berg\LdapAuthenticator\Exceptions\ConfigNotSetException;

class LdapDriver implements DriverInterface
{
    protected $config;
    protected $connection;

    public function __construct($config)
    {
        if(!$config){
            throw new ConfigNotSetException;
        }
        $this->config = $config;
        $this->connection = $this->getConnection();
    }

    public function validate($username, $password)
    {
        return $username && $password;
    }

    public function authenticate($username, $password)
    {
        $userDn = $this->getDnForUser($username);

        return (bool) @ldap_bind($this->connection, $userDn, $password);
    }

    public function doesUserExist($username)
    {
        $dn = $this->getDnForUser($username);
        $searchScope = $this->config['search_scope'] ?: '(objectclass=*)';

        return (bool) @ldap_search($this->connection, $dn, $searchScope);
    }

    protected function getConnection()
    {
        $hostname = $this->config['hostname'];
        if ($this->config['security'] === 'SSL') {
            $hostname = 'ldaps://' . $hostname;
        }

        return @ldap_connect($hostname, $this->config['port']);
    }

    protected function getDnForUser($username)
    {
        return 'cn=' . $username . ',' . $this->config['base_dn'];
    }

    public function __destruct()
    {
        if($this->connection){
            ldap_unbind($this->connection);
        }
    }

}