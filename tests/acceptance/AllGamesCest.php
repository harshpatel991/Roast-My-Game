<?php

class AllGamesCest
{

    public function testViewAllGames(\AcceptanceTester $I) {
        $I->amOnPage('/games');

        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 3');
        $I->see('Test Game 4');
        $I->see('Test Game 5');
        $I->see('Test Game 6');
        $I->see('Test Game 7');
    }

    public function testViewUnRoastedGames(\AcceptanceTester $I)
    {
        $I->amOnPage('/games');
        $I->click('Not Yet Roasted');

        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 4');
        $I->see('Test Game 6');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 7');
    }

    public function testQueryGenrePlatform(\AcceptanceTester $I)
    {
        $I->amOnPage('/games');

        $I->fillField(['name' => 'query'], '3');
        $I->selectOption(['name' => 'genre'], 'Strategy');
        $I->selectOption(['name' => 'platform'], 'Android');
        $I->click(['id' => 'submit-search']);
        $I->see('Test Game 3');
        $I->dontSee('Test Game 1');
        $I->dontSee('Test Game 2');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
        $I->dontSee('Test Game 7');

        $I->seeInField(['name' => 'query'], '3');
        $I->seeOptionIsSelected(['name' => 'genre'], 'Strategy');
        $I->seeOptionIsSelected(['name' => 'platform'], 'Android');
    }

    public function testQuery(\AcceptanceTester $I)
    {
        $I->amOnPage('/games');

        $I->fillField(['name' => 'query'], '3');
        $I->click(['id' => 'submit-search']);
        $I->see('Test Game 3');
        $I->dontSee('Test Game 1');
        $I->dontSee('Test Game 2');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
        $I->dontSee('Test Game 7');

        $I->seeInField(['name' => 'query'], '3');
    }

    public function testViewGenres(\AcceptanceTester $I)
    {
        $I->amOnPage('/games');

        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 3');
        $I->see('Test Game 4');
        $I->see('Test Game 5');
        $I->see('Test Game 6');
        $I->see('Test Game 7');

        $I->selectOption(['name' => 'genre'], 'Action');
        $I->click(['id' => 'submit-search']);
        $I->see('Test Game 1');
        $I->dontSee('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
        $I->dontSee('Test Game 7');

        $I->selectOption(['name' => 'genre'], 'Puzzle');
        $I->click(['id' => 'submit-search']);
        $I->dontSee('Test Game 1');
        $I->dontSee('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->see('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
    }

    public function testViewInvalidGenre(\AcceptanceTester $I)
    {
        $I->amOnPage('/games?query=&genre=blah&platform=');
        $I->see('404 Not Found');
    }

    public function canSeeAllGenreGamesFromSingleGamePage(\AcceptanceTester $I)
    {
        $I->amOnPage('/game/test-game-1');

        $I->click('ACTION');
        $I->see('Test Game 1');
        $I->dontSee('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
        $I->dontSee('Test Game 7');
    }

    public function testViewPlatforms(\AcceptanceTester $I)
    {
        $I->amOnPage('/games');

        $I->selectOption(['name' => 'genre'], 'PC');
        $I->click(['id' => 'submit-search']);
        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
        $I->dontSee('Test Game 7');

        $I->selectOption(['name' => 'genre'], 'Other Web');
        $I->click(['id' => 'submit-search']);
        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
        $I->dontSee('Test Game 7');

        $I->selectOption(['name' => 'genre'], 'Android');
        $I->click(['id' => 'submit-search']);
        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
        $I->dontSee('Test Game 7');

        $I->selectOption(['name' => 'genre'], 'Unity Web');
        $I->click(['id' => 'submit-search']);
        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 4');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
        $I->dontSee('Test Game 7');
    }

    public function testViewInvalidPlatform(\AcceptanceTester $I)
    {
        $I->amOnPage('/games?query=&genre=&platform=blah');
        $I->see('404 Not Found');
    }
}