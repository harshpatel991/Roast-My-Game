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
        $I->seeInDatabase('games', ['id' => '1', 'likes' => '2']);

        //login as another user and like game
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);
        $this->loginAs($I, 'user3@gmail.com', 'password3');
        $I->amOnPage('/game/test-game-1');
        $I->click('.btn-favorite-background');
        $I->wait(3);

        $I->see('3', '.btn-favorite-container .btn-success');
        $I->seeInDatabase('likes', ['game_id' => '1', 'user_id' => '1']);
        $I->seeInDatabase('games', ['id' => '1', 'likes' => '3']);

        $I->amOnPage('/profile/user2');
        $I->seeInSource('trophy2.jpg');
        $I->seeInSource('110 Points');

        $I->amOnPage('/profile/user3');
        $I->seeInSource('trophy1.jpg');
        $I->seeInSource('10 Points');
    }

    public function testLikeAlreadyLiked(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/game/test-game-1');

        $I->dontSeeElement('.btn-favorite-background');
    }

}