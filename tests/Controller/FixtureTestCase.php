<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Class FixtureTestCase
 */
abstract class FixtureTestCase extends WebTestCase
{
    private static $isMigrationsExecuted = false;

    private const NO_INTERACTION_OPTION = ['--no-interaction' => true];

    /**
     * @var AbstractBrowser
     */
    private $client;

    /** @var  Application $application */
    private $application;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->application = new Application($this->client->getKernel());
        $this->application->setAutoExit(false);

        if (!self::$isMigrationsExecuted) {
            $this->runMigrations();
            self::$isMigrationsExecuted = true;
        }
        $this->runFixtures();

    }

    /**
     * @return AbstractBrowser
     */
    protected function getClientInstance(): AbstractBrowser
    {
        return $this->client;
    }

    /**
     * @throws \Exception
     */
    protected function runMigrations(): void
    {
        $this->runAppConsoleCommand("doctrine:migrations:migrate", self::NO_INTERACTION_OPTION);
    }

    /**
     * @throws \Exception
     */
    protected function runFixtures(): void
    {
        $this->runAppConsoleCommand("doctrine:fixtures:load", self::NO_INTERACTION_OPTION);
    }

    /**
     * @param string $command
     * @param array  $options
     *
     * @return int
     * @throws \Exception
     */
    private function runAppConsoleCommand(string $command, array $options = []): int
    {
        $command = new ArrayInput(array_merge(['command' => $command, '--env' => 'test'], $options));

        return $this->application->run($command);
    }
}
