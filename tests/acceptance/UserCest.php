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

        $I->amOnPage('/game/test-game-7');
        $I->seeInSource('<span class="icon-circle trophy-badge-silver"></span>'); //see sliver badge

        $I->amOnPage('/game/test-game-5');
        $I->seeInSource('<span class="icon-circle trophy-badge-gold"></span>'); //see gold badge
    }

    public function testViewTrophies(\AcceptanceTester $I)
    {
        $I->amOnPage('/profile/user1');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('<span class="icon-circle trophy-badge-silver"></span>');

        $I->amOnPage('/profile/user2');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('<span class="icon-circle trophy-badge-silver"></span>');

        $I->amOnPage('/profile/user3');
        $I->seeInSource('trophy1.jpg');
    }

    public function testViewPoints(\AcceptanceTester $I)
    {
        $I->amOnPage('/profile/user1');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('300 Points');

        $I->amOnPage('/profile/user2');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('100 Points');

        $I->amOnPage('/profile/user3');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('0 Points');
    }

    public function testViewAllPoints(\AcceptanceTester $I)
    {
        $I->haveInDatabase('users', array('id' => 14, 'username' => 'viewPointsUser', 'password' => '', 'email' => 'viewPointsUser@gmail.com', 'points' => 0, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('0 Points');
        $I->see('1', '#level');

        $I->haveInDatabase('users', array('id' => 15, 'username' => 'viewPointsUser1', 'password' => '', 'email' => 'viewPointsUser1@gmail.com', 'points' => 5, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser1');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('5 Points');
        $I->see('1', '#level');

        $I->haveInDatabase('users', array('id' => 16, 'username' => 'viewPointsUser2', 'password' => '', 'email' => 'viewPointsUser2@gmail.com', 'points' => 50, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser2');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('50 Points');
        $I->see('1', '#level');

        $I->haveInDatabase('users', array('id' => 17, 'username' => 'viewPointsUser3', 'password' => '', 'email' => 'viewPointsUser3@gmail.com', 'points' => 51, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser3');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('51 Points');
        $I->see('2', '#level');

        $I->haveInDatabase('users', array('id' => 18, 'username' => 'viewPointsUser4', 'password' => '', 'email' => 'viewPointsUser4@gmail.com', 'points' => 75, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser4');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('75 Points');
        $I->see('2', '#level');

        $I->haveInDatabase('users', array('id' => 19, 'username' => 'viewPointsUser5', 'password' => '', 'email' => 'viewPointsUser5@gmail.com', 'points' => 76, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser5');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('76 Points');
        $I->see('3', '#level');

        $I->haveInDatabase('users', array('id' => 110, 'username' => 'viewPointsUser6', 'password' => '', 'email' => 'viewPointsUser6@gmail.com', 'points' => 150, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser6');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('150 Points');
        $I->see('3', '#level');

        $I->haveInDatabase('users', array('id' => 111, 'username' => 'viewPointsUser7', 'password' => '', 'email' => 'viewPointsUser7@gmail.com', 'points' => 151, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser7');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('151 Points');
        $I->see('4', '#level');

        $I->haveInDatabase('users', array('id' => 112, 'username' => 'viewPointsUser8', 'password' => '', 'email' => 'viewPointsUser8@gmail.com', 'points' => 350, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser8');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('350 Points');
        $I->see('4', '#level');

        $I->haveInDatabase('users', array('id' => 113, 'username' => 'viewPointsUser9', 'password' => '', 'email' => 'viewPointsUser9@gmail.com', 'points' => 351, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser9');
        $I->seeInSource('trophy3.jpg');
        $I->seeInSource('351 Points');
        $I->see('5', '#level');

        $I->haveInDatabase('users', array('id' => 114, 'username' => 'viewPointsUser10', 'password' => '', 'email' => 'viewPointsUser10@gmail.com', 'points' => 650, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser10');
        $I->seeInSource('trophy3.jpg');
        $I->seeInSource('650 Points');
        $I->see('5', '#level');

        $I->haveInDatabase('users', array('id' => 115, 'username' => 'viewPointsUser11', 'password' => '', 'email' => 'viewPointsUser11@gmail.com', 'points' => 651, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser11');
        $I->seeInSource('trophy3.jpg');
        $I->seeInSource('651 Points');
        $I->see('6', '#level');

        $I->haveInDatabase('users', array('id' => 116, 'username' => 'viewPointsUser12', 'password' => '', 'email' => 'viewPointsUser12@gmail.com', 'points' => 700, 'created_at' => '2016-01-01 01:01:01', 'updated_at' => '2016-01-01 01:01:01'));
        $I->amOnPage('/profile/viewPointsUser12');
        $I->seeInSource('trophy3.jpg');
        $I->seeInSource('700 Points');
        $I->see('6', '#level');
    }

    public function testChangeProfileImage(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/settings');
        $I->attachFile('profile_image', 'test-profile.png');
        $I->click('#save-profile');

        $I->seeInSource('https://s3-us-west-2.amazonaws.com/rmg-upload/profile-images/user1.jpg');
        $I->seeInDatabase('users', array('username' => 'user1', 'profile_image' => 'user1.jpg'));
    }

    public function testChangePassword(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/settings');
        $I->fillField('#current-password', 'password1');
        $I->fillField('#password', 'password1-new');
        $I->fillField('#password_confirmation', 'password1-new');
        $I->click('#save-password');

        //log out and make sure it changed
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        $this->loginAs($I, 'user1@gmail.com', 'password1'); //try to login with old pass
        $I->see('These credentials do not match our records.');

        $this->loginAs($I, 'user1@gmail.com', 'password1-new');
        $I->see('user1', '#profile-dropdown');//is logged in
    }

    public function testInvalidChangePassword(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/settings');
        //wrong old password
        $I->fillField('#current-password', 'password-wrong');
        $I->fillField('#password', 'password1-new');
        $I->fillField('#password_confirmation', 'password1-new');
        $I->click('#save-password');

        $I->see('Current password is invalid');

        //short new password
        $I->fillField('#current-password', 'password1');
        $I->fillField('#password', 'short');
        $I->fillField('#password_confirmation', 'short');
        $I->click('#save-password');
        $I->see('The password must be at least 6 characters.');

        //not matching new password
        $I->fillField('#current-password', 'password1');
        $I->fillField('#password', 'password-new');
        $I->fillField('#password_confirmation', 'password-new-different');
        $I->click('#save-password');
        $I->see('The password confirmation does not match.');

        //log out and make sure it didn't change
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->see('user1', '#profile-dropdown');//is logged in
    }

    public function testChangeEmailPreferences(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/settings');

        //uncheck all values
        $I->uncheckOption('#mail_roasts');
        $I->uncheckOption('#mail_comments');
        $I->uncheckOption('#mail_progress_reminders');
        $I->uncheckOption('#mail_site_updates');
        $I->click('#save-email');
        $I->see("Email preferences saved!");

        $I->dontSeeCheckboxIsChecked('#mail_roasts');
        $I->dontSeeCheckboxIsChecked('#mail_comments');
        $I->dontSeeCheckboxIsChecked('#mail_progress_reminders');
        $I->dontSeeCheckboxIsChecked('#mail_site_updates');
        $I->seeInDatabase('users', array('username' => 'user1', 'mail_roasts' => 0, 'mail_comments' => 0, 'mail_progress_reminders' => 0, 'mail_site_updates' => 0));

        //check all values
        $I->checkOption('#mail_roasts');
        $I->checkOption('#mail_comments');
        $I->checkOption('#mail_progress_reminders');
        $I->checkOption('#mail_site_updates');
        $I->click('#save-email');
        $I->see("Email preferences saved!");

        $I->seeCheckboxIsChecked('#mail_roasts');
        $I->seeCheckboxIsChecked('#mail_comments');
        $I->seeCheckboxIsChecked('#mail_progress_reminders');
        $I->seeCheckboxIsChecked('#mail_site_updates');
        $I->seeInDatabase('users', array('username' => 'user1', 'mail_roasts' => 1, 'mail_comments' => 1, 'mail_progress_reminders' => 1, 'mail_site_updates' => 1));

        //uncheck some
        $I->checkOption('#mail_roasts');
        $I->uncheckOption('#mail_comments');
        $I->checkOption('#mail_progress_reminders');
        $I->uncheckOption('#mail_site_updates');
        $I->click('#save-email');
        $I->see("Email preferences saved!");

        $I->seeCheckboxIsChecked('#mail_roasts');
        $I->dontSeeCheckboxIsChecked('#mail_comments');
        $I->seeCheckboxIsChecked('#mail_progress_reminders');
        $I->dontSeeCheckboxIsChecked('#mail_site_updates');
        $I->seeInDatabase('users', array('username' => 'user1', 'mail_roasts' => 1, 'mail_comments' => 0, 'mail_progress_reminders' => 1, 'mail_site_updates' => 0));
    }

}