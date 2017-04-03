# Password Reset
A simple artisan command to reset user passwords.

## Installation

Install the package via Composer:

```shell
$ composer require joepriest/passwordreset
```

Then, add the service provider to `config/app.php`.

```php
'providers' => [
    // ...
    JoePriest\PasswordReset\PasswordResetServiceProvider::class,
];
```

## Usage

To reset a password, run `user:resetpassword` from your console.

```shell
php artisan user:resetpassword {user_id?} {new_password?}
```

If no user id is provided, you will be asked to choose a user by name.

If no new password is provided, you will be asked for one (a random one will be suggested).
