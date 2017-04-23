<?php

namespace Guave\GoogleLogin;

use Firebase\JWT\JWT;

class OauthFe
{

    protected static $instance = null;
    protected static $client = null;
    private static $user = null;


    protected function __construct()
    {

        JWT::$leeway = 1;

        $oauthCredis = self::getOAuthCredentialsFile();
        if (!$oauthCredis)
        {
            die('oauth-credentials-fe.json file missing in system/config');
        }

        $redirectUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/check-google-login-fe';

        $client = new \Google_Client();
        $client->setAuthConfig($oauthCredis);
        $client->setRedirectUri($redirectUrl);
        // Add scopes
        // https://developers.google.com/+/web/api/rest/oauth#login-scopes
        $client->addScope('openid');
        $client->addScope('profile');
        $client->addScope('email');
        if ($_SESSION['oauth_fe']['access_token'])
        {
            $client->setAccessToken($_SESSION['oauth_fe']['access_token']);
        }

        self::$client = $client;

    }

    protected function __clone()
    {

    }

    /**
     * @return Oauth
     */
    public static function getInstance()
    {
        if (!isset(static::$instance))
        {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * @return bool|string
     */
    public static function getOAuthCredentialsFile()
    {
        // oauth2 creds
        $oauthCredis = TL_ROOT . '/system/config/oauth-credentials-fe.json';

        if (file_exists($oauthCredis))
        {
            return $oauthCredis;
        }

        return false;
    }

    public static function getOauthLinkForLogin()
    {
        unset($_SESSION['oauth_fe']['access_token']);
        $client = self::$client;
        return $client->createAuthUrl();

    }

    /**
     * called by hook getPageIdFromUrl
     * registers routing for check-google-login
     */
    public static function checkLogin($arrFragments)
    {

        if ($arrFragments[0] == 'check-google-login-fe')
        {

            $client = self::$client;

            if (isset($_GET['code']))
            {
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                $client->setAccessToken($token);
                $_SESSION['oauth_fe']['access_token'] = $token;
            }

            if ($client->getAccessToken())
            {
                $token_data = $client->verifyIdToken();

                /**
                 * check for user
                 * @var $user FontendUser
                 */
                $user = \FrontendUser::getInstance();
                $find = $user->findBy('email', $token_data['email']);
                if (!$find)
                {
                    //\Message::addError('no member with ' . $token_data['email'] . ' found');
                    \Controller::redirect(self::generateUrl($GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_TO_ERROR_PAGE_ALIAS']));
                }
                else
                {

                    // Register hook
                    $GLOBALS['TL_HOOKS']['importUser'][] = array('\Guave\GoogleLogin\OauthFe', 'importUser');
                    $GLOBALS['TL_HOOKS']['checkCredentials'][] = array('\Guave\GoogleLogin\OauthFe', 'importUser');
                    self::$user = $user;

                    \Input::setPost('username', 'oauthuser');
                    \Input::setPost('password', 'oauthpw');
                    if ($user->login())
                    {
                        \Controller::redirect(self::generateUrl($GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_AFTER_LOGIN_ALIAS']));
                    }
                    else
                    {
                        \Controller::redirect(self::generateUrl($GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_TO_ERROR_PAGE_ALIAS']));
                    }
                }
            }
        }
    }

    /**
     * import user hook
     * @return bool
     */
    public function importUser($username, $password, $table)
    {

        $user = self::$user;
        if ($user)
        {
            \Input::setPost('username', $user->username);
            return true;
        }

        return false;

    }

    /**
     * @param $strPageAlias
     * @return mixed|string
     */
    protected static function generateUrl($strPageAlias = '')
    {
        if ($strPageAlias == '')
        {
            return '';
        }

        $objP = \PageModel::findPublishedByIdOrAlias($strPageAlias);
        if ($objP !== null)
        {

            $objPage = \PageModel::findByPk($objP->id);
            if ($objPage !== null)
            {
                return $objPage->getFrontendUrl();
            }

        }
        new \Exception('Tried to redirect to an unpublished or inexistent page.');

    }

}