# Changelog

All notable changes to `laravel-magic-login` will be documented in this file.

## 1.2.3 - 2023-06-10

Minor update to RevokeTokencontroller to optionally support revoking of all tokens, not just the one used on current request.

## 1.2.2 - 2023-06-07

TokenCleanup Command

Adds Artisan command to cleanup Tokens that expired or have been consumed.
Schedule this command or just run it when you need it.

## Fixes auth check for TokenRequest - 2023-04-12

With this new feature we want to allow TokenRequests for non-existing User's.
When this feature is disabled, it will abort with 403 statuscode in the controller.

## 1.2.0 - 2023-04-12

Adds Magic auto User creation upon TokenRequest, when no User has been found.
Currently only supports using Email identification

Adds config options for default User name and option to disable this feature

## 1.1.0 - 2023-04-05

- RequestTokenRequest now only authorises the request if a User with given user identifier exists

## 1.0.0 - 2023-04-03

- initial release
