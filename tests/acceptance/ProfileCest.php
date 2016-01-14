<?php

class ProfileCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testProfile(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');

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

    public function viewProfileNotLoggedIn(\AcceptanceTester $I) {
        //can't see private buttons
        $I->amOnPage('/profile/user1');

        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 3');
        $I->see('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->see('This is a test comment by user 1 on game 5');
        $I->dontSee('Add Progress');

        $I->amOnPage('/profile/user2');
        $I->see('Test Game 5'); //created
        $I->see('Test Game 2'); //liked
        $I->see('Test Game 3'); //liked
        $I->dontSee('Add Progress');
    }

    public function viewProfileLoggedInButNotOwner(\AcceptanceTester $I) {
        //can't see private buttons
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile/user2');
        $I->see('Test Game 5'); //created
        $I->see('Test Game 2'); //liked
        $I->see('Test Game 3'); //liked
        $I->dontSee('Add Progress');

        $I->amOnPage('/profile/user3');
        $I->see('Test Game 6'); //created
        $I->see('This is a test comment by user 3 on game 3'); //comment
        $I->see('No likes here');
        $I->dontSee('Add Progress');
    }

    public function viewProfileAsOwner(\AcceptanceTester $I) {
        //can see private buttons
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile/user1');
        $I->see('Test Game 1'); //created
        $I->see('Test Game 2'); //created
        $I->see('Test Game 3'); //created
        $I->see('Test Game 4'); //created
        $I->see('Add Progress');
    }

    public function visitProfileFromComment(\AcceptanceTester $I) {
        $I->amOnPage('/game/test-game-5');
        $I->click('user1');
        $I->see('user1\'s Profile');
    }

    public function visitProfileFromCommentReply(\AcceptanceTester $I) {
        $I->amOnPage('/game/test-game-5');
        $I->click('user3');
        $I->see('user3\'s Profile');
    }

    public function visitProfileFromGamePage(\AcceptanceTester $I) {
        $I->amOnPage('/game/test-game-5');
        $I->click('user2');
        $I->see('user2\'s Profile');
    }

    public function visitInvalidProfilePage(\AcceptanceTester $I) {
        $I->amOnPage('/profile/blahblahblah');
        $I->see('404 Not Found');
    }
}