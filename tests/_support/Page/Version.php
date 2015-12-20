<?php
namespace Page;

use Facebook\WebDriver\WebDriverBy;

class Version
{
    // include url of current page
    public static $URL = '';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
//    public static function route($param)
//    {
//        return static::$URL.$param;
//    }
    protected $tester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    public function fillVersionMissingVersion() {
        $I = $this->tester;
        $I->attachFile('image1', 'image1.jpg');
    }

    public function fillVersionLongVersion() {
        $I = $this->tester;
        $I->attachFile('image1', 'image1.jpg');
        $I->fillField('version', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
    }

    public function fillVersionMissingImage() {
        $I = $this->tester;
        $I->fillField('version', '3.4.5');
    }

    public function fillVersionLargeImage() {
        $I = $this->tester;
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image-large.jpg');
    }

    public function fillVersionLongVideoLink() {
        $I = $this->tester;
        $I->fillField('version', '3.4.5');
        $I->fillField('video_link', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsad');
        $I->attachFile('image1', 'image1.jpg');
    }

    public function fillVersionInvalidVideoLink() {
        $I = $this->tester;
        $I->fillField('version', '3.4.5');
        $I->fillField('video_link', 'invalid-link');
        $I->attachFile('image1', 'image1.jpg');
    }

    public function fillVersionLongUpcomingFeatures() {
        $I = $this->tester;
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('upcoming_features_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfds");
            $webdriver->switchTo()->defaultContent();
        });
    }

    public function fillVersionLongChanges() {
        $I = $this->tester;
        $I->fillField('version', '3.4.5');
        $I->attachFile('image1', 'image1.jpg');

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
            $webdriver->switchTo()->frame('changes_ifr');
            $webdriver->findElement(WebDriverBy::id('tinymce'))->click();
            $webdriver->findElement(WebDriverBy::id("tinymce"))->sendKeys("fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfds");
            $webdriver->switchTo()->defaultContent();
        });
    }




}