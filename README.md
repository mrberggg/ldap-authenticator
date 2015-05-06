php-ldap-authenticator
================
This package adds quick support for LDAP authentication.

Installation
------------
Use [Composer](https://packagist.org/packages/berg/ldap "Composer Link")


Laravel Config
---------------------
This package comes with a driver to support quick setup using Laravel (v4.* supported for now, hope to add v5.* support soon). To set up, first install the package and then register the driver using the following code (can be placed in global.php):

    Auth::extend('ldap', function($app) {
        $userProvider = new Berg\LDAPAuthenticator\LdapUserProvider();
        return new Illuminate\Auth\Guard($userProvider, $app->make('Illuminate\Session\Store'));
    });

Then create a file named ldap.php in the /app/config/ folder. The file should return an array with the following values:

    'hostname' => '',
    'port' => '',
    'security' => '', // E.g. SSL
    'bind_dn' => '',
    'bind_password' => '',
    'base_dn' => '',
    'group_dn' => '',
    'search_scope' => ''

Lastly set the driver in the `app/config/auth.php` file to `ldap`.

If you wish to use the class for non-authentication tasks such as checking if a user exists, you may also use the built in service provider by adding the following line to the `app.php` config file:

    'Berg\LDAPAuthenticator\LdapServiceProvider'

Usage
---------------------
Once set up, using the Auth::attempt($username, $password) will automatically call on the ldap driver.

To use the service provider, call `App::make('LDAPAuthenticateService')`
