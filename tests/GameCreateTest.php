<?php

require ('MyTestBase.php');
use Laracasts\Integrated\Services\Laravel\DatabaseTransactions;

class GameCreateTest extends MyTestBase {

    use DatabaseTransactions;

    /** @test */
    public function create_minimal_game()
    {

        $imagesDir = '~/Development/Code/clickr/tests/test-images/';
        $this->visit('/auth/login')
            ->type('user1@gmail.com', '#email')
            ->type('password1', '#password')
            ->press('Login')
            ->click('Add Game')
            ->type('Test Minimal Title', '#title')
            ->select('genre', 'action-adventure')
            ->type('1.5.6', '#version')
            ->attachFile('image1', $imagesDir.'image1.jpg')
            ->press('Add Game!')
            ->see('Test Minimal Title')
            ->see('Action-Adventure')
            ->see('1.5.6')
            ->see('test-minimal-title-156');
    }

    /** @test */
    public function create_full_game() {
        $imagesDir = '~/Development/Code/clickr/tests/test-images/';

        $description = 'Here is a full featured description for this page. I hope to make it quite long as it is necessary to test long values.';
        $changes = 'Here is a set of changes';
        $upcoming_features = 'Here is a a set of upcomming features';
        $this->visit('/auth/login')
            ->type('user1@gmail.com', '#email')
            ->type('password1', '#password')
            ->press('Login')
            ->click('Add Game')
            ->type('Test Full Title', '#title')
            ->select('genre', 'shooter')
            ->switchFrame()
            ->type($description, '#tinymce')
            ->tick('platforms[0]')
            ->tick('platforms[1]')
            ->tick('platforms[2]')
            ->tick('platforms[3]')
            ->tick('platforms[4]')
            ->tick('platforms[5]')
            ->click('Add Platform Links')
            ->type('http://pc.com', 'link_platform_pc')
            ->type('http://mac.com', 'link_platform_mac')
            ->type('http://ios.com', 'link_platform_ios')
            ->type('http://android.com', 'link_platform_android')
            ->type('http://unity-web.com', 'link_platform_unity_web')
            ->type('http://other-web.com', 'link_platform_other')
            ->click('Add Social Links')
            ->type('http://greenlight.com', 'link_social_greenlight')
            ->type('http://website.com', 'link_social_website')
            ->type('http://link-twitter.com', 'link_social_twitter')
            ->type('http://link-youtube.com', 'link_social_youtube')
            ->type('http://link-gplus.com', 'link_social_google_plus')
            ->type('http://link-facebook.com', 'link_social_facebook')
            ->type('1', '#version')
            ->tick('beta')
            ->type('http://link-youtube.com', 'video_link')
            ->attachFile('image1', $imagesDir.'image1.jpg')
            ->attachFile('image2', $imagesDir.'image2.jpg')
            ->attachFile('image3', $imagesDir.'image3.jpg')
            ->attachFile('image4', $imagesDir.'image4.jpg')
            ->type($changes, '#changes')
            ->type($upcoming_features, '#upcoming_features')
            ->press('Add Game!')
            ->see('Test Full Title')
            ->see('Shooter')
            ->see('1')
            ->see('test-full-title-1-1.png')
            ->seeInAlert("hi");

    }

    public function create_game_without_permission() {

    }




}