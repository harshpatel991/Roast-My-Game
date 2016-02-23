<?php
class GameEditCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testEditMinimumGameValues(\AcceptanceTester $I)
    {
        $I->wantTo('Edit minimal game works');

        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);
        $I->fillField('title', 'Test Minimal Edit Title');
        $I->selectOption('select[name=genre]', 'Idle');
        $I->fillField('version', '5.6.7');
        $I->click('Save Changes');

        $I->see('Game updated!');
        $I->see('Test Minimal Edit Title');
        $I->see('Idle');
        $I->see('VERSION 5.6.7');
        $I->dontSee('BETA');
        $I->dontSee('Download');
        $I->dontSee('Links');
        $I->seeInSource("selectImage('https://s3-us-west-2.amazonaws.com/rmg-upload/test-game-7/image1.jpg')");
        $I->seeInDatabase('games', array('title' => 'Test Minimal Edit Title',
                                        'slug' => 'test-game-7', //slug doesn't change
                                        'genre' => 'idle',
                                        'thumbnail' => 'test-game-7-thumb.jpg'));
        $I->seeInDatabase('versions', array('game_id' => 7,
            'version' => '5.6.7',
            'slug' => '1.1.1', //slug doesn't change
            'beta' => 0,
            'image1' => 'image1.jpg')); //image doesn't change
    }

    public function testEditAllGameValues(\AcceptanceTester $I)
    {
        $I->wantTo('Edit full game works');

        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile/user1');

        $I->click(['id' => 'edit-test-game-1']);

        $I->fillField('title', 'Test Edited Full Title');
        $I->selectOption('select[name=genre]', 'Idle');
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('description_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("This is an edited description.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->click(['link' => 'Add Social Links']);
        $I->wait(1);
        $I->fillField('link_social_greenlight', 'http://greenlight-edited.com');
        $I->fillField('link_social_website', 'http://website-edited.com');
        $I->fillField('link_social_twitter', 'http://link-twitter-edited.com');
        $I->fillField('link_social_youtube', 'http://link-youtube-edited.com');
        $I->fillField('link_social_google_plus', 'http://link-gplus-edited.com');
        $I->fillField('link_social_facebook', 'http://link-facebook-edited.com');

        $I->fillField('version', '1-edited');
        $I->checkOption('#beta');

        $I->fillField('video_link', 'https://www.youtube.com/watch?v=JLf9q36UsBk');

        $I->click(['link' => 'Add Download Game Links']);
        $I->wait(1);
        $I->fillField('link_platform_pc', 'http://pc-full-game-version-1-edited.com');
        $I->fillField('link_platform_mac', 'http://mac-full-game-version-1-edited.com');
        $I->fillField('link_platform_ios', 'http://ios-full-game-version-1-edited.com');
        $I->fillField('link_platform_android', 'http://android-full-game-version-1-edited.com');
        $I->fillField('link_platform_unity', 'http://unity-web-full-game-version-1-edited.com');
        $I->fillField('link_platform_other', 'http://other-web-full-game-version-1-edited.com');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('changes_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("This is edited changes.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('upcoming_features_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("This is edited upcoming features");
            $webdriver->switchTo()->defaultContent();
        });
        $I->click('Save Changes');

        $I->see('Game updated!');
        $I->see('Test Edited Full Title');
        $I->see('Idle');
        $I->see('This is an edited description.');

        $I->click(['id' => 'download-dropdown']); //click download drop down
        $I->see('Download for PC');
        $I->see('Download for Mac');
        $I->see('Download for Android');
        $I->see('Download for iOS');
        $I->see('Play with Unity Web');
        $I->see('Play with Other Web');
        $I->seeInSource('http://pc-full-game-version-1-edited.com');
        $I->seeInSource('http://mac-full-game-version-1-edited.com');
        $I->seeInSource('http://ios-full-game-version-1-edited.com');
        $I->seeInSource('http://android-full-game-version-1-edited.com');
        $I->seeInSource('http://unity-web-full-game-version-1-edited.com');
        $I->seeInSource('http://other-web-full-game-version-1-edited.com');

        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://greenlight-edited.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://website-edited.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://link-twitter-edited.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://link-youtube-edited.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://link-gplus-edited.com">');
        $I->seeInSource('<a rel="nofollow" target="_blank" href="http://link-facebook-edited.com">');

        $I->see('VERSION 1-EDITED');
        $I->see('BETA');
        $I->seeInSource('https://img.youtube.com/vi/JLf9q36UsBk/mqdefault.jpg');
        $I->seeInSource("selectImage('https://s3-us-west-2.amazonaws.com/rmg-upload/test-game-1/image1.jpg')");
        $I->seeInSource("selectImage('https://s3-us-west-2.amazonaws.com/rmg-upload/test-game-1/image2.jpg')");
        $I->seeInSource("selectImage('https://s3-us-west-2.amazonaws.com/rmg-upload/test-game-1/image3.jpg')");

        $I->click(['id' => 'link-tab-changes']); //open changes tab
        $I->wait(2);
        $I->see('This is edited changes.');
        $I->click(['id' => 'link-tab-upcoming_features']); //open upcoming changes
        $I->wait(2);
        $I->see('This is edited upcoming features');
        $I->seeInDatabase('games', array('title' => 'Test Edited Full Title',
                                'genre' => 'idle',
                                'thumbnail' => 'test-game-1-thumb.jpg',
                                'description' => 'This is an edited description.',
                                'link_social_greenlight' => 'http://greenlight-edited.com',
                                'link_social_website' => 'http://website-edited.com',
                                'link_social_twitter' => 'http://link-twitter-edited.com',
                                'link_social_youtube' => 'http://link-youtube-edited.com',
                                'link_social_google_plus' => 'http://link-gplus-edited.com',
                                'link_social_facebook' => 'http://link-facebook-edited.com'));
        $I->seeInDatabase('versions', array('game_id' => 1,
            'slug' => '1.2.3', //slug doesn't change
            'version' => '1-edited',
            'beta' => 1,
            'video_link' => 'https://www.youtube.com/watch?v=JLf9q36UsBk',
            'image1' => 'image1.jpg',//doesn't change
            'image2' => 'image2.jpg',//doesn't change
            'image3' => 'image3.jpg',//doesn't change
            'link_platform_pc' => 'http://pc-full-game-version-1-edited.com',
            'link_platform_mac' => 'http://mac-full-game-version-1-edited.com',
            'link_platform_ios' => 'http://ios-full-game-version-1-edited.com',
            'link_platform_android' => 'http://android-full-game-version-1-edited.com',
            'link_platform_unity' => 'http://unity-web-full-game-version-1-edited.com',
            'link_platform_other' => 'http://other-web-full-game-version-1-edited.com',
            'changes' => 'This is edited changes.',
            'upcoming_features' => 'This is edited upcoming features'));
    }

    public function testEditMinimumGameValuesUpToFullGame(\AcceptanceTester $I)
    {
        $I->wantTo('Edit a minimal game up to a full game');

        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);
        $I->fillField('title', 'Test Edited Full Title');
        $I->selectOption('select[name=genre]', 'Idle');
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('description_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("This is an edited description.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->click(['link' => 'Add Social Links']);
        $I->wait(1);
        $I->fillField('link_social_greenlight', 'http://greenlight-edited.com');
        $I->fillField('link_social_website', 'http://website-edited.com');
        $I->fillField('link_social_twitter', 'http://link-twitter-edited.com');
        $I->fillField('link_social_youtube', 'http://link-youtube-edited.com');
        $I->fillField('link_social_google_plus', 'http://link-gplus-edited.com');
        $I->fillField('link_social_facebook', 'http://link-facebook-edited.com');

        $I->fillField('version', '1-edited');
        $I->checkOption('#beta');

        $I->fillField('video_link', 'https://www.youtube.com/watch?v=JLf9q36UsBk');

        $I->click(['link' => 'Add Download Game Links']);
        $I->wait(1);
        $I->fillField('link_platform_pc', 'http://pc-full-game-version-1-edited.com');
        $I->fillField('link_platform_mac', 'http://mac-full-game-version-1-edited.com');
        $I->fillField('link_platform_ios', 'http://ios-full-game-version-1-edited.com');
        $I->fillField('link_platform_android', 'http://android-full-game-version-1-edited.com');
        $I->fillField('link_platform_unity', 'http://unity-web-full-game-version-1-edited.com');
        $I->fillField('link_platform_other', 'http://other-web-full-game-version-1-edited.com');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('changes_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("This is edited changes.");
            $webdriver->switchTo()->defaultContent();
        });

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('upcoming_features_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("This is edited upcoming features");
            $webdriver->switchTo()->defaultContent();
        });
        $I->click('Save Changes');

        //========Verify=======

        $I->see('Game updated!');
        $I->see('Test Edited Full Title');
        $I->seeInDatabase('games', array('title' => 'Test Edited Full Title',
            'slug' => 'test-game-7',
            'genre' => 'idle',
            'thumbnail' => 'test-game-7-thumb.jpg',
            'description' => 'This is an edited description.',
            'link_social_greenlight' => 'http://greenlight-edited.com',
            'link_social_website' => 'http://website-edited.com',
            'link_social_twitter' => 'http://link-twitter-edited.com',
            'link_social_youtube' => 'http://link-youtube-edited.com',
            'link_social_google_plus' => 'http://link-gplus-edited.com',
            'link_social_facebook' => 'http://link-facebook-edited.com'));
        $I->seeInDatabase('versions', array('game_id' => 7,
            'slug' => '1.1.1', //slug doesn't change
            'version' => '1-edited',
            'beta' => 1,
            'video_link' => 'https://www.youtube.com/watch?v=JLf9q36UsBk',
            'image1' => 'image1.jpg',//doesn't change
            'link_platform_pc' => 'http://pc-full-game-version-1-edited.com',
            'link_platform_mac' => 'http://mac-full-game-version-1-edited.com',
            'link_platform_ios' => 'http://ios-full-game-version-1-edited.com',
            'link_platform_android' => 'http://android-full-game-version-1-edited.com',
            'link_platform_unity' => 'http://unity-web-full-game-version-1-edited.com',
            'link_platform_other' => 'http://other-web-full-game-version-1-edited.com',
            'changes' => 'This is edited changes.',
            'upcoming_features' => 'This is edited upcoming features'));
    }

    public function testEditFullGameToMinimalGame(\AcceptanceTester $I)
    {
        $I->wantTo('Edit a full game down to a minimal game');

        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile/user1');

        $I->click(['id' => 'edit-test-game-1']);

        $I->fillField('title', 'Test Edited Minimal Title');
        $I->selectOption('select[name=genre]', 'Idle');
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('description_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->switchTo()->defaultContent();
        });

        $I->click(['link' => 'Add Social Links']);
        $I->wait(1);
        $I->fillField('link_social_greenlight', '');
        $I->fillField('link_social_website', '');
        $I->fillField('link_social_twitter', '');
        $I->fillField('link_social_youtube', '');
        $I->fillField('link_social_google_plus', '');
        $I->fillField('link_social_facebook', '');

        $I->fillField('version', '1-edited');
        $I->uncheckOption('#beta');

        $I->fillField('video_link', '');

        $I->click(['link' => 'Add Download Game Links']);
        $I->wait(1);
        $I->fillField('link_platform_pc', '');
        $I->fillField('link_platform_mac', '');
        $I->fillField('link_platform_ios', '');
        $I->fillField('link_platform_android', '');
        $I->fillField('link_platform_unity', '');
        $I->fillField('link_platform_other', '');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('changes_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->switchTo()->defaultContent();
        });

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('upcoming_features_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->clear();
            $webdriver->switchTo()->defaultContent();
        });
        $I->click('Save Changes');

        $I->see('Game updated!');
        $I->see('Test Edited Minimal Title');
        $I->seeInDatabase('games', array('title' => 'Test Edited Minimal Title',
            'slug' => 'test-game-1',
            'genre' => 'idle',
            'thumbnail' => 'test-game-1-thumb.jpg',
            'description' => '',
            'link_social_greenlight' => null,
            'link_social_website' => null,
            'link_social_twitter' => null,
            'link_social_youtube' => null,
            'link_social_google_plus' => null,
            'link_social_facebook' => null));
        $I->seeInDatabase('versions', array('game_id' => 1,
            'slug' => '1.2.3', //slug doesn't change
            'version' => '1-edited',
            'beta' => 0,
            'video_link' => '',
            'image1' => 'image1.jpg',//doesn't change
            'image2' => 'image2.jpg',
            'image3' => 'image3.jpg',
            'image4' => null,
            'link_platform_pc' => null,
            'link_platform_mac' => null,
            'link_platform_ios' => null,
            'link_platform_android' => null,
            'link_platform_unity' => null,
            'link_platform_other' => null,
            'changes' => '',
            'upcoming_features' => ''));
    }

    public function testDontEditMinimumGameValues(\AcceptanceTester $I)
    {
        $I->wantTo('Edit minimal game works when not changing anything');

        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/profile/user2');

        $I->click(['id' => 'edit-test-game-7']);
        $I->click('Save Changes');

        $I->see('Game updated!');
        $I->see('Test Game 7');
        $I->see('strategy');
        $I->see('VERSION 1.1.1');
        $I->dontSee('BETA');
        $I->dontSee('Download');
        $I->dontSee('Links');
        $I->seeInSource("selectImage('https://s3-us-west-2.amazonaws.com/rmg-upload/test-game-7/image1.jpg')");
        $I->seeInDatabase('games', array('title' => 'Test Game 7',
            'slug' => 'test-game-7',
            'genre' => 'strategy',
            'thumbnail' => 'test-game-7-thumb.jpg'));
        $I->seeInDatabase('versions', array('version' => '1.1.1',
            'slug' => '1.1.1',
            'beta' => 0,
            'image1' => 'image1.jpg'));
    }

    public function testEditAllGameValuesDontChangeAnything(\AcceptanceTester $I)
    {
        $I->wantTo('Edit a full game, dont change anything');

        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile/user1');

        $I->click(['id' => 'edit-test-game-1']);
        $I->click('Save Changes');

        $I->seeInDatabase('games', array('title' => 'Test Game 1',
            'genre' => 'action',
            'thumbnail' => 'test-game-1-thumb.jpg',
            'description' => 'This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.',
            'link_social_greenlight' => 'http://greenlight.com',
            'link_social_website' => 'http://website.com',
            'link_social_twitter' => 'http://link-twitter.com',
            'link_social_youtube' => 'http://link-youtube.com',
            'link_social_google_plus' => 'http://link-gplus.com',
            'link_social_facebook' => 'http://link-facebook.com'));
        $I->seeInDatabase('versions', array('game_id' => 1,
            'slug' => '1.2.3',
            'version' => '1.2.3 ',
            'beta' => 1,
            'video_link' => 'https://www.youtube.com/watch?v=e-ORhEE9VVg',
            'image1' => 'image1.jpg',
            'image2' => 'image2.jpg',
            'image3' => 'image3.jpg',
            'image4' => null,
            'link_platform_pc' => 'http://pc-game-1-version-1.2.3.com',
            'link_platform_mac' => null,
            'link_platform_ios' => null,
            'link_platform_android' => 'http://android-game-1-version-1.2.3.com',
            'link_platform_unity' => null,
            'link_platform_other' => 'http://other-web-game-1-version-1.2.3.com',
            'changes' => 'Changes made this version in 1.2.3',
            'upcoming_features' => 'Upcomming feaures 1.2.3'));
    }

    public function testCanSeeExistingValues(\AcceptanceTester $I)
    {
        $I->wantTo('can see all existing values in form');

        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile/user1');
        $I->click(['id' => 'edit-test-game-1']);
        $I->click(['link' => 'Add Social Links']);
        $I->click(['link' => 'Add Download Game Links']);
        $I->wait(1);

        //not able to test that description, changes, upcoming features show up here
        $I->seeInFormFields('form[id=edit-form]', [
            'title' => 'Test Game 1',
            'genre' => 'action',
            'link_social_greenlight' => 'http://greenlight.com',
            'link_social_website' => 'http://website.com',
            'link_social_twitter' => 'http://link-twitter.com',
            'link_social_youtube' => 'http://link-youtube.com',
            'link_social_google_plus' => 'http://link-gplus.com',
            'link_social_facebook' => 'http://link-facebook.com',
            'version' => '1.2.3',
            'video_link' => 'https://www.youtube.com/watch?v=e-ORhEE9VVg',
            'link_platform_pc' => 'http://pc-game-1-version-1.2.3.com',
            'link_platform_mac' => '',
            'link_platform_ios' => '',
            'link_platform_android' => 'http://android-game-1-version-1.2.3.com',
            'link_platform_unity' => '',
            'link_platform_other' => 'http://other-web-game-1-version-1.2.3.com'
        ]);
    }





}