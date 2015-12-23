<?php

use Page\Version as VersionPage;

class VersionCreateInvalidCest
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
        $I->amOnPage('/add-version/test-game-1');

        $I->see('Login');

        $I->fillField('email', 'user1@gmail.com');
        $I->fillField('password', 'password1');
        $I->click(['id' => 'login']);

        $I->see('Add Progress');//test got redirected
    }

    public function testCreateInvalidVersion(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid version Progress');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile');
        $I->click('Add Progress');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionMissingVersion();
        $I->click('Add Progress!');
        $I->see('The version field is required.');

        $versionPage->fillVersionLongVersion();
        $I->click('Add Progress!');
        $I->see('The version may not be greater than 255 characters.');
    }

    public function testCreateInvalidImage(\AcceptanceTester $I)
    {
        $I->wantTo('Create invalid genre game');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile');
        $I->click('Add Progress');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionMissingImage();
        $I->click('Add Progress!');
        $I->see('The image1 field is required.');

        $versionPage->fillVersionLargeImage();
        $I->click('Add Progress!');
        $I->see('The image1 may not be greater than 2000 kilobytes.');
    }

    public function testCreateInvalidVideoLink(\AcceptanceTester $I) {
        $I->wantTo('Create long video link version');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile');
        $I->click('Add Progress');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongVideoLink();
        $I->click('Add Progress!');
        $I->see('The video link may not be greater than 255 characters.');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionInvalidVideoLink();
        $I->click('Add Progress!');
        $I->see('The video link format is invalid.');
    }

    public function testCreateInvalidChanges(\AcceptanceTester $I) {
        $I->wantTo('Create long changes version');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile');
        $I->click('Add Progress');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongChanges();
        $I->click('Add Progress!');
        $I->see('The changes may not be greater than 1000 characters.');
    }

    public function testCreateInvalidUpcomingFeatures(\AcceptanceTester $I) {
        $I->wantTo('Create long upcoming features version');
        $this->loginAs($I, 'user1@gmail.com', 'password1');
        $I->amOnPage('/profile');
        $I->click('Add Progress');

        $versionPage = new VersionPage($I);
        $versionPage->fillVersionLongUpcomingFeatures();
        $I->click('Add Progress!');
        $I->see('The upcoming features may not be greater than 1000 characters.');
    }

}