<?php

use Page\Version as VersionPage;
use Page\Game as GamePage;

class GameEditInvalidCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testEditWithoutOwning(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/edit-game/test-game-1/1.2.3');

        $I->dontSee('Edit Test Game 1');
    }

    public function testEditWithoutLoggedIn(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/edit-game/test-game-1/1.2.3');

        $I->dontSee('Edit Test Game 1');
    }

    public function testCreateInvalidTitle(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);

        $gamePage = new GamePage($I);
        $gamePage->fillFormMissingTitle();
        $I->click('Save Changes');
        $I->see('The title field is required.');

        $gamePage->fillFormLongTitle();
        $I->click('Save Changes');
        $I->see('The title may not be greater than 255 characters.');
    }

    public function testCreateInvalidGenre(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid genre game');
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);

        $gamePage = new GamePage($I);
        $gamePage->fillFormMissingGenre();
        $I->click('Save Changes');

        $I->see('The genre field is required.');
    }

    public function testCreateInvalidDescription(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid description game');
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop(true);
        $gamePage->fillFormLongDescription();
        $I->click('Save Changes');

        $I->see('The description may not be greater than 5000 characters.');
    }

    public function testCreateInvalidSocialLinks(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid description game');
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop(true);
        $gamePage->fillFormInvalidSocialLinks();
        $I->click('Save Changes');

        $I->see('The link social greenlight format is invalid.');
        $I->see('The link social kickstarter format is invalid.');
        $I->see('The link social website format is invalid.');
        $I->see('The link social twitter format is invalid.');
        $I->see('The link social youtube format is invalid.');
        $I->see('The link social google plus format is invalid.');
        $I->see('The link social facebook format is invalid.');

        //test: too long links
        $gamePage->fillFormLongSocialLinks();
        $I->click('Save Changes');

        $I->see('The link social greenlight may not be greater than 255 characters.');
        $I->see('The link social kickstarter may not be greater than 255 characters.');
        $I->see('The link social website may not be greater than 255 characters.');
        $I->see('The link social twitter may not be greater than 255 characters.');
        $I->see('The link social youtube may not be greater than 255 characters.');
        $I->see('The link social google plus may not be greater than 255 characters.');
        $I->see('The link social facebook may not be greater than 255 characters.');
    }

    public function testCreateInvalidVersion(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop(true);

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionMissingVersion(true);
        $I->click('Save Changes');
        $I->see('The version field is required.');

        $versionPage->fillVersionLongVersion(true);
        $I->click('Save Changes');
        $I->see('The version may not be greater than 255 characters.');
    }

    public function testCreateInvalidVideoLink(\AcceptanceTester $I) {
        $I->wantTo('Create long video link game');
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop(true);

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongVideoLink(true);
        $I->click('Save Changes');
        $I->see('The video link may not be greater than 255 characters.');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionInvalidVideoLink(true);
        $I->click('Save Changes');
        $I->see('The video link format is invalid.');
    }

    public function testCreateInvalidChanges(\AcceptanceTester $I) {
        $I->wantTo('Create long changes version');
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop(true);

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongChanges(true);
        $I->click('Save Changes');
        $I->see('The changes may not be greater than 5000 characters.');
    }

    public function testCreateInvalidUpcomingFeatures(\AcceptanceTester $I)
    {
        $I->wantTo('Create long upcoming features version');
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop(true);

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongUpcomingFeatures(true);
        $I->click('Save Changes');
        $I->see('The upcoming features may not be greater than 5000 characters.');
    }

}