<?php
class VersionCreateCest
{

    public function testAddMinimumVersionValues(\AcceptanceTester $I)
    {
        $I->wantTo('Create minimum version works');
        $I->amOnPage('/auth/login');
        $I->fillField('email', 'user1@gmail.com');
        $I->fillField('password', 'password1');
        $I->click(['id' => 'login']);

        $I->amOnPage('/profile');
        $I->click('Add Progress');

        $I->fillField('version', '2');
        $I->attachFile('image1', 'image5.jpg');
        $I->click('Add Progress!');

        //verify
        $I->see('Test Game 1');
        $I->see('Action');
        $I->see('This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.');

        $I->see('PC');
        $I->see('Android');
        $I->see('Other Web');
        $I->seeInSource('<a href="http://pc.com">');
        $I->seeInSource('<a href="http://android.com">');
        $I->seeInSource('<a href="http://other-web.com">');

        $I->seeInSource('<a href="http://greenlight.com">');
        $I->seeInSource('<a href="http://website.com">');
        $I->seeInSource('<a href="http://link-twitter.com">');
        $I->seeInSource('<a href="http://link-youtube.com">');
        $I->seeInSource('<a href="http://link-gplus.com">');
        $I->seeInSource('<a href="http://link-facebook.com">');

        $I->see('VERSION 2');
        $I->dontSee('BETA');
        $I->seeInSource("selectImage('/upload/test-game-1-2-1.jpg')");

        $I->dontSee('Changes made this version in 1.2.5');
        $I->dontSee('Upcomming feaures 1.2.5');
    }

    public function testAddFullVersionValues(\AcceptanceTester $I)
    {
        $I->wantTo('Create full version works');
        $I->amOnPage('/auth/login');
        $I->fillField('email', 'user1@gmail.com');
        $I->fillField('password', 'password1');
        $I->click(['id' => 'login']);

        $I->amOnPage('/profile');
        $I->click('Add Progress');

        $I->fillField('version', '3');
        $I->checkOption('#beta');
        $I->fillField('video_link', 'https://www.youtube.com/watch?v=BsjuLsKAEFA');
        $I->attachFile('image1', 'image1.jpg');
        $I->attachFile('image2', 'image2.jpg');
        $I->attachFile('image3', 'image3.jpg');
        $I->attachFile('image4', 'image4.jpg');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('changes_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("Here are some changes for version 3.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('upcoming_features_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("Here are some upcoming features for version 3.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->click('Add Progress!');
        $I->see('Test Game 1');
        $I->see('Action');
        $I->see('This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.');

        $I->see('PC');
        $I->dontSee('Mac');
        $I->see('Android');
        $I->dontSee('iOS');
        $I->dontSee('Unity Web');
        $I->see('Other Web');
        $I->seeInSource('<a href="http://pc.com">');
        $I->seeInSource('<a href="http://android.com">');
        $I->seeInSource('<a href="http://other-web.com">');

        $I->seeInSource('<a href="http://greenlight.com">');
        $I->seeInSource('<a href="http://website.com">');
        $I->seeInSource('<a href="http://link-twitter.com">');
        $I->seeInSource('<a href="http://link-youtube.com">');
        $I->seeInSource('<a href="http://link-gplus.com">');
        $I->seeInSource('<a href="http://link-facebook.com">');

        $I->see('VERSION 3');
        $I->see('BETA');
        $I->seeInSource('http://img.youtube.com/vi/BsjuLsKAEFA/mqdefault.jpg');
        $I->seeInSource("selectImage('/upload/test-game-1-3-1.jpg')");
        $I->seeInSource("selectImage('/upload/test-game-1-3-2.jpg')");
        $I->seeInSource("selectImage('/upload/test-game-1-3-3.jpg')");
        $I->seeInSource("selectImage('/upload/test-game-1-3-4.jpg')");

        $I->see('Here are some changes for version 3.');
        $I->see('Here are some upcoming features for version 3.');

    }
}