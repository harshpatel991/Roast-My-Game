<?php
class GameCreateCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testAddMinimumGameValues(\AcceptanceTester $I)
    {
        $I->wantTo('Create minimal game works');

        $this->loginAs($I, 'user1@gmail.com', 'password1');

        $I->click('Add Game');
        $I->fillField('title', 'Test Minimal Title');
        $I->selectOption('select[name=genre]', 'Action');
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');
        $I->click('Add Game!');

        $I->see('Test Minimal Title');
        $I->see('Action');
        $I->see('VERSION 3.4.5');
        $I->dontSee('BETA');
        $I->seeInSource("selectImage('/upload/test-minimal-title-345-1.jpg')");
    }

    public function testAddAllGameValues(\AcceptanceTester $I)
    {
        $I->wantTo('Create full game works');
        $I->amOnPage('/auth/login');
        $I->fillField('email', 'user1@gmail.com');
        $I->fillField('password', 'password1');
        $I->click(['id' => 'login']);

        $I->click('Add Game');
        $I->fillField('title', 'Test Full Title');
        $I->selectOption('select[name=genre]', 'Shooter');
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('description_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("Here is a description.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->checkOption('#platform_pc');
        $I->checkOption('#platform_mac');
        $I->checkOption('#platform_ios');
        $I->checkOption('#platform_android');
        $I->checkOption('#platform_unity');
        $I->checkOption('#platform_other');

        $I->click(['link' => 'Add Platform Links']);
        $I->fillField('link_platform_pc', 'http://pc.com');
        $I->fillField('link_platform_mac', 'http://mac.com');
        $I->fillField('link_platform_ios', 'http://ios.com');
        $I->fillField('link_platform_android', 'http://android.com');
        $I->fillField('link_platform_unity', 'http://unity-web.com');
        $I->fillField('link_platform_other', 'http://other-web.com');

        $I->click(['link' => 'Add Social Links']);
        $I->fillField('link_social_greenlight', 'http://greenlight.com');
        $I->fillField('link_social_website', 'http://website.com');
        $I->fillField('link_social_twitter', 'http://link-twitter.com');
        $I->fillField('link_social_youtube', 'http://link-youtube.com');
        $I->fillField('link_social_google_plus', 'http://link-gplus.com');
        $I->fillField('link_social_facebook', 'http://link-facebook.com');

        $I->fillField('version', '1');
        $I->checkOption('#beta');
        $I->fillField('video_link', 'https://www.youtube.com/watch?v=BsjuLsKAEFA');
        $I->attachFile('image1', 'image1.jpg');
        $I->attachFile('image2', 'image2.jpg');
        $I->attachFile('image3', 'image3.jpg');
        $I->attachFile('image4', 'image4.jpg');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('changes_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("Here are some changes.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('upcoming_features_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("Here are some upcoming features.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->click('Add Game!');
        $I->see('Test Full Title');
        $I->see('Shooter');
        $I->see('Here is a description.');

        $I->see('PC');
        $I->see('Mac');
        $I->see('Android');
        $I->see('iOS');
        $I->see('Unity Web');
        $I->see('Other Web');
        $I->seeInSource('<a href="http://pc.com">');
        $I->seeInSource('<a href="http://mac.com">');
        $I->seeInSource('<a href="http://ios.com">');
        $I->seeInSource('<a href="http://android.com">');
        $I->seeInSource('<a href="http://unity-web.com">');
        $I->seeInSource('<a href="http://other-web.com">');

        $I->seeInSource('<a href="http://greenlight.com">');
        $I->seeInSource('<a href="http://website.com">');
        $I->seeInSource('<a href="http://link-twitter.com">');
        $I->seeInSource('<a href="http://link-youtube.com">');
        $I->seeInSource('<a href="http://link-gplus.com">');
        $I->seeInSource('<a href="http://link-facebook.com">');

        $I->see('VERSION 1');
        $I->see('BETA');
        $I->seeInSource('http://img.youtube.com/vi/BsjuLsKAEFA/mqdefault.jpg');
        $I->seeInSource("selectImage('/upload/test-full-title-1-1.jpg')");
        $I->seeInSource("selectImage('/upload/test-full-title-1-2.jpg')");
        $I->seeInSource("selectImage('/upload/test-full-title-1-3.jpg')");
        $I->seeInSource("selectImage('/upload/test-full-title-1-4.jpg')");

        $I->see('Here are some changes.');
        $I->see('Here are some upcoming features.');
    }

    public function testAddFormattedTextBoxValues(\AcceptanceTester $I)
    {
        //TODO
    }


}