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

    public function testCreateInvalidTitle(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid title game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        //test: no title given
        $I->selectOption('select[name=genre]', 'Action');
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');
        $I->click('Add Game!');

        $I->see('The title field is required.');

        //test: title too long
        $I->fillField('title', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->click('Add Game!');
        $I->see('The title may not be greater than 255 characters.');
    }

    public function testCreateInvalidGenre(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid genre game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        //test: no genre selected
        $I->fillField('title', 'Test Minimal Title');
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');
        $I->click('Add Game!');

        $I->see('The genre field is required.');
    }

    public function testCreateInvalidDescription(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid description game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('description_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfds");
            $webdriver->switchTo()->defaultContent();
        });
        $I->click('Add Game!');

        $I->see('The description may not be greater than 1000 characters.');
    }

    public function testCreateInvalidPlatformLinks(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid description game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');

        //test: non valid links
        $I->click(['link' => 'Add Platform Links']);
        $I->fillField('link_platform_pc', 'invalid-link');
        $I->fillField('link_platform_mac', 'invalid-link');
        $I->fillField('link_platform_ios', 'invalid-link');
        $I->fillField('link_platform_android', 'invalid-link');
        $I->fillField('link_platform_unity', 'invalid-link');
        $I->fillField('link_platform_other', 'invalid-link');
        $I->click('Add Game!');

        $I->see('The link platform pc format is invalid.');
        $I->see('The link platform mac format is invalid.');
        $I->see('The link platform ios format is invalid.');
        $I->see('The link platform android format is invalid.');
        $I->see('The link platform unity format is invalid.');
        $I->see('The link platform other format is invalid.');

        //test: too long links
        $I->fillField('link_platform_pc', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_platform_mac', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_platform_ios', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_platform_android', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_platform_unity', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_platform_other', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->click('Add Game!');

        $I->see('The link platform pc may not be greater than 255 characters.');
        $I->see('The link platform mac may not be greater than 255 characters.');
        $I->see('The link platform ios may not be greater than 255 characters.');
        $I->see('The link platform android may not be greater than 255 characters.');
        $I->see('The link platform unity may not be greater than 255 characters.');
        $I->see('The link platform other may not be greater than 255 characters.');
    }

    public function testCreateInvalidSocialLinks(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid description game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');

        //test: non valid links
        $I->click(['link' => 'Add Social Links']);
        $I->fillField('link_social_greenlight', 'invalid-link');
        $I->fillField('link_social_website', 'invalid-link');
        $I->fillField('link_social_twitter', 'invalid-link');
        $I->fillField('link_social_youtube', 'invalid-link');
        $I->fillField('link_social_google_plus', 'invalid-link');
        $I->fillField('link_social_facebook', 'invalid-link');
        $I->click('Add Game!');

        $I->see('The link social greenlight format is invalid.');
        $I->see('The link social website format is invalid.');
        $I->see('The link social twitter format is invalid.');
        $I->see('The link social youtube format is invalid.');
        $I->see('The link social google plus format is invalid.');
        $I->see('The link social facebook format is invalid.');

        //test: too long links
        $I->fillField('link_social_greenlight', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_social_website', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_social_twitter', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_social_youtube', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_social_google_plus', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->fillField('link_social_facebook', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->click('Add Game!');

        $I->see('The link social greenlight may not be greater than 255 characters.');
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
        $I->click('Add Game!');
        $I->see('The version field is required.');

        $versionPage->fillVersionLongVersion();
        $I->click('Add Game!');
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
        $I->click('Add Game!');
        $I->see('The image1 field is required.');

        $versionPage->fillVersionLargeImage();
        $I->click('Add Game!');
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
        $I->click('Add Game!');
        $I->see('The video link may not be greater than 255 characters.');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionInvalidVideoLink();
        $I->click('Add Game!');
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
        $I->click('Add Game!');
        $I->see('The changes may not be greater than 1000 characters.');
    }

    public function testCreateInvalidUpcomingFeatures(\AcceptanceTester $I) {
        $I->wantTo('Create long upcoming features version');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->click('Add Game');

        $gamePage = new GamePage($I);
        $gamePage->fillValidGameTop();

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongUpcomingFeatures();
        $I->click('Add Game!');
        $I->see('The upcoming features may not be greater than 1000 characters.');
    }
}