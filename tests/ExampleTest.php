<?php

require ('MyTestBase.php');

class ExampleTest extends MyTestBase{

    /** @test */
    public function it_verifies_that_pages_load_properly()
    {
        $this->visit('/');
    }




}