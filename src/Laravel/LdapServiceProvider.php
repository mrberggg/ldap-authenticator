<?php

namespace Berg\LdapAuthenticator\Laravel;

use Berg\LdapAuthenticator\Authenticator;
use Berg\LdapAuthenticator\Driver\LdapDriver;
use Illuminate\Support\ServiceProvider;

class LdapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('LdapAuthenticateService', function ($app) {
            $ldapDriver = new LdapDriver(config('ldap'));

            return new Authenticator($ldapDriver);
        });
    }
}