<?php

class AllGamesCest
{

    public function testViewGenres(\AcceptanceTester $I)
    {
        $I->amOnPage('/games');

        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 3');
        $I->see('Test Game 4');
        $I->see('Test Game 5');
        $I->see('Test Game 6');

        $I->click(['id' => 'genre-dropdown']);
        $I->click('Action');
        $I->see('Test Game 1');
        $I->dontSee('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');

        $I->click(['id' => 'genre-dropdown']);
        $I->click('Puzzle');
        $I->dontSee('Test Game 1');
        $I->dontSee('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->see('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');
    }

    public function testViewInvalidGenre(\AcceptanceTester $I)
    {
        $I->amOnPage('/games/blah');
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
    }

    public function testViewPlatforms(\AcceptanceTester $I)
    {
        $I->amOnPage('/games');

        $I->click(['id' => 'platform-dropdown']);
        $I->click('PC');
        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');

        $I->click(['id' => 'platform-dropdown']);
        $I->click('Other Web');
        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');

        $I->click(['id' => 'platform-dropdown']);
        $I->click('Android');
        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');

        $I->click(['id' => 'platform-dropdown']);
        $I->click('Unity Web');
        $I->see('Test Game 1');
        $I->see('Test Game 2');
        $I->see('Test Game 4');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 5');
    }

    public function testViewInvalidPlatform(\AcceptanceTester $I)
    {
        $I->amOnPage('/games/by_platform/blah');
        $I->see('404 Not Found');
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
    }


}