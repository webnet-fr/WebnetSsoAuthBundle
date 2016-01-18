Get started with WebnetSsoAuthBundle
======================================


Get the sources, enable bundle & run the tests.


Install bundle & dependency
---------------------------

Add the requirement in your `composer.json` file:

    {
        "require": {
            "webnet/sso-auth-bundle": "*"
        }
    }

Then run `composer update Webnet/sso-auth-bundle`.

Enable bundle & dependency
--------------------------


Add bundle to your kernel class:

    // app/AppKernel.php
    $bundles = array(
        // ...
        new Webnet\SsoAuthBundle\WebnetSsoAuthBundle(),
        // ...
    );


Add bundle to your config file:

    # app/config/config.yml
    webnet_sso_auth: ~
