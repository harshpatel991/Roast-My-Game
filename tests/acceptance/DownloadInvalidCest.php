<?php

class DownloadInvalidCest
{
    private static $platforms = array('platform_pc', 'platform_mac', 'platform_linux', 'platform_ios', 'platform_android', 'platform_unity', 'platform_other');

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

    public function testAddWithoutPermissions(\AcceptanceTester $I)
    {
        $I->amOnPage('/game/test-game-2');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a sample comment. This is a sample comment.');
        $I->click('Reply');

        $I->see('Login'); //verify the user was directed to the login page
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->see('Test Game 2'); //verify the user was redirected back
        $I->dontSee('Animation', '.media-body');
        $I->dontSee('Level Design', '.media-body');
        $I->dontSee('This is a sample comment. This is a sample comment.');
        $I->dontSeeInDatabase('comments', array('body' => 'This is a sample comment. This is a sample comment.'));
    }

    public function testAddLargeDownload(\AcceptanceTester $I) {
        $gameSlug = 'test-game-1';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->attachFile('#file_select_'.$platform, 'largeGameUploadFile1.zip');
            $I->click('#upload_button_'.$platform);
            $I->wait(2);
            $I->see('Error: The file may not be greater than 20000 kilobytes.', '#error_message_'.$platform);
            $dbExpectedValues['link_'.$platform]  = null;
        }

        $I->click('#add-downloads');
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function testAddBadFileType(\AcceptanceTester $I) {
        $gameSlug = 'test-game-1';
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $this->openEditDownloadsPage($I, 'user1', $gameSlug);

        $dbExpectedValues = array('slug' => $gameSlug);
        foreach($this::$platforms as $platform) {
            $I->attachFile('#file_select_'.$platform, 'image1.jpg');
            $I->click('#upload_button_'.$platform);
            $I->wait(2);
            $I->see('Error: The file must be a file of type: zip.', '#error_message_'.$platform);
            $dbExpectedValues['link_'.$platform]  = null;
        }

        $I->click('#add-downloads');
        $I->seeInDatabase('games', $dbExpectedValues);
    }

    public function editWithoutPermission(\AcceptanceTester $I) {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('add-downloads/test-game-1');
        $I->dontSeeInTitle('Add Downloads');
    }
}