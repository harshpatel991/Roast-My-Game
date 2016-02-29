<?php
class ForumCreateCest
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
        $I->amOnPage('/add-discussion');
        $I->see('Login');
        $I->dontSee('Add Forum Post');
    }

    public function testAddMinimumDiscussionValues(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');

        $I->amOnPage('/add-discussion');
        $I->fillField('title', 'Test Minimal Discussion Title');
        $I->selectOption('select[name=category]', 'Announcements');
        $I->fillField('content', 'Test minimal discussion content');
        $I->click('Add Forum Post');

        $I->see('Discussion added!');
        $I->see('Test Minimal Discussion Title');
        $I->see('Announcements');
        $I->see('Test minimal discussion content');
        $I->seeInDatabase('discussions', array('title' => 'Test Minimal Discussion Title',
                                        'category' => 'announcements',
                                        'content' => 'Test minimal discussion content'));
    }

    public function testAddInvalidTitle(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');

        $I->amOnPage('/add-discussion');
        $I->fillField('title', '');
        $I->selectOption('select[name=category]', 'Announcements');
        $I->fillField('content', 'Test minimal discussion content');
        $I->click('Add Forum Post');

        $I->see('The title field is required.');
    }

    public function testAddInvalidCategory(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');

        $I->amOnPage('/add-discussion');
        $I->fillField('title', 'Valid Title');
        //no category selected
        $I->fillField('content', 'Test minimal discussion content');
        $I->click('Add Forum Post');

        $I->see('The category field is required.');
    }

    public function testAddInvalidContent(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user1@gmail.com', 'password1');

        $I->amOnPage('/add-discussion');
        $I->fillField('title', 'Valid Title');
        $I->selectOption('select[name=category]', 'Announcements');
        //no content
        $I->click('Add Forum Post');

        $I->see('The content field is required.');
    }
}