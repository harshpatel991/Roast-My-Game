<?php

class LikesCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testAddLikeWithoutPermissions(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->amOnPage('/game/test-game-1');
        $I->click('.btn-favorite-background');
        $I->wait(3);
        $I->seeInCurrentUrl('/auth/login'); //redirected to the login page
    }

    public function testAddNormalLike(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');
        $I->click('.btn-favorite-background');
        $I->wait(3);

        $I->see('2', '.btn-favorite-container .btn-success');
        $I->seeInDatabase('likes', ['game_id' => '1', 'user_id' => '2']);
    }

    public function testLikeAlreadyLiked(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/game/test-game-1');

        $I->dontSeeElement('.btn-favorite-background');
    }

}