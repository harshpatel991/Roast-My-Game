<?php

use Page\Version as VersionPage;
use Page\Game as GamePage;

class GameCreateInvalidCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testAddWithoutPermissions(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('Add Game');

        $I->see('Login');

        $I->fillField('email', 'user1@gmail.com');
        $I->fillField('password', 'password1');
        $I->click(['id' => 'login']);

        $I->see('Add Your Game');//test got redirected
    }

    public function testAddWithoutMinimumComments(\AcceptanceTester $I)
    {
        $I->resetEmails();

        $I->amOnPage('/');
        $this->loginAs($I, 'user4@gmail.com', 'password4');

        $I->click('Add Game');

        $I->see('Profile');
        $I->see('To give a chance for all games to get feedback, you must roast one game before adding your own game.');

        $I->seeEmailCount(0); //check no emails sent
    }

    public function testCreateInvalidTitle(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid title game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillFormMissingTitle();
        $I->click('#add-game');
        $I->see('The title field is required.');

        $gamePage->fillFormLongTitle();
        $I->click('#add-game');
        $I->see('The title may not be greater than 255 characters.');
    }

    public function testCreateInvalidGenre(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid genre game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillFormMissingGenre();
        $I->click('#add-game');

        $I->see('The genre field is required.');
    }

    public function testCreateInvalidThumbnail(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid genre game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillFormMissingThumbnail();
        $I->click('#add-game');

        $I->see('The thumbnail field is required.');

        $gamePage = new GamePage($I);
        $gamePage->fillFormLargeThumbnail();
        $I->click('#add-game');

        $I->see('The thumbnail may not be greater than 2000 kilobytes.');
    }

    public function testCreateInvalidDescription(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid description game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();

        $versionPage = new VersionPage($I);
        $versionPage->fillValidVersionTop();
        $gamePage->fillFormLongDescription();

        $I->click('#add-game');

        $I->see('The description may not be greater than 5000 characters.');
    }

    public function testCreateInvalidSocialLinks(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid description game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();
        $gamePage->fillFormInvalidSocialLinks();
        $I->click('#add-game');

        $I->see('The link social greenlight format is invalid.');
        $I->see('The link social kickstarter format is invalid.');
        $I->see('The link social website format is invalid.');
        $I->see('The link social twitter format is invalid.');
        $I->see('The link social youtube format is invalid.');
        $I->see('The link social google plus format is invalid.');
        $I->see('The link social facebook format is invalid.');

        //test: too long links
        $gamePage->fillFormLongSocialLinks();
        $I->click('#add-game');

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
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionMissingVersion();
        $I->click('#add-game');
        $I->see('The version field is required.');

        $versionPage->fillVersionLongVersion();
        $I->click('#add-game');
        $I->see('The version may not be greater than 255 characters.');
    }

    public function testCreateInvalidImage(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid image game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionMissingImage();
        $I->click('#add-game');
        $I->see('The image1 field is required.');

        $versionPage->fillVersionLargeImage();
        $I->click('#add-game');
        $I->see('The image1 may not be greater than 2000 kilobytes.');
    }

    public function testCreateInvalidVideoLink(\AcceptanceTester $I) {
        $I->wantTo('Create long video link game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongVideoLink();
        $I->click('#add-game');
        $I->see('The video link may not be greater than 255 characters.');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionInvalidVideoLink();
        $I->click('#add-game');
        $I->see('The video link format is invalid.');
    }

    public function testCreateInvalidChanges(\AcceptanceTester $I) {
        $I->wantTo('Create long changes version');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongChanges();
        $I->click('#add-game');
        $I->see('The changes may not be greater than 5000 characters.');
    }

    public function testCreateInvalidUpcomingFeatures(\AcceptanceTester $I) {
        $I->wantTo('Create long upcoming features version');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongUpcomingFeatures();
        $I->click('#add-game');
        $I->see('The upcoming features may not be greater than 5000 characters.');
    }
}