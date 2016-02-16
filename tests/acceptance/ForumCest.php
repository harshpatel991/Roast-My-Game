<?php

class ForumCest
{
    private function loginAs(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/auth/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    private function fillInLogin(AcceptanceTester $I, $email, $password)
    {
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click(['id' => 'login']);
    }

    public function testAddWithoutPermissions(\AcceptanceTester $I)
    {
        $I->amOnPage('/forum/general-discussion');

        $I->fillField('body', 'This is a sample forum comment. This is a sample forum comment.');
        $I->click(['id' => 'main-reply-button']);

        $I->see('Login'); //verify the user was directed to the login page
        $this->fillInLogin($I, 'user2@gmail.com', 'password2');
        $I->see('General Discussion'); //verify the user was redirected back
        $I->dontSee('This is a sample forum comment. This is a sample forum comment.');
        $I->dontSeeInDatabase('comments', array('body' => 'This is a sample forum comment. This is a sample forum comment.'));
    }

    public function testAddReplyWithoutPermissions(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');
        $I->fillField('body', 'This is a sample forum comment. This is a sample forum comment.');
        $I->click(['id' => 'main-reply-button']);

        //Logout
        $I->click('#profile-dropdown');
        $I->wait(1);
        $I->click('#logout-button');
        $I->wait(1);

        //Attempt to add a reply comment
        $I->amOnPage('/forum/general-discussion');
        $I->click(['id' => 'comment-reply-link-6']);
        $I->fillField('.reply-form textarea', 'This is a sample forum reply comment. This is a sample forum reply comment.');
        $I->click('.reply-form button');

        $I->see('Login'); //verify the user was directed to the login page
        $this->fillInLogin($I, 'user2@gmail.com', 'password2');
        $I->see('General Discussion'); //verify the user was redirected back
        $I->dontSee('This is a sample forum reply comment. This is a sample forum reply comment.');
        $I->dontSeeInDatabase('comments', array('body' => 'This is a sample forum reply comment. This is a sample forum reply comment.'));
    }

    public function testAddFullComment(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');

        //5000 characters
        $I->fillField('body', 'This is a sample forum comment. This is a comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample');
        $I->click(['id' => 'main-reply-button']);

        $I->see('Forum comment added!');
        $I->see('This is a sample forum comment. This is a comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample');
        $I->seeInDatabase('comments', array('parent_id' => NULL, 'body' => 'This is a sample forum comment. This is a comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment.This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample comment. This is a sample', 'my_commentable_type' => 'Discussion'));
    }

    public function testAddShortBody(\AcceptanceTester $I)
    {
        $I->resetEmails();

        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');

        $I->fillField('body', 'Shor');
        $I->click(['id' => 'main-reply-button']);

        $I->see('The body must be at least 5 characters.');
        $I->seeEmailCount(0);
    }

    public function testAddNothing(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');
        $I->click(['id' => 'main-reply-button']);

        $I->see('The body field is required.');
    }

    public function testAddNothingReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');

        $I->fillField('body', 'This is a top level forum comment. This is a top level forum comment.');
        $I->click(['id' => 'main-reply-button']);

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
        $I->amOnPage('/forum/general-discussion');
        $I->click(['id' => 'comment-reply-link-6']);
        $I->click('.reply-form button');

        $I->see('The body field is required.');
    }

    public function testAddInvalidBody(\AcceptanceTester $I)
    {
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');

        $I->fillField('body', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasda');
        $I->click(['id' => 'main-reply-button']);

        $I->see('The body may not be greater than 5000 characters.');
        $I->dontSeeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasda', 'my_commentable_type' => 'Discussion'));
    }

    public function testAddCommentReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');

        $I->fillField('body', 'This is a top level forum comment. This is a top level forum comment.');
        $I->click(['id' => 'main-reply-button']);

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
        $I->amOnPage('/forum/general-discussion');
        $I->click(['id' => 'comment-reply-link-6']);
        $I->fillField('.reply-form textarea', 'This is a sample forum reply comment. This is a sample forum reply comment.');
        $I->click('.reply-form button');

        $I->see('Forum reply added!');
        $I->see('This is a sample forum reply comment. This is a sample forum reply comment.', '.col-sm-offset-1 .media-body');
        $I->seeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'parent_id' => 6, 'body' => 'This is a sample forum reply comment. This is a sample forum reply comment.', 'my_commentable_type' => 'Discussion'));
    }

    public function testAddCommentInvalidBodyReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');

        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click(['id' => 'main-reply-button']);

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
        $I->amOnPage('/forum/general-discussion');
        $I->click(['id' => 'comment-reply-link-6']);
        $I->fillField('.reply-form textarea', 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasda');
        $I->click('.reply-form button');

        $I->see('The body may not be greater than 5000 characters.');
        $I->dontSeeInDatabase('comments', array('positive' => NULL, 'negative' => NULL, 'body' => 'fasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasfdsfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdassdasdffasdasdfsdfsadfasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasdasdasdffasda'));
    }

    public function testAddCommentShortReply(\AcceptanceTester $I)
    {
        //Add a regular comment
        $this->loginAs($I, 'user2@gmail.com', 'password2');
        $I->amOnPage('/forum/general-discussion');
        $I->fillField('body', 'This is a top level comment. This is a top level comment.');
        $I->click(['id' => 'main-reply-button']);

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
        $I->amOnPage('/forum/general-discussion');
        $I->click(['id' => 'comment-reply-link-6']);
        $I->fillField('.reply-form textarea', 'tiny');
        $I->click('.reply-form button');

        $I->see('The body must be at least 5 characters.');
    }
}