<?php

class UserCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testLogin(\AcceptanceTester $I)
    {
        $I->amOnPage('/game/test-game-2');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a sample comment. This is a sample comment.');
        $I->click('Reply');

        $I->see('Login'); //verify the user was directed to the login page
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->see('Test Game 2'); //verify the user was redirected back
        $I->dontSee('Animation', '.media-body');
        $I->dontSee('Level Design', '.media-body');
        $I->dontSee('This is a sample comment. This is a sample comment.');
        $I->dontSeeInDatabase('comments', array('body' => 'This is a sample comment. This is a sample comment.'));
    }

    public function testLoginInvalidEmail(\AcceptanceTester $I)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', 'baduser@gmail.com');
        $I->fillField('password', 'password2');
        $I->click(['id' => 'login']);

        $I->see('These credentials do not match our records.');
        $I->seeInCurrentUrl('/auth/login');
    }

    public function testLoginInvalidPassword(\AcceptanceTester $I)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', 'user1@gmail.com');
        $I->fillField('password', 'password2');
        $I->click(['id' => 'login']);

        $I->see('These credentials do not match our records.');
        $I->seeInCurrentUrl('/auth/login');
    }

    public function testProfile(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#profile-button');
        $I->wait(1);

        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 3');
        $I->see('Test Game 4');
        $I->see('This is a test comment by user 1 on game 5');
    }

    public function testLogout(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->see('user1');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        $I->dontSee('user1');
    }

    public function profileWithoutPermissions(\AcceptanceTester $I)
    {
        $I->amOnPage('/');

        $I->amOnPage('/profile');

        $I->dontSee('Profile');
        $I->dontSeeInCurrentUrl('profile');
    }
}