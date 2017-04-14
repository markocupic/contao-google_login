<?php
// Google Backend/Frontend oauth
if ($_GET['code'])
{
    // Backend-login
    if (strpos(\Environment::get('request'), 'check-google-login-be') !== false)
    {
        $GLOBALS['TL_HOOKS']['getPageIdFromUrl'][] = array('\Guave\GoogleLogin\OauthBe', 'checkLogin');
    }
    // Frontend-login
    if (strpos(\Environment::get('request'), 'check-google-login-fe') !== false)
    {
        $GLOBALS['TL_HOOKS']['getPageIdFromUrl'][] = array('\Guave\GoogleLogin\OauthFe', 'checkLogin');
    }
}

if (TL_MODE == 'FE')
{
    /** Overwrite these defaults in system/config/localconfig.php */
    // Id or alias where contao will redirect after fe login has suceeded
    $GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_AFTER_LOGIN_ALIAS'] = 'login';

    // Id or alias where contao has to redirect after a login error
    $GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_TO_ERROR_PAGE_ALIAS'] = 'error';
}


/** Hooks */
$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('\Markocupic\GoogleLogin\Oauth', 'parseBackendTemplate');


