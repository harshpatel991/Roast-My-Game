<?php

class CommentCest
{
    //TODO: add see in db to everything: $I->seeInDatabase('users', array('name' => 'Davert', 'email' => 'davert * `mail.com'));`
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
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

    public function testAddReplyWithoutPermissions(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //Attempt to add a reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'This is a sample reply comment. This is a sample reply comment.');
        $I->click('.reply-form button');

        $I->see('Login'); //verify the user was directed to the login page
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->see('Test Game 1'); //verify the user was redirected back
        $I->dontSee('This is a sample reply comment. This is a sample reply comment.');
        $I->dontSeeInDatabase('comments', array('body' => 'This is a sample reply comment. This is a sample reply comment.'));
    }

    public function testAddFullComment(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a sample comment. This is a sample comment.');
        $I->click('Reply');

        $I->see('Comment added!');
        $I->see('Animation', '.media-body');
        $I->see('Level Design', '.media-body');
        $I->see('This is a sample comment. This is a sample comment.');
        $I->seeInDatabase('comments', array('positive' => 'animation', 'negative' => 'level_design', 'body' => 'This is a sample comment. This is a sample comment.'));
    }

    public function testAddOnlyPositive(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Physics');
        $I->click('Reply');

        $I->see('Comment added!');
        $I->see('Physics', '.media-body');
        $I->seeInDatabase('comments', array('positive' => 'physics', 'negative' => NULL, 'body' => NULL));
    }

    public function testAddFullOnlyNegative(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=negative]', 'Controls');
        $I->click('Reply');

        $I->see('Comment added!');
        $I->see('Controls', '.media-body');
        $I->seeInDatabase('comments', array('positive' => NULL, 'negative' => 'controls', 'body' => NULL));
    }

    public function testAddFullOnlyText(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->fillField('body', 'This is a another sample comment. This is a sample comment.');
        $I->click('Reply');

        $I->see('Comment added!');
        $I->see('This is a another sample comment. This is a sample comment.');
        $I->seeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'This is a another sample comment. This is a sample comment.'));
    }

    public function testAddNothing(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');
        $I->click('Reply');

        $I->see('Please specify a comment.');
    }

    public function testAddNothingReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //log back in (for some reason this->loginAs doesn't work)
        $I->amOnPage('/auth/login');
        $I->wait(1);
        $I->fillField('email', 'user3@gmail.com');
        $I->fillField('password', 'password3');
        $I->click(['id' => 'login']);

        //Add an empty reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->click('.reply-form button');

        $I->see('Please specify a comment.');
    }

    public function testAddInvalidBody(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->fillField('body', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfds');
        $I->click('Reply');

        $I->see('The body may not be greater than 1000 characters.');
        $I->dontSeeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfds'));
    }

    public function testAddCommentReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //log back in (for some reason this->loginAs doesn't work)
        $I->amOnPage('/auth/login');
        $I->wait(1);
        $I->fillField('email', 'user3@gmail.com');
        $I->fillField('password', 'password3');
        $I->click(['id' => 'login']);

        //Add a reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'This is a sample reply comment. This is a sample reply comment.');
        $I->click('.reply-form button');

        $I->see('Comment reply added!');
        $I->see('This is a sample reply comment. This is a sample reply comment.', '.col-sm-offset-1 .media-body');
        $I->seeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'This is a sample reply comment. This is a sample reply comment.'));
    }

    public function testAddCommentInvalidBodyReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/game/test-game-1');

        $I->selectOption('select[name=positive]', 'Animation');
        $I->selectOption('select[name=negative]', 'Level Design');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click('Reply');

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //log back in (for some reason this->loginAs doesn't work)
        $I->amOnPage('/auth/login');
        $I->wait(1);
        $I->fillField('email', 'user3@gmail.com');
        $I->fillField('password', 'password3');
        $I->click(['id' => 'login']);

        //Add a reply comment
        $I->amOnPage('/game/test-game-1');
        $I->click(['link' => 'Reply']);
        $I->fillField('.reply-form textarea', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfds');
        $I->click('.reply-form button');

        $I->see('The body may not be greater than 1000 characters.');
        $I->dontSeeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfds'));
    }

}