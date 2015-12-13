<?php

require ('MyTestBase.php');

class GameCreateTest extends MyTestBase{

    /** @test */
    public function create_minimal_game()
    {
        $this->visit('/auth/login')
            ->type('user1@gmail.com', '#email')
            ->type('password1', '#password')
            ->press('Login')
            ->visit('add-game') //TODO: finish from here
            ->type('Test Title', '#title')
            ->select('genre', 'action-adventure')
            ->type('1.5.6', '#version')
            ->attachFile('image1', __DIR__.'/test-images/image1.png')
            ->press('Submit');
    }

    public function create_full_game() {

    }

    public function create_game_without_permission() {

    }




}