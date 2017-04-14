<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Guave',
    'Markocupic',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Guave\GoogleLogin\OauthFe'  => 'system/modules/google_login/classes/OauthFe.php',
	'Guave\GoogleLogin\OauthBe'  => 'system/modules/google_login/classes/OauthBe.php',
    'Markocupic\GoogleLogin\Oauth'  => 'system/modules/google_login/classes/Oauth.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	//'be_login'             => 'system/modules/google_login/templates',
	'mod_login_1cl'        => 'system/modules/google_login/templates',
));
