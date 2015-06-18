<?php namespace Berg\LdapAuthenticator\Laravel;

use Berg\LdapAuthenticator\Driver\LdapDriver;
use Berg\LdapAuthenticator\Authenticator;
use Illuminate\Support\ServiceProvider;

class LdapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('LDAPAuthenticateService', function ($app) {
            $driver = new LdapDriver(config('ldap'));
            return new Authenticator($driver);
        });
    }
}