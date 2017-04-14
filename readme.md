# Contao Google Oauth login

## Two contao templates to login (frontend and backend) per oauth over google api
search for googleemail in user db and login as user

## Dependencies
google/apiclient

## Install
composer require google/apiclient:^2.0

Create an api key with the google API-Manager.
-https://console.developers.google.com/

### Backend Login
register http:://yourdomain.com/check-google-login-be to allowed redirect urls of your app (only public domains are allowed by google)
download the oauth-credentials-be.json and copy it to /system/config

### Frontend Login
register http:://yourdomain.com/check-google-login-fe to allowed redirect urls of your app (only public domains are allowed by google)
download the oauth-credentials-fe.json and copy it to /system/config


