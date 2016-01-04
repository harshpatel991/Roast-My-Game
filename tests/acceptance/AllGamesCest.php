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

        $I->click('ACTION');
        $I->see('Test Game 1');
        $I->dontSee('Test Game 2');
        $I->dontSee('Test Game 3');
        $I->dontSee('Test Game 4');
        $I->dontSee('Test Game 5');
        $I->dontSee('Test Game 6');

        $I->click('PUZZLE');
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

}