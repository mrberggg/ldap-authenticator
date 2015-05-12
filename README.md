[![Build Status](https://travis-ci.org/mrberggg/ldap-authenticator.svg?branch=master)](https://travis-ci.org/mrberggg/ldap-authenticator)
# LDAP Authenticator
This package adds quick support for LDAP authentication. It includes support for Laravel 5.

## Installation
`composer require berg/ldap-authenticator`

## Laravel Config
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

    'Berg\LdapAuthenticator\Laravel\LdapServiceProvider'

## Usage
Once set up, using the Auth::attempt($username, $password) will automatically call on the ldap driver.

To use the service provider, call `App::make('LdapAuthenticateService')`

### Exceptions
This package uses exceptions to handle invalid logins. The following errors are used:

    'Berg\LdapAuthenticator\Exceptions\IncorrectCredentialsException'
    'Berg\LdapAuthenticator\Exceptions\InvalidCredentialsException'
    'Berg\LdapAuthenticator\Exceptions\UserDoesNotExistException
    
If using Laravel, these should be added to the `$dontReport` property in the Handler class. [Custom handling of each exception can be added to the `Handler->render()` method.](http://laravel.com/docs/5.0/errors#handling-errors)