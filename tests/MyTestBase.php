<?php


use WebDriver\WebDriver;

class MyTestBase extends \Laracasts\Integrated\Extensions\Selenium
{

    protected $baseUrl = 'http://example.dev';

    /**
     * Create a new WebDriver session.
     * @return Session
     * @internal param string $browser
     */
    protected function newSession()
    {
        $host = 'http://10.0.2.2:4444/wd/hub'; #find this value by running on vagrant box: netstat -rn | grep "^0.0.0.0 " | cut -d " " -f10

        $this->webDriver = new WebDriver($host);
        $capabilities = [];

        return $this->session = $this->webDriver->session($this->getBrowserName(), $capabilities);
    }

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        if ( ! $this->app )
        {
            $this->app = $this->createApplication();
        }
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

}