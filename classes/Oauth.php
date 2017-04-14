<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 14.04.2017
 * Time: 20:44
 */

namespace Markocupic\GoogleLogin;


class Oauth
{

    /**
     * Inject google login button to be_login template
     * @param $strContent
     * @param $strTemplate
     * @return mixed
     */
    public function parseBackendTemplate($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_login')
        {
            $strBtn = '<div class="google-oauth-button"><br><a href="%s"><img width="200" src="system/modules/google_login/assets/sign-in-with-google.png" alt="google login"></a></div>';
            $oauth = \Guave\GoogleLogin\OauthBe::getInstance();
            $strBtn = sprintf($strBtn, $oauth->getOauthLinkForLogin());

            $strContent = preg_replace('/<input(.*?)type=\"submit\"(.*?)name=\"login\"(.*?)>/', '<input${1}type="submit"${2}name="login"${3}>' . $strBtn, $strContent);
        }

        return $strContent;
    }
}
