<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\swiftmailer;

use Uni;
use uni\base\InvalidConfigException;
use uni\mail\BaseMailer;

/**
 * Mailer implements a mailer based on SwiftMailer.
 *
 * To use Mailer, you should configure it in the application configuration like the following,
 *
 * ~~~
 * 'components' => [
 *     ...
 *     'mailer' => [
 *         'class' => 'uni\swiftmailer\Mailer',
 *         'transport' => [
 *             'class' => 'Swift_SmtpTransport',
 *             'host' => 'localhost',
 *             'username' => 'username',
 *             'password' => 'password',
 *             'port' => '587',
 *             'encryption' => 'tls',
 *         ],
 *     ],
 *     ...
 * ],
 * ~~~
 *
 * You may also skip the configuration of the [[transport]] property. In that case, the default
 * PHP `mail()` function will be used to send emails.
 *
 * You specify the transport constructor arguments using 'constructArgs' key in the config.
 * You can also specify the list of plugins, which should be registered to the transport using
 * 'plugins' key. For example:
 *
 * ~~~
 * 'transport' => [
 *     'class' => 'Swift_SmtpTransport',
 *     'constructArgs' => ['localhost', 25]
 *     'plugins' => [
 *         [
 *             'class' => 'Swift_Plugins_ThrottlerPlugin',
 *             'constructArgs' => [20],
 *         ],
 *     ],
 * ],
 * ~~~
 *
 * To send an email, you may use the following code:
 *
 * ~~~
 * Uni::$app->mailer->compose('contact/html', ['contactForm' => $form])
 *     ->setFrom('from@domain.com')
 *     ->setTo($form->email)
 *     ->setSubject($form->subject)
 *     ->send();
 * ~~~
 *
 * @see http://swiftmailer.org
 *
 * @property array|\Swift_Mailer $swiftMailer Swift mailer instance or array configuration. This property is
 * read-only.
 * @property array|\Swift_Transport $transport This property is read-only.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since alfa version
 */
class Mailer extends BaseMailer
{
    /**
     * @var string message default class name.
     */
    public $messageClass = 'uni\swiftmailer\Message';
    /**
     * @var boolean whether to enable writing of the SwiftMailer internal logs using Uni log mechanism.
     * If enabled [[Logger]] plugin will be attached to the [[transport]] for this purpose.
     * @see Logger
     */
    public $enableSwiftMailerLogging = false;

    /**
     * @var \Swift_Mailer Swift mailer instance.
     */
    private $_swiftMailer;
    /**
     * @var \Swift_Transport|array Swift transport instance or its array configuration.
     */
    private $_transport = [];


    /**
     * @return array|\Swift_Mailer Swift mailer instance or array configuration.
     */
    public function getSwiftMailer()
    {
        if (!is_object($this->_swiftMailer)) {
            $this->_swiftMailer = $this->createSwiftMailer();
        }

        return $this->_swiftMailer;
    }

    /**
     * @param array|\Swift_Transport $transport
     * @throws InvalidConfigException on invalid argument.
     */
    public function setTransport($transport)
    {
        if (!is_array($transport) && !is_object($transport)) {
            throw new InvalidConfigException('"' . get_class($this) . '::transport" should be either object or array, "' . gettype($transport) . '" given.');
        }
        $this->_transport = $transport;
    }

    /**
     * @return array|\Swift_Transport
     */
    public function getTransport()
    {
        if (!is_object($this->_transport)) {
            $this->_transport = $this->createTransport($this->_transport);
        }

        return $this->_transport;
    }

    /**
     * @inheritdoc
     */
    protected function sendMessage($message)
    {
        $address = $message->getTo();
        if (is_array($address)) {
            $address = implode(', ', array_keys($address));
        }
        Uni::info('Sending email "' . $message->getSubject() . '" to "' . $address . '"', __METHOD__);

        return $this->getSwiftMailer()->send($message->getSwiftMessage()) > 0;
    }

    /**
     * Creates Swift mailer instance.
     * @return \Swift_Mailer mailer instance.
     */
    protected function createSwiftMailer()
    {
        return \Swift_Mailer::newInstance($this->getTransport());
    }

    /**
     * Creates email transport instance by its array configuration.
     * @param array $config transport configuration.
     * @throws \uni\base\InvalidConfigException on invalid transport configuration.
     * @return \Swift_Transport transport instance.
     */
    protected function createTransport(array $config)
    {
        if (!isset($config['class'])) {
            $config['class'] = 'Swift_MailTransport';
        }
        if (isset($config['plugins'])) {
            $plugins = $config['plugins'];
            unset($config['plugins']);
        } else {
            $plugins = [];
        }

        if ($this->enableSwiftMailerLogging) {
            $plugins[] = [
                'class' => 'Swift_Plugins_LoggerPlugin',
                'constructArgs' => [
                    [
                        'class' => 'uni\swiftmailer\Logger'
                    ]
                ],
            ];
        }

        /* @var $transport \Swift_MailTransport */
        $transport = $this->createSwiftObject($config);
        if (!empty($plugins)) {
            foreach ($plugins as $plugin) {
                if (is_array($plugin) && isset($plugin['class'])) {
                    $plugin = $this->createSwiftObject($plugin);
                }
                $transport->registerPlugin($plugin);
            }
        }

        return $transport;
    }

    /**
     * Creates Swift library object, from given array configuration.
     * @param array $config object configuration
     * @return Object created object
     * @throws \uni\base\InvalidConfigException on invalid configuration.
     */
    protected function createSwiftObject(array $config)
    {
        if (isset($config['class'])) {
            $className = $config['class'];
            unset($config['class']);
        } else {
            throw new InvalidConfigException('Object configuration must be an array containing a "class" element.');
        }

        if (isset($config['constructArgs'])) {
            $args = [];
            foreach ($config['constructArgs'] as $arg) {
                if (is_array($arg) && isset($arg['class'])) {
                    $args[] = $this->createSwiftObject($arg);
                } else {
                    $args[] = $arg;
                }
            }
            unset($config['constructArgs']);
            $object = Uni::createObject($className, $args);
        } else {
            $object = Uni::createObject($className);
        }

        if (!empty($config)) {
            $reflection = new \ReflectionObject($object);
            foreach ($config as $name => $value) {
                if ($reflection->hasProperty($name) && $reflection->getProperty($name)->isPublic()) {
                    $object->$name = $value;
                } else {
                    $setter = 'set' . $name;
                    if ($reflection->hasMethod($setter) || $reflection->hasMethod('__call')) {
                        $object->$setter($value);
                    } else {
                        throw new InvalidConfigException('Setting unknown property: ' . $className . '::' . $name);
                    }
                }
            }
        }

        return $object;
    }
}
