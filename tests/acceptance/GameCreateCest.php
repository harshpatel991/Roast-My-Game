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
        $I->attachFile('thumbnail', 'image2.jpg');
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');
        $I->click('Add Game!');

        $I->see('Your game has been added!');
        $I->see('Test Minimal Title');
        $I->see('Action');
        $I->see('VERSION 3.4.5');
        $I->dontSee('BETA');
        $I->dontSee('Download');
        $I->dontSee('Links');
        $I->seeInSource("selectImage('http://s3-us-west-2.amazonaws.com/rmg-upload/test-minimal-title/test-minimal-title-345-1.jpg')");
        $I->seeInDatabase('games', array('title' => 'Test Minimal Title',
                                        'genre' => 'action',
                                        'thumbnail' => 'test-minimal-title-thumb.jpg'));
        $I->seeInDatabase('versions', array('version' => '3.4.5',
                                        'beta' => 0,
                                        'image1' => 'test-minimal-title-345-1.jpg'));

        $I->amOnPage('/profile/user1');
        $I->seeInSource('trophy3.jpg');
        $I->seeInSource('400 Points');
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
        $I->attachFile('thumbnail', 'image2.jpg');
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('description_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            //5000 characters
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample des");
            $webdriver->switchTo()->defaultContent();
        });

        $I->click(['link' => 'Add Social Links']);
        $I->wait(1);
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

        $I->click(['link' => 'Add Download Game Links']);
        $I->wait(1);
        $I->fillField('link_platform_pc', 'http://pc-full-game-version-1.com');
        $I->fillField('link_platform_mac', 'http://mac-full-game-version-1.com');
        $I->fillField('link_platform_ios', 'http://ios-full-game-version-1.com');
        $I->fillField('link_platform_android', 'http://android-full-game-version-1.com');
        $I->fillField('link_platform_unity', 'http://unity-web-full-game-version-1.com');
        $I->fillField('link_platform_other', 'http://other-web-full-game-version-1.com');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('changes_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            //5000 characters
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are");
            $webdriver->switchTo()->defaultContent();
        });

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('upcoming_features_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming featur");
            $webdriver->switchTo()->defaultContent();
        });
        $I->click('Add Game!');

        $I->see('Your game has been added!');
        $I->see('Test Full Title');
        $I->see('Shooter');
        $I->see('This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample des');

        $I->click(['id' => 'download-dropdown']); //click download drop down
        $I->see('Download for PC');
        $I->see('Download for Mac');
        $I->see('Download for Android');
        $I->see('Download for iOS');
        $I->see('Play with Unity Web');
        $I->see('Play with Other Web');
        $I->seeInSource('http://pc-full-game-version-1.com');
        $I->seeInSource('http://mac-full-game-version-1.com');
        $I->seeInSource('http://ios-full-game-version-1.com');
        $I->seeInSource('http://android-full-game-version-1.com');
        $I->seeInSource('http://unity-web-full-game-version-1.com');
        $I->seeInSource('http://other-web-full-game-version-1.com');

        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://greenlight.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://website.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://link-twitter.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://link-youtube.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://link-gplus.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://link-facebook.com">');

        $I->see('VERSION 1');
        $I->see('BETA');
        $I->seeInSource('http://img.youtube.com/vi/BsjuLsKAEFA/mqdefault.jpg');
        $I->seeInSource("selectImage('http://s3-us-west-2.amazonaws.com/rmg-upload/test-full-title/test-full-title-1-1.jpg')");
        $I->seeInSource("selectImage('http://s3-us-west-2.amazonaws.com/rmg-upload/test-full-title/test-full-title-1-2.jpg')");
        $I->seeInSource("selectImage('http://s3-us-west-2.amazonaws.com/rmg-upload/test-full-title/test-full-title-1-3.jpg')");
        $I->seeInSource("selectImage('http://s3-us-west-2.amazonaws.com/rmg-upload/test-full-title/test-full-title-1-4.jpg')");

        $I->click(['id' => 'link-tab-changes']); //open changes tab
        $I->wait(2);
        $I->see('Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are');
        $I->click(['id' => 'link-tab-upcoming_features']); //open upcoming changes
        $I->wait(2);
        $I->see('This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming featur');
        $I->seeInDatabase('games', array('title' => 'Test Full Title',
                                'genre' => 'shooter',
                                'thumbnail' => 'test-full-title-thumb.jpg',
                                'description' => 'This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample description. This is a sample des',
                                'link_social_greenlight' => 'http://greenlight.com',
                                'link_social_website' => 'http://website.com',
                                'link_social_twitter' => 'http://link-twitter.com',
                                'link_social_youtube' => 'http://link-youtube.com',
                                'link_social_google_plus' => 'http://link-gplus.com',
                                'link_social_facebook' => 'http://link-facebook.com'));
        $I->seeInDatabase('versions', array('version' => '1',
            'beta' => 1,
            'video_link' => 'https://www.youtube.com/watch?v=BsjuLsKAEFA',
            'image1' => 'test-full-title-1-1.jpg',
            'image2' => 'test-full-title-1-2.jpg',
            'image3' => 'test-full-title-1-3.jpg',
            'image4' => 'test-full-title-1-4.jpg',
            'link_platform_pc' => 'http://pc-full-game-version-1.com',
            'link_platform_mac' => 'http://mac-full-game-version-1.com',
            'link_platform_ios' => 'http://ios-full-game-version-1.com',
            'link_platform_android' => 'http://android-full-game-version-1.com',
            'link_platform_unity' => 'http://unity-web-full-game-version-1.com',
            'link_platform_other' => 'http://other-web-full-game-version-1.com',
            'changes' => 'Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are some changes. Here are',
            'upcoming_features' => 'This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming features. This is a sample upcoming featur'));

        $I->amOnPage('/profile/user1');
        $I->seeInSource('trophy3.jpg');
        $I->seeInSource('400 Points');
    }

    public function testAddExistingGameTitleGame(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user3@gmail.com', 'password3');

        $I->click('Add Game');
        $I->fillField('title', 'Test Game 3');
        $I->selectOption('select[name=genre]', 'Action');
        $I->attachFile('thumbnail', 'image2.jpg');
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');
        $I->click('Add Game!');

        $I->see('Your game has been added!');
        $I->see('Test Game 3');
        $I->see('Action');
        $I->see('VERSION 3.4.5');
        $I->dontSee('BETA');
        $I->dontSee('Download');
        $I->dontSee('Links');
        $I->seeInSource("selectImage('http://s3-us-west-2.amazonaws.com/rmg-upload/test-game-3-1/test-game-3-1-345-1.jpg')");
        $I->seeInDatabase('games', array('title' => 'Test Game 3',
            'genre' => 'action',
            'slug' => 'test-game-3-1'));
        $I->seeInDatabase('versions', array('version' => '3.4.5',
            'beta' => 0,
            'image1' => 'test-game-3-1-345-1.jpg'));
    }

    public function testViewFormattedTextBoxValues(\AcceptanceTester $I)
    {
        $I->amOnPage('/game/test-game-6');
        $I->seeInSource('text<br /><br />pharagraph text<br /><br /><strong>bold text</strong><br /><br /><em>italics text</em><br /><br /><a href="http://google.com">link</a><br /><br />');
        $I->seeInSource('<ul>');
        $I->seeInSource('<li>bullet1</li>');
        $I->seeInSource('<li>bullet2</li>');
        $I->seeInSource('<li>bullet3</li>');
        $I->seeInSource('</ul>');
        $I->seeInSource('<br />');
        $I->seeInSource('<ol>');
        $I->seeInSource('<li>number1</li>');
        $I->seeInSource('<li>number2</li>');
        $I->seeInSource('<li>number3</li>');
        $I->seeInSource('</ol>');

        $I->click(['id' => 'link-tab-changes']); //open changes tab
        $I->wait(2);
        $I->seeInSource('text<br /><br />pharagraph text<br /><br /><strong>bold text</strong><br /><br /><em>italics text</em><br /><br /><a href="http://google.com">link</a><br /><br />');
        $I->seeInSource('<ul>');
        $I->seeInSource('<li>bullet1</li>');
        $I->seeInSource('<li>bullet2</li>');
        $I->seeInSource('<li>bullet3</li>');
        $I->seeInSource('</ul>');
        $I->seeInSource('<br />');
        $I->seeInSource('<ol>');
        $I->seeInSource('<li>number1</li>');
        $I->seeInSource('<li>number2</li>');
        $I->seeInSource('<li>number3</li>');
        $I->seeInSource('</ol>');

        $I->click(['id' => 'link-tab-upcoming_features']); //open upcoming changes
        $I->wait(2);
        $I->seeInSource('text<br /><br />pharagraph text<br /><br /><strong>bold text</strong><br /><br /><em>italics text</em><br /><br /><a href="http://google.com">link</a><br /><br />');
        $I->seeInSource('<ul>');
        $I->seeInSource('<li>bullet1</li>');
        $I->seeInSource('<li>bullet2</li>');
        $I->seeInSource('<li>bullet3</li>');
        $I->seeInSource('</ul>');
        $I->seeInSource('<br />');
        $I->seeInSource('<ol>');
        $I->seeInSource('<li>number1</li>');
        $I->seeInSource('<li>number2</li>');
        $I->seeInSource('<li>number3</li>');
        $I->seeInSource('</ol>');
    }

    public function testAddGameWithGIFImages(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');

        $I->click('Add Game');
        $I->fillField('title', 'Test Game With GIF');
        $I->selectOption('select[name=genre]', 'Action');
        $I->attachFile('thumbnail', 'image2.jpg');
        $I->fillField('version', '1');
        $I->attachFile('image1', 'image.gif');
        $I->click('Add Game!');

        $I->see('Your game has been added!');
        $I->see('Test Game With GIF');
        $I->see('Action');
        $I->see('VERSION 1');
        $I->dontSee('BETA');
        $I->dontSee('Download');
        $I->dontSee('Links');
        $I->seeInSource("selectImage('http://s3-us-west-2.amazonaws.com/rmg-upload/test-game-with-gif/test-game-with-gif-1-1.gif')");
        $I->seeInDatabase('games', array('title' => 'Test Game With GIF',
            'genre' => 'action',
            'slug' => 'test-game-with-gif'));
        $I->seeInDatabase('versions', array('version' => '1',
            'beta' => 0,
            'image1' => 'test-game-with-gif-1-1.gif'));
    }

    public function testAddScriptTags(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');

        $I->click('Add Game');
        $I->fillField('title', 'Test Game With Script Tags');
        $I->selectOption('select[name=genre]', 'Action');
        $I->attachFile('thumbnail', 'image2.jpg');
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('description_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("<script>alert('Should not show up 1');</script>");
            $webdriver->switchTo()->defaultContent();
        });

        $I->fillField('version', '1');
        $I->attachFile('image1', 'image1.jpg');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('changes_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("<script>alert('Should not show up 2');</script>");
            $webdriver->switchTo()->defaultContent();
        });

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('upcoming_features_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("<script>alert('Should not show up 3');</script>");
            $webdriver->switchTo()->defaultContent();
        });

        $I->click('Add Game!');

        $I->see('Your game has been added!');
        $I->see('Test Game With Script Tags');
        $I->see('Action');
        $I->see('VERSION 1');
        $I->dontSee('BETA');
        $I->dontSee('Download');
        $I->dontSee('Links');
        $I->see("<script>alert('Should not show up 1');</script>");
        $I->click(['id' => 'link-tab-changes']); //open changes tab
        $I->wait(2);
        $I->see("<script>alert('Should not show up 2');</script>");
        $I->click(['id' => 'link-tab-upcoming_features']); //open upcoming changes
        $I->wait(2);
        $I->see("<script>alert('Should not show up 3');</script>");
        $I->seeInDatabase('games', array('title' => 'Test Game With Script Tags',
            'genre' => 'action',
            'slug' => 'test-game-with-script-tags',
            'description' => "&lt;script&gt;alert('Should not show up 1');&lt;/script&gt;"));
        $I->seeInDatabase('versions', array('version' => '1',
            'beta' => 0,
            'image1' => 'test-game-with-script-tags-1-1.jpg',
            'changes' => "&lt;script&gt;alert('Should not show up 2');&lt;/script&gt;",
            'upcoming_features' => "&lt;script&gt;alert('Should not show up 3');&lt;/script&gt;"));
    }
}