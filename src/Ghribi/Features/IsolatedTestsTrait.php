<?php

namespace Ghribi\Features;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Doctrine\DBAL\Driver\PDOSqlite\Driver as PDOSqliteDriver;

require_once(__DIR__ . IsolatedTestsTrait::$kernelRootDir . '/AppKernel.php');

/**
 * This trait allows you to operate on clean version (with fixtures) of database
 * It will use sqlite database
 *
 * You can use it to provide isolation in tests for functional tests or tests
 * where you'd like to use database (some integration tests against fixtures)
 */
trait IsolatedTestsTrait
{
    protected static $application;
    protected static $environment = 'test';
    protected static $debug = false;
    protected static $fixturesSuffix = '.fixtures';
    protected static $fixturesPath = '';
    protected static $defaultEntityManager = 'default';
    public static $kernelRootDir = '/../../../app';

    /**
     * Rebuilds (provides clean instance of database) for each test
     */
    public function setUp()
    {
        parent::setup();
        static::rebuildDatabase();
    }

    /**
     * It will run before any setUps and tests in given test suite
     * This hook will drop current schema, creat schema and load fixtures
     * then it will create a copy of the databse, so it will be used in the future tests in this suite
     */
    public static function setUpBeforeClass()
    {
        static::bootstrapApplication();
    }

    /**
     * After all tests in given test suite it will remove database copy
     * Because of this next test suite needs to create its own
     */
    public static function tearDownAfterClass()
    {
        unlink(static::$fixturesPath);
    }

    /**
     * Runs 3 console commands: (all with -q and -e=test)
     * doctrine:schema:drop --force
     * doctrine:schema:create
     * doctrine:fixtures:load --no-interaction
     *
     * After successful database rebuild, it will copy it for further reuse
     */
    protected function rebuildDatabase()
    {
        $conn = static::$application->getKernel()->getContainer()->get('doctrine.dbal.default_connection');
        if (!$conn->getDriver() instanceof PDOSqliteDriver) {
            throw new \RuntimeException('It would not work nicely with driver other than PDOSqlite');
        }

        $dbPath = $conn->getDatabase();
        static::$fixturesPath = $dbPath . static::$fixturesSuffix;

        if (!file_exists(static::$fixturesPath)) {
            // create fresh database (schema and fixtures)
            static::runConsole('doctrine:database:create', array('-n' => true, '--connection' => self::$defaultEntityManager));
            static::runConsole('doctrine:schema:drop', array('--force' => true, '--em' => self::$defaultEntityManager));
            static::runConsole('doctrine:schema:create', array('--em' => self::$defaultEntityManager));
            static::runConsole('doctrine:fixtures:load', array('-n' => true, '--em' => self::$defaultEntityManager));
            // copy fresh database to be reused in the future
            copy($dbPath, static::$fixturesPath);
        } else {
            // copy fixtures database to doctrine location
            copy(static::$fixturesPath, $dbPath);
        }
    }

    /**
     * Bootstraps console application. It's needed to run commands from the code
     */
    protected function bootstrapApplication()
    {
        $kernel = new \AppKernel(static::$environment, static::$debug);
        $kernel->boot();
        static::$application = new Application($kernel);
        static::$application->setAutoExit(false);
    }

    /**
     * It always run with given environment and in quiet mode (no output on the console)
     */
    protected function runConsole($command, array $options = array())
    {
        $options['-e'] = self::$environment;
        $options['-q'] = null;

        $input = new ArrayInput(array_merge($options, array('command' => $command)));
        $result = self::$application->run($input);

        if (0 != $result) {
            throw new \RuntimeException(sprintf('Something has gone wrong, got return code %d for command %s', $result, $command));
        }

        return $result;
    }
}
