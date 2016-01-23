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

    public function resetPassword(\AcceptanceTester $I)
    {
        $I->amOnPage('/password/email');
        $I->fillField('email', 'user1@gmail.com');
        $I->click('Send Reset Link');
        $I->see('We have e-mailed your password reset link!');

        $resetToken = $I->grabFromDatabase('password_resets', 'token', array('email' => 'user1@gmail.com'));
        $I->amOnPage('/password/reset/'.$resetToken);

        $I->fillField('email', 'user1@gmail.com');
        $I->fillField('password', 'mynewpassword');
        $I->fillField('password_confirmation', 'mynewpassword');
        $I->click('Reset Password');
        $I->see('Your password has been reset!');

        //logout and make sure old doesn't work and new does work
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        $I->amOnPage('/auth/login');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->see('These credentials do not match our records.');
        $this->loginAs($I, 'user1@gmail.com', 'mynewpassword');
        $I->see('user1');
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

    public function testViewBadge(\AcceptanceTester $I)
    {
        $I->amOnPage('/game/test-game-3');
        $I->seeInSource('<span class="icon-circle trophy-badge-bronze"></span>'); //see bronze badge

        $I->amOnPage('/game/test-game-7');
        $I->seeInSource('<span class="icon-circle trophy-badge-silver"></span>'); //see sliver badge

        $I->amOnPage('/game/test-game-5');
        $I->seeInSource('<span class="icon-circle trophy-badge-gold"></span>'); //see gold badge
        $I->seeInSource('<span class="icon-circle trophy-badge-bronze"></span>'); //see bronze badge
    }

    public function testViewTrophies(\AcceptanceTester $I)
    {
        $I->amOnPage('/profile/user1');
        $I->seeInSource('trophy3.png');
        $I->seeInSource('<span class="icon-circle trophy-badge-gold"></span>');

        $I->amOnPage('/profile/user2');
        $I->seeInSource('trophy2.png');
        $I->seeInSource('<span class="icon-circle trophy-badge-silver"></span>');

        $I->amOnPage('/profile/user3');
        $I->seeInSource('trophy1.png');
        $I->seeInSource('<span class="icon-circle trophy-badge-bronze"></span>');
    }

    public function testViewPoints(\AcceptanceTester $I)
    {
        $I->amOnPage('/profile/user1');
        $I->seeInSource('trophy3.png');
        $I->seeInSource('300 Points');

        $I->amOnPage('/profile/user2');
        $I->seeInSource('trophy2.png');
        $I->seeInSource('100 Points');

        $I->amOnPage('/profile/user3');
        $I->seeInSource('trophy1.png');
        $I->seeInSource('0 Points');
    }

    public function testViewAllPoints(\AcceptanceTester $I)
    {
        $I->haveInDatabase('users', array('id' => 14, 'username' => 'viewPointsUser', 'email' => 'viewPointsUser@gmail.com', 'points' => 0));
        $I->amOnPage('/profile/viewPointsUser');
        $I->seeInSource('trophy1.png');
        $I->seeInSource('0 Points');
        $I->see('1', '#level');

        $I->haveInDatabase('users', array('id' => 15, 'username' => 'viewPointsUser1', 'email' => 'viewPointsUser1@gmail.com', 'points' => 5));
        $I->amOnPage('/profile/viewPointsUser1');
        $I->seeInSource('trophy1.png');
        $I->seeInSource('5 Points');
        $I->see('1', '#level');

        $I->haveInDatabase('users', array('id' => 16, 'username' => 'viewPointsUser2', 'email' => 'viewPointsUser2@gmail.com', 'points' => 50));
        $I->amOnPage('/profile/viewPointsUser2');
        $I->seeInSource('trophy1.png');
        $I->seeInSource('50 Points');
        $I->see('1', '#level');

        $I->haveInDatabase('users', array('id' => 17, 'username' => 'viewPointsUser3', 'email' => 'viewPointsUser3@gmail.com', 'points' => 51));
        $I->amOnPage('/profile/viewPointsUser3');
        $I->seeInSource('trophy1.png');
        $I->seeInSource('51 Points');
        $I->see('2', '#level');

        $I->haveInDatabase('users', array('id' => 18, 'username' => 'viewPointsUser4', 'email' => 'viewPointsUser4@gmail.com', 'points' => 75));
        $I->amOnPage('/profile/viewPointsUser4');
        $I->seeInSource('trophy1.png');
        $I->seeInSource('75 Points');
        $I->see('2', '#level');

        $I->haveInDatabase('users', array('id' => 19, 'username' => 'viewPointsUser5', 'email' => 'viewPointsUser5@gmail.com', 'points' => 76));
        $I->amOnPage('/profile/viewPointsUser5');
        $I->seeInSource('trophy2.png');
        $I->seeInSource('76 Points');
        $I->see('3', '#level');

        $I->haveInDatabase('users', array('id' => 110, 'username' => 'viewPointsUser6', 'email' => 'viewPointsUser6@gmail.com', 'points' => 100));
        $I->amOnPage('/profile/viewPointsUser6');
        $I->seeInSource('trophy2.png');
        $I->seeInSource('100 Points');
        $I->see('3', '#level');

        $I->haveInDatabase('users', array('id' => 111, 'username' => 'viewPointsUser7', 'email' => 'viewPointsUser7@gmail.com', 'points' => 101));
        $I->amOnPage('/profile/viewPointsUser7');
        $I->seeInSource('trophy2.png');
        $I->seeInSource('101 Points');
        $I->see('4', '#level');

        $I->haveInDatabase('users', array('id' => 112, 'username' => 'viewPointsUser8', 'email' => 'viewPointsUser8@gmail.com', 'points' => 150));
        $I->amOnPage('/profile/viewPointsUser8');
        $I->seeInSource('trophy2.png');
        $I->seeInSource('150 Points');
        $I->see('4', '#level');

        $I->haveInDatabase('users', array('id' => 113, 'username' => 'viewPointsUser9', 'email' => 'viewPointsUser9@gmail.com', 'points' => 151));
        $I->amOnPage('/profile/viewPointsUser9');
        $I->seeInSource('trophy3.png');
        $I->seeInSource('151 Points');
        $I->see('5', '#level');

        $I->haveInDatabase('users', array('id' => 114, 'username' => 'viewPointsUser10', 'email' => 'viewPointsUser10@gmail.com', 'points' => 250));
        $I->amOnPage('/profile/viewPointsUser10');
        $I->seeInSource('trophy3.png');
        $I->seeInSource('250 Points');
        $I->see('5', '#level');

        $I->haveInDatabase('users', array('id' => 115, 'username' => 'viewPointsUser11', 'email' => 'viewPointsUser11@gmail.com', 'points' => 251));
        $I->amOnPage('/profile/viewPointsUser11');
        $I->seeInSource('trophy3.png');
        $I->seeInSource('251 Points');
        $I->see('6', '#level');

        $I->haveInDatabase('users', array('id' => 116, 'username' => 'viewPointsUser12', 'email' => 'viewPointsUser12@gmail.com', 'points' => 300));
        $I->amOnPage('/profile/viewPointsUser12');
        $I->seeInSource('trophy3.png');
        $I->seeInSource('300 Points');
        $I->see('6', '#level');
    }

}