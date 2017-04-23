# Contao Google Oauth login

## Modifies login templates (frontend and backend) to authenticate per oauth over google api
When clicking the button you will be redirected to the your google account login form. Login will succeed, if you enter the correct google password and if the registered e-mail address in your google accound is similar to the e-mail address in your user or member account in contao.


## Dependencies
google/apiclient

## Install
composer require google/apiclient:^2.0



### Backend login
Create an api key with the google API-Manager.
-https://console.developers.google.com/
register http:://yourdomain.com/check-google-login-be to allowed redirect urls of your app (only public domains are allowed by google)
download the oauth-credentials-be.json and copy it to /system/config

### Frontend login
Create an api key with the google API-Manager.
-https://console.developers.google.com/
register http:://yourdomain.com/check-google-login-fe to allowed redirect urls of your app (only public domains are allowed by google)
download the oauth-credentials-fe.json and copy it to /system/config


#### Frontend login settings config.php
These defaults are defined in the config.php of the module.
You can overwrite them in system/config/localconfig.php.

```php
<?php
    /** Overwrite these defaults in system/config/localconfig.php */
    // Id or alias where contao will redirect after fe login has succeeded
    $GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_AFTER_LOGIN_ALIAS'] = 'login';

    // Id or alias where contao has to redirect after a login error
    $GLOBALS['GOOGLE_FE_OAUTH']['FE_REDIRECT_TO_ERROR_PAGE_ALIAS'] = 'error';
```

#### Howto for developers
http://www.binarytides.com/php-code-google-openid-login/