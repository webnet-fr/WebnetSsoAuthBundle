SSO authentication for Symfony2
===============================
This bundle helps you to bring SSO authentication to your Symfony2 project.


It works in two ways:

-   **trusted**: authentication is done against a known server (like with CAS)
-   **open**: authentication is done with server of user's choice (like with OpenId)



Only CAS protocol is implemented for now, many other are planned.

This plugin is a based on BeSimpleSsoAuthBundle.

It only adds the ability to connect to CAS using the SAML_VERSION_1_1 for CAS

In order to activate this mode, use the following configuration:
```
webnet_sso_auth:
    provider_id:
        protocol:
            id: cas
            version: 3 #important
        server:
            id: cas
            login_url: [LOGIN_URL]
            logout_url: [LOGOUT_URL]
            validation_url: [VALIDATION_URL]
paramerters:
    webnet.sso_auth.client.option.cas_host.value: [CAS_HOST]
    webnet.sso_auth.client.option.cas_port.value: [CAS_PORT]
    webnet.sso_auth.client.option.cas_context.value: [CAS_CONTEXT] #usually '/cas'
    webnet.sso_auth.client.class: Webnet\SsoAuthBundle\Buzz\CasClient
    webnet.sso_auth.protocol.cas.class: Webnet\SsoAuthBundle\Sso\Cas\SamlProtocol
```

-   [Read documentation](https://github.com/webnet-fr/WebnetSsoAuthBundle/blob/master/Resources/doc/index.md)
-   [See the license](https://github.com/webnet-fr/WebnetSsoAuthBundle/blob/master/Resources/meta/LICENSE)
