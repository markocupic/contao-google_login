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
    // Overwrite these default in system/config/localconfig.php
    $GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_AFTER_LOGIN_ALIAS'] = 'login';
    $GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_TO_ERROR_PAGE_ALIAS'] = 'error';
}

$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('\Markocupic\GoogleLogin\Oauth', 'parseBackendTemplate');


