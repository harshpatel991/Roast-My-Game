<?php

class RegisterCest
{

    public function _before(AcceptanceTester $I)
    {
//        putenv("MAIL_DRIVER=log");
    }

    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testNormalRegister(\AcceptanceTester $I)
    {
        $I->resetEmails();
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'new-register');
        $I->fillField('email', 'new-register@gmail.com');
        $I->fillField('password', 'password-new-register');
        $I->fillField('password_confirmation', 'password-new-register');

        $I->click(['id' => 'register']);
        $I->seeInDatabase('users', ['username' => 'new-register', 'email' => 'new-register@gmail.com', 'status' => 'unconfirmed']);
        $confirmationCode = $I->grabFromDatabase('users', 'confirmation_code', array('username' => 'new-register'));

        //verify logged in
        $I->see('new-register');
        $I->see('A verification link has been sent to new-register@gmail.com');

        $I->amOnPage('/profile/new-register');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('0 Points');

        //verify email
        $I->seeInLastEmailTo("support@roastmygame.com", "Confirm your email by clicking the link below.");
        $I->seeInLastEmailTo("support@roastmygame.com", "http://clickr.app/verify/".$confirmationCode);
        $I->seeInLastEmailTo("new-register@gmail.com", "Confirm your email by clicking the link below.");
        $I->seeInLastEmailTo("new-register@gmail.com", "http://clickr.app/verify/".$confirmationCode);
        $I->seeEmailCount(2);

        //confirm the user
        $I->amOnPage('/verify/'.$confirmationCode);
        $I->see('Your email has been verified!');
        $I->seeInDatabase('users', array('username' => 'new-register', 'email' => 'new-register@gmail.com', 'status' => 'good'));

        $I->amOnPage('/profile/new-register');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('50 Points');
    }

    public function testRegisterInvalidUsername(\AcceptanceTester $I)
    {
        //blank username
        $I->amOnPage('/auth/register');
        $I->fillField('username', '');
        $I->fillField('email', 'new-register-invalid@gmail.com');
        $I->fillField('password', 'password-new-register');
        $I->fillField('password_confirmation', 'password-new-register');

        $I->click(['id' => 'register']);
        $I->dontSeeInDatabase('users', ['email' => 'new-register-invalid@gmail.com']);
        $I->see('The username field is required.');

        //too long user name
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('email', 'new-register-invalid@gmail.com');
        $I->fillField('password', 'password-new-register');
        $I->fillField('password_confirmation', 'password-new-register');

        $I->click(['id' => 'register']);
        $I->dontSeeInDatabase('users', ['email' => 'new-register-invalid@gmail.com']);
        $I->see('The username may not be greater than 255 characters.');

        //not unique username
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'user1');
        $I->fillField('email', 'new-register-invalid@gmail.com');
        $I->fillField('password', 'password-new-register');
        $I->fillField('password_confirmation', 'password-new-register');

        $I->click(['id' => 'register']);
        $I->dontSeeInDatabase('users', ['email' => 'new-register-invalid@gmail.com']);
        $I->see('The username has already been taken.');
    }

    public function testRegisterInvalidEmail(\AcceptanceTester $I)
    {
        //blank email
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'new-register-invalid');
        $I->fillField('email', '');
        $I->fillField('password', 'password-new-register');
        $I->fillField('password_confirmation', 'password-new-register');
        $I->click(['id' => 'register']);

        $I->see('The email field is required.');
        $I->dontSeeInDatabase('users', ['username' => 'new-register-invalid']);

        //not valid email address
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'new-register-invalid');
        $I->fillField('email', 'testy');
        $I->fillField('password', 'password-new-register');
        $I->fillField('password_confirmation', 'password-new-register');
        $I->click(['id' => 'register']);

        $I->see('The email must be a valid email address.');
        $I->dontSeeInDatabase('users', ['username' => 'new-register-invalid']);

        //too long email
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'new-register-invalid');
        $I->fillField('email', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('password', 'password-new-register');
        $I->fillField('password_confirmation', 'password-new-register');
        $I->click(['id' => 'register']);

        $I->see('The email may not be greater than 255 characters.');
        $I->dontSeeInDatabase('users', ['username' => 'new-register-invalid']);

        //not unique email
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'new-register-invalid');
        $I->fillField('email', 'user1@gmail.com');
        $I->fillField('password', 'password-new-register');
        $I->fillField('password_confirmation', 'password-new-register');
        $I->click(['id' => 'register']);

        $I->see('The email has already been taken.');
        $I->dontSeeInDatabase('users', ['username' => 'new-register-invalid']);
    }

    public function testRegisterInvalidPassword(\AcceptanceTester $I)
    {
        //blank password
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'new-register-invalid');
        $I->fillField('email', 'new-user-invlaid@gmail.com');
        $I->fillField('password', '');
        $I->fillField('password_confirmation', '');
        $I->click(['id' => 'register']);

        $I->see('The password field is required.');
        $I->dontSeeInDatabase('users', ['username' => 'new-register-invalid']);

        //too short password
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'new-register-invalid');
        $I->fillField('email', 'new-user-invlaid@gmail.com');
        $I->fillField('password', '12345');
        $I->fillField('password_confirmation', '12345');
        $I->click(['id' => 'register']);

        $I->see('The password must be at least 6 characters.');
        $I->dontSeeInDatabase('users', ['username' => 'new-register-invalid']);
    }

    public function testRegisterInvalidConfirmation(\AcceptanceTester $I)
    {
        //non matching password
        $I->amOnPage('/auth/register');
        $I->fillField('username', 'new-register-invalid');
        $I->fillField('email', 'new-user-invlaid@gmail.com');
        $I->fillField('password', '1234567');
        $I->fillField('password_confirmation', '123456');
        $I->click(['id' => 'register']);

        $I->see('The password confirmation does not match.');
        $I->dontSeeInDatabase('users', ['username' => 'new-register-invalid']);

    }
}