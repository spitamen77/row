<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\validators;

use Uni;
use uni\base\InvalidConfigException;
use uni\web\JsExpression;
use uni\helpers\Json;

/**
 * EmailValidator validates that the attribute value is a valid email address.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
class EmailValidator extends Validator
{
    /**
     * @var string the regular expression used to validate the attribute value.
     * @see http://www.regular-expressions.info/email.html
     */
    public $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
    /**
     * @var string the regular expression used to validate email addresses with the name part.
     * This property is used only when [[allowName]] is true.
     * @see allowName
     */
    public $fullPattern = '/^[^@]*<[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?>$/';
    /**
     * @var boolean whether to allow name in the email address (e.g. "John Smith <john.smith@example.com>"). Defaults to false.
     * @see fullPattern
     */
    public $allowName = false;
    /**
     * @var boolean whether to check whether the email's domain exists and has either an A or MX record.
     * Be aware that this check can fail due to temporary DNS problems even if the email address is
     * valid and an email would be deliverable. Defaults to false.
     */
    public $checkDNS = false;
    /**
     * @var boolean whether validation process should take into account IDN (internationalized domain
     * names). Defaults to false meaning that validation of emails containing IDN will always fail.
     * Note that in order to use IDN validation you have to install and enable `intl` PHP extension,
     * otherwise an exception would be thrown.
     */
    public $enableIDN = false;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->enableIDN && !function_exists('idn_to_ascii')) {
            throw new InvalidConfigException('In order to use IDN validation intl extension must be installed and enabled.');
        }
        if ($this->message === null) {
            $this->message = Uni::t('uni', '{attribute} is not a valid email address.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (!is_string($value)) {
            $valid = false;
        } elseif (!preg_match('/^(?P<name>(?:"?([^"]*)"?\s)?)(?:\s+)?(?:(?P<open><?)((?P<local>.+)@(?P<domain>[^>]+))(?P<close>>?))$/i', $value, $matches)) {
            $valid = false;
        } else {
            if ($this->enableIDN) {
                $matches['local'] = idn_to_ascii($matches['local']);
                $matches['domain'] = idn_to_ascii($matches['domain']);
                $value = $matches['name'] . $matches['open'] . $matches['local'] . '@' . $matches['domain'] . $matches['close'];
            }

            if (strlen($matches['local']) > 64 || mb_strlen($matches['name'], Uni::$app->charset) > 64) {
                // The maximum total length of a user name or other local-part is 64 octets. RFC 5322 section 4.5.3.1.1
                // http://tools.ietf.org/html/rfc5321#section-4.5.3.1.1
                $valid = false;
            } elseif (strlen($matches['local'] . '@' . $matches['domain']) > 254) {
                // There is a restriction in RFC 2821 on the length of an address in MAIL and RCPT commands
                // of 254 characters. Since addresses that do not fit in those fields are not normally useful, the
                // upper limit on address lengths should normally be considered to be 254.
                //
                // Dominic Sayers, RFC 3696 erratum 1690
                // http://www.rfc-editor.org/errata_search.php?eid=1690
                $valid = false;
            } else {
                $valid = preg_match($this->pattern, $value) || $this->allowName && preg_match($this->fullPattern, $value);
                if ($valid && $this->checkDNS) {
                    $valid = checkdnsrr($matches['domain'], 'MX') || checkdnsrr($matches['domain'], 'A');
                }
            }
        }

        return $valid ? null : [$this->message, []];
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $options = [
            'pattern' => new JsExpression($this->pattern),
            'fullPattern' => new JsExpression($this->fullPattern),
            'allowName' => $this->allowName,
            'message' => Uni::$app->getI18n()->format($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ], Uni::$app->language),
            'enableIDN' => (bool)$this->enableIDN,
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);
        if ($this->enableIDN) {
            PunycodeAsset::register($view);
        }

        return 'uni.validation.email(value, messages, ' . Json::htmlEncode($options) . ');';
    }
}
