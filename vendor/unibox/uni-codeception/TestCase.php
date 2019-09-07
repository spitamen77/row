<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\codeception;

use Uni;
use uni\base\InvalidConfigException;
use Codeception\TestCase\Test;
use uni\base\UnknownMethodException;
use uni\base\UnknownPropertyException;
use uni\di\Container;
use uni\test\ActiveFixture;
use uni\test\BaseActiveFixture;
use uni\test\FixtureTrait;

/**
 * TestCase is the base class for all codeception unit tests
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
class TestCase extends Test
{
    use FixtureTrait;

    /**
     * @var array|string the application configuration that will be used for creating an application instance for each test.
     * You can use a string to represent the file path or path alias of a configuration file.
     * The application configuration array may contain an optional `class` element which specifies the class
     * name of the application instance to be created. By default, a [[\uni\web\Application]] instance will be created.
     */
    public $appConfig = '@tests/codeception/config/unit.php';


    /**
     * Returns the value of an object property.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when executing `$value = $object->property;`.
     * @param string $name the property name
     * @return mixed the property value
     * @throws UnknownPropertyException if the property is not defined
     */
    public function __get($name)
    {
        $fixture = $this->getFixture($name);
        if ($fixture !== null) {
            return $fixture;
        } else {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * Calls the named method which is not a class method.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when an unknown method is being invoked.
     * @param string $name the method name
     * @param array $params method parameters
     * @throws UnknownMethodException when calling unknown method
     * @return mixed the method return value
     */
    public function __call($name, $params)
    {
        $fixture = $this->getFixture($name);
        if ($fixture instanceof BaseActiveFixture) {
            return $fixture->getModel(reset($params));
        } else {
            throw new UnknownMethodException('Unknown method: ' . get_class($this) . "::$name()");
        }
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
        $this->unloadFixtures();
        $this->loadFixtures();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        $this->destroyApplication();
        parent::tearDown();
    }

    /**
     * Mocks up the application instance.
     * @param array $config the configuration that should be used to generate the application instance.
     * If null, [[appConfig]] will be used.
     * @return \uni\web\Application|\uni\console\Application the application instance
     * @throws InvalidConfigException if the application configuration is invalid
     */
    protected function mockApplication($config = null)
    {
        if (isset(Uni::$app)) {
            return;
        }
        Uni::$container = new Container();
        $config = $config === null ? $this->appConfig : $config;
        if (is_string($config)) {
            $configFile = Uni::getAlias($config);
            if (!is_file($configFile)) {
                throw new InvalidConfigException("The application configuration file does not exist: $config");
            }
            $config = require($configFile);
        }
        if (is_array($config)) {
            if (!isset($config['class'])) {
                $config['class'] = 'uni\web\Application';
            }
            return Uni::createObject($config);
        } else {
            throw new InvalidConfigException('Please provide a configuration array to mock up an application.');
        }
    }

    /**
     * Destroys the application instance created by [[mockApplication]].
     */
    protected function destroyApplication()
    {
        if (\Uni::$app) {
            if (\Uni::$app->has('session', true)) {
                \Uni::$app->session->close();
            }
            if (\Uni::$app->has('db', true)) {
                Uni::$app->db->close();
            }
        }
        Uni::$app = null;
        Uni::$container = new Container();
    }
}
