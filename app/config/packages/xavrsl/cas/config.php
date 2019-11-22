<?php

return array(
	'default' => array(

		/*
		|--------------------------------------------------------------------------
		| PHPCas Hostname
		|--------------------------------------------------------------------------
		|
		| Exemple: 'cas.myuniv.edu'.
		|
		*/

		'cas_hostname' => 'sso.us.es',

		/*
		|--------------------------------------------------------------------------
		| Use as Cas proxy ?
		|--------------------------------------------------------------------------
		*/

		'cas_proxy' => false,

		/*
		|--------------------------------------------------------------------------
		| Enable service to be proxied
		|--------------------------------------------------------------------------
		|
		| Example:
		| phpCAS::allowProxyChain(new CAS_ProxyChain(array(
		|                                 '/^https:\/\/app[0-9]\.example\.com\/rest\//',
		|                                 'http://client.example.com/'
		|                         )));
		| For the exemple above:
		|	'cas_service' => array('/^https:\/\/app[0-9]\.example\.com\/rest\//','http://client.example.com/'),
		*/

		'cas_service' => array(),

		/*
		|--------------------------------------------------------------------------
		| Cas Port
		|--------------------------------------------------------------------------
		|
		| Usually 443 is default
		|
		*/

		'cas_port' => 443,

		/*
		|--------------------------------------------------------------------------
		| CAS URI
		|--------------------------------------------------------------------------
		|
		| Sometimes is /cas
		|
		*/

		'cas_uri' => '/CAS/index.php',

		/*
		|--------------------------------------------------------------------------
		| CAS Validation
		|--------------------------------------------------------------------------
		|
		| CAS server SSL validation: 'self' for self-signed certificate, 'ca' for
		| certificate from a CA, empty for no SSL validation.
		|
		*/

		'cas_validation' => '',
		
		/*
		|--------------------------------------------------------------------------
		| CAS Certificate
		|--------------------------------------------------------------------------
		|
		| Path to the CAS certificate file
		|
		*/
		
		'cas_cert' => '/path/to/cert/file',
		
		/*
		|--------------------------------------------------------------------------
		| CAS Login URI
		|--------------------------------------------------------------------------
		|
		| Empty is fine
		|
		*/
		
		'cas_login_url' => '',
		
		/*
		|--------------------------------------------------------------------------
		| CAS Logout URI
		|--------------------------------------------------------------------------
		*/
		
		'cas_logout_url' => '',
	)
);
