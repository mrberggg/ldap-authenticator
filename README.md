LDAP Authenticator
================
This package adds quick support for LDAP authentication. It includes support for Laravel 5.

Installation
------------
`composer require berg/ldap-authenticator`

Laravel Config
---------------------
This package comes with a driver to support quick setup using Laravel 5. To set up, first install the package and then register the driver by placing the following code in the AppServiceProvider's boot method:

    Auth::extend('ldap', function($app) {
        $userProvider = new LdapUserProvider();
        return new Guard($userProvider, $app->make('Illuminate\Session\Store'));
    });

Then create a file named ldap.php in the config/ folder. The file should return an array with the following values:

    'hostname' => '',
    'port' => '',
    'security' => '', // E.g. SSL
    'bind_dn' => '',
    'bind_password' => '',
    'base_dn' => '',
    'group_dn' => '',
    'search_scope' => ''

Lastly set the driver in the `config/auth.php` file to `ldap`.

If you wish to use the class for non-authentication tasks such as checking if a user exists, you may also use the built in service provider by adding the following line to the `app.php` config file:

    'Berg\LDAPAuthenticator\LdapServiceProvider'

Usage
---------------------
Once set up, using the Auth::attempt($username, $password) will automatically call on the ldap driver.

To use the service provider, call `App::make('LDAPAuthenticateService')`
