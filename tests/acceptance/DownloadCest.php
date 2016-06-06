<?php

use Page\Version as VersionPage;
use Page\Game as GamePage;

class DownloadCest
{
    private static $platforms = array('platform_pc', 'platform_mac', 'platform_linux', 'platform_ios', 'platform_android', 'platform_unity', 'platform_other');
    private static $platformsToName = array('platform_pc' => 'PC', 'platform_mac' => 'Mac', 'platform_linux' => 'Linux', 'platform_ios' => 'iOS', 'platform_android' => 'Android', 'platform_unity' => 'Unity Web', 'platform_other' => 'Other Web');

    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    private function openEditDownloadsPage(AcceptanceTester $I, $userName, $gameSlug) {
        $I->amOnPage('/profile/'.$userName);
        $I->click('#edit-downloads-'.$gameSlug);
    }

    public function testSetAllTextValues(\AcceptanceTester $I) {
        $gameSlug = 'test-game-1';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->click('#add-link-instead-'.$platform);
            $I->fillField('#link_input_'.$platform, 'http://'. $platform .'-download-link.com');
            $dbExpectedValues['link_'.$platform]  = 'http://'. $platform .'-download-link.com';
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testSetAllFileValues(\AcceptanceTester $I) {
        $gameSlug = 'test-game-1';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->attachFile('#file_select_'.$platform, 'gameUploadFile1.zip');
            $I->click('#upload_button_'.$platform);
            $I->wait(2);
            $dbExpectedValues['link_'.$platform]  = 'https://clickr.app/download/'.$gameSlug.'/'. $platform .'/'.$gameSlug.'-'. $platform .'.zip';
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testSwitchFileUploadToTextField(\AcceptanceTester $I) {
        $gameSlug = 'test-game-3';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->click('#add-link-instead-'.$platform);
            $I->fillField('#link_input_'.$platform, 'http://'. $platform .'-download-link.com');
            $dbExpectedValues['link_'.$platform]  = 'http://'. $platform .'-download-link.com';
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testSwitchTextFieldToFileUpload(\AcceptanceTester $I) {
        $gameSlug = 'test-game-2';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->click('#add-file-instead-'.$platform);
            $I->attachFile('#file_select_'.$platform, 'gameUploadFile1.zip');
            $I->click('#upload_button_'.$platform);
            $I->wait(2);
            $dbExpectedValues['link_'.$platform]  = 'https://clickr.app/download/'.$gameSlug.'/'. $platform .'/'.$gameSlug.'-'. $platform .'.zip';
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testRemoveFileUpload(\AcceptanceTester $I) {
        $gameSlug = 'test-game-3';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->click('#delete_button_'.$platform);
            $dbExpectedValues['link_'.$platform]  = null;
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testNoEditChange(\AcceptanceTester $I) {
        $gameSlug = 'test-game-4';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $dbExpectedValues['link_'.$platform] = $I->grabFromDatabase('games', 'link_'.$platform, array('slug' => $gameSlug));
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testFullTextInputToMinimal(\AcceptanceTester $I) {
        $gameSlug = 'test-game-2';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->fillField('#link_input_'.$platform, ''); //clear it out
            $dbExpectedValues['link_'.$platform] = null;
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testFlipFlopToTextInput(\AcceptanceTester $I) {
        $gameSlug = 'test-game-2';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        //set text input to some garbage value
        foreach($this::$platforms as $platform) {
            $I->fillField('#link_input_'.$platform, 'garbage');
        }

        //set file input ot some garbage value
        foreach($this::$platforms as $platform) {
            $I->click('#add-file-instead-'.$platform);
            $I->attachFile('#file_select_'.$platform, 'gameUploadFile1.zip');
            $I->click('#upload_button_'.$platform);
        }

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->click('#add-link-instead-'.$platform);
            $I->fillField('#link_input_'.$platform, 'http://'. $platform .'-download-link.com');
            $dbExpectedValues['link_'.$platform]  = 'http://'. $platform .'-download-link.com';
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testFlipFlopToFileInput(\AcceptanceTester $I) {
        $gameSlug = 'test-game-3';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        //remove existing file inputs
        foreach($this::$platforms as $platform) {
            $I->click('#delete_button_'.$platform);
        }

        //set text input to some garbage value
        foreach($this::$platforms as $platform) {
            $I->click('#add-link-instead-'.$platform);
            $I->fillField('#link_input_'.$platform, 'garbage');
        }

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->click('#add-file-instead-'.$platform);
            $I->attachFile('#file_select_'.$platform, 'gameUploadFile1.zip');
            $I->click('#upload_button_'.$platform);
            $dbExpectedValues['link_'.$platform]  = 'https://clickr.app/download/'.$gameSlug.'/'. $platform .'/'.$gameSlug.'-'. $platform .'.zip';
        }

        $I->click('#add-downloads');
        
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testPreviousTextValuesShow(\AcceptanceTester $I) {
        $gameSlug = 'test-game-2';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        foreach($this::$platforms as $platform) {
            $I->seeInField('#link_input_'.$platform, 'http://existing-'.$platform.'-link.com');
        }
    }

    public function testPreviousFileValuesShow(\AcceptanceTester $I) {
        $gameSlug = 'test-game-3';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        foreach($this::$platforms as $platform) {
            $I->see('Uploaded', '#file_name_display_'.$platform);
        }
    }

    //Game page
    public function testClickDownloadGame(\AcceptanceTester $I) {
        $gameSlug = 'test-game-3';
        $I->amOnPage('game/test-game-3');
        $I->click(['id' => 'download-dropdown']); //click download drop down

        foreach($this::$platforms as $platform) {
            $I->seeLink('Download for PC', 'https://clickr.app/download/'.$gameSlug.'/'. $platform .'/'.$gameSlug.'-'. $platform .'.zip');
        }

        foreach($this::$platforms as $platform) {
            $platformName = $this::$platformsToName[$platform];

            if($platform != 'platform_unity' && $platform != 'platform_other') { //unity and Other have differnt link names
                $I->click('Download for ' . $platformName);
            } else {
                $I->click('Play with ' . $platformName);
            }
            $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
                $handles = $webdriver->getWindowHandles();
                $last_window = end($handles);
                $webdriver->switchTo()->window($last_window);
            });

            $I->seeInSource('https://s3-us-west-2.amazonaws.com/rmg-upload/'.$gameSlug.'/game-files/'.$gameSlug.'-'.$platform.'.zip');
            $I->switchToWindow();
            $I->click(['id' => 'download-dropdown']); //click download drop down
        }
    }

    public function testClickDownloadExternalLink(\AcceptanceTester $I) {
        $I->amOnPage('game/test-game-2');
        $I->click(['id' => 'download-dropdown']); //click download drop down

        foreach($this::$platforms as $platform) {
            $platformName = $this::$platformsToName[$platform];

            if($platform != 'platform_unity' && $platform != 'platform_other') { //unity and Other have differnt link names
                $I->seeLink('Download for ' . $platformName, 'http://existing-'.$platform.'-link.com/');
            } else {
                $I->seeLink('Play with ' . $platformName, 'http://existing-'.$platform.'-link.com/');
            }
        }
    }

}