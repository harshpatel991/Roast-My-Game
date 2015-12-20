<?php
namespace Page;

class Game
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

    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    //Fills in the top part of the form with valid values
    public function fillValidGameTop() {
        $I = $this->tester;
        $I->fillField('title', 'Test Minimal Title');
        $I->selectOption('select[name=genre]', 'Idle');
    }

}
