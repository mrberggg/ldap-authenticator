<?php namespace Berg\LdapAuthenticator\Laravel;

use Berg\LdapAuthenticator\Auth\LdapDriver;
use Berg\LdapAuthenticator\Authenticator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class LdapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('LDAPAuthenticateService', function ($app) {
            $driver = new LdapDriver(Config::get('ldap'));
            return new Authenticator($driver);
        });
    }
}