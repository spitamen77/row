<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\validators;

use Uni;
use uni\base\InvalidConfigException;
use uni\helpers\Html;
use uni\helpers\Json;
use uni\helpers\StringHelper;
use uni\web\JsExpression;

/**
 * The validator checks if the attribute value is a valid IPv4/IPv6 address or subnet.
 * It also may change attribute's value if normalization or IPv6 expansion is enabled.
 *
 * @property array $ranges IPv4 or IPv6 ranges that are allowed or forbidden.
 *
 * When the array is empty, or the option not set, all IP addresses are allowed.
 * Otherwise, the rules are checked sequentially until the first match is found.
 * IP address is forbidden, when it has not matched any of the rules.
 *
 * Example:
 * ```php
 * [
 *      'ranges' => [
 *          '192.168.10.128'
 *          '!192.168.10.0/24',
 *          'any' // allows any other IP addresses
 *      ]
 * ]
 * ```
 *
 * In this example, access is allowed for all the IPv4 and IPv6 addresses excluding `192.168.10.0/24` subnet.
 * IPv4 address `192.168.10.128` is also allowed, because it is listed before the restriction.
 *
 * @author Dmitry Naumenko <d.naumenko.a@gmail.com>
 * @since alfa version.7
 */
class IpValidator extends Validator
{
    /**
     * The length of IPv6 address in bits
     */
    const IPV6_ADDRESS_LENGTH = 128;

    /**
     * The length of IPv4 address in bits
     */
    const IPV4_ADDRESS_LENGTH = 32;

    /**
     * Negation char. Used to negate [[ranges]] or [[networks]]
     * or to negate validating value when [[negation]] is set to `true`
     * @see negation
     * @see networks
     * @see ranges
     */
    const NEGATION_CHAR = '!';

    /**
     * @var array The network aliases, that can be used in [[ranges]].
     *  - key - alias name
     *  - value - array of strings. String can be an IP range, IP address or another alias. String can be
     * negated with [[NEGATION_CHAR]] (independent of `negation` option).
     *
     * The following aliases are defined by default:
     *  - `*`: `any`
     *  - `any`: `0.0.0.0/0, ::/0`
     *  - `private`: `10.0.0.0/8, 172.16.0.0/12, 192.168.0.0/16, fd00::/8`
     *  - `multicast`: `224.0.0.0/4, ff00::/8`
     *  - `linklocal`: `169.254.0.0/16, fe80::/10`
     *  - `localhost`: `127.0.0.0/8', ::1`
     *  - `documentation`: `192.0.2.0/24, 198.51.100.0/24, 203.0.113.0/24, 2001:db8::/32`
     *  - `system`: `multicast, linklocal, localhost, documentation`
     *
     */
    public $networks = [
        '*' => ['any'],
        'any' => ['0.0.0.0/0', '::/0'],
        'private' => ['10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16', 'fd00::/8'],
        'multicast' => ['224.0.0.0/4', 'ff00::/8'],
        'linklocal' => ['169.254.0.0/16', 'fe80::/10'],
        'localhost' => ['127.0.0.0/8', '::1'],
        'documentation' => ['192.0.2.0/24', '198.51.100.0/24', '203.0.113.0/24', '2001:db8::/32'],
        'system' => ['multicast', 'linklocal', 'localhost', 'documentation'],
    ];

    /**
     * @var boolean whether the validating value can be an IPv6 address. Defaults to true.
     */
    public $ipv6 = true;

    /**
     * @var boolean whether the validating value can be an IPv4 address. Defaults to true.
     */
    public $ipv4 = true;

    /**
     * @var boolean whether the address can be an IP with CIDR subnet, like `192.168.10.0/24`
     *    true - the subnet is required
     *   false - the address can not have the subnet
     *    null - ths subnet is optional
     */
    public $subnet = false;

    /**
     * @var boolean whether to add the CIDR prefix with the smallest length (32 for IPv4 and 128 for IPv6) to an
     * address without it. Works only when `subnet` is not `false`. For example:
     *  - `10.0.1.5` will normalized to `10.0.1.5/32`
     *  - `2008:db0::1` will be normalized to `2008:db0::1/128`
     * Defaults to false.
     * @see subnet
     */
    public $normalize = false;

    /**
     * @var boolean whether address may have a [[NEGATION_CHAR]] character at the beginning
     */
    public $negation = false;

    /**
     * @var boolean whether to expand an IPv6 address to the full notation format
     */
    public $expandIPv6 = false;

    /**
     * See [[ranges]]
     *
     * @var array
     * @see ranges
     */
    public $_ranges = [];

    /**
     * @var string Regexp-pattern to validate IPv4 address
     */
    public $ipv4Pattern = '/^(?:(?:2(?:[0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9])\.){3}(?:(?:2([0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9]))$/';

    /**
     * @var string Regexp-pattern to validate IPv6 address
     */
    public $ipv6Pattern = '/^(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))$/';

    /**
     * @var string user-defined error message is used when validation fails due to the disabled IPv6 validation
     * You may use the following placeholders in the message:
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     */
    public $ipv6NotAllowed;

    /**
     * @var string user-defined error message is used when validation fails due to the disabled IPv4 validation
     * You may use the following placeholders in the message:
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     */
    public $ipv4NotAllowed;

    /**
     * @var string user-defined error message is used when validation fails due to the wrong CIDR
     * You may use the following placeholders in the message:
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     */
    public $wrongCidr;

    /**
     * @var string user-defined error message is used when validation fails due to the wrong IP address format
     * You may use the following placeholders in the message:
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     */
    public $wrongIp;

    /**
     * @var string user-defined error message is used when validation fails due to subnet [[subnet]] set to 'only',
     * but the CIDR prefix is not set
     * You may use the following placeholders in the message:
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     * @see subnet
     */
    public $noSubnet;

    /**
     * @var string user-defined error message is used when validation fails
     * due to [[subnet]] is false, but CIDR prefix is present
     * You may use the following placeholders in the message:
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     * @see subnet
     */
    public $hasSubnet;

    /**
     * @var string user-defined error message is used when validation fails due to IP address
     * is not not allowed by [[ranges]] check.
     * You may use the following placeholders in the message:
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     * @see ranges
     */
    public $notInRange;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!$this->ipv4 && !$this->ipv6) {
            throw new InvalidConfigException('Both IPv4 and IPv6 checks can not be disabled at the same time');
        }

        if (!defined('AF_INET6') && $this->ipv6) {
            throw new InvalidConfigException('IPv6 validation can not be used. PHP is compiled without IPv6');
        }

        if ($this->ipv6NotAllowed === null) {
            $this->ipv6NotAllowed = Uni::t('uni', '{attribute} must not be an IPv6 address.');
        }
        if ($this->ipv4NotAllowed === null) {
            $this->ipv4NotAllowed = Uni::t('uni', '{attribute} must not be an IPv4 address.');
        }
        if ($this->wrongCidr === null) {
            $this->wrongCidr = Uni::t('uni', '{attribute} contains wrong subnet mask.');
        }
        if ($this->wrongIp === null) {
            $this->wrongIp = Uni::t('uni', '{attribute} must be a valid IP address.');
        }
        if ($this->noSubnet === null) {
            $this->noSubnet = Uni::t('uni', '{attribute} must be an IP address with specified subnet.');
        }
        if ($this->hasSubnet === null) {
            $this->hasSubnet = Uni::t('uni', '{attribute} must not be a subnet.');
        }
        if ($this->notInRange === null) {
            $this->notInRange = Uni::t('uni', '{attribute} is not in the allowed range.');
        }
    }

    /**
     * @return array
     */
    public function getRanges()
    {
        return $this->_ranges;
    }

    /**
     * Prepares $ranges to fill in [[ranges]]:
     *  - Recursively substitutes aliases, described in [[networks]] with their values
     *  - Removes duplicates
     * @param array $ranges
     */
    public function setRanges($ranges)
    {
        $this->_ranges = $this->prepareRanges((array) $ranges);
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $result = $this->validateSubnet($value);
        if (is_array($result)) {
            $result[1] = array_merge(['ip' => is_array($value) ? 'array()' : $value], $result[1]);
            return $result;
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;

        $result = $this->validateSubnet($value);
        if (is_array($result)) {
            $result[1] = array_merge(['ip' => is_array($value) ? 'array()' : $value], $result[1]);
            $this->addError($model, $attribute, $result[0], $result[1]);
        } else {
            $model->$attribute = $result;
        }
    }

    /**
     * Validates an IPv4/IPv6 address or subnet
     *
     * @param $ip string
     * @return string|array
     *  string - the validation was successful;
     *  array  - an error occurred during the validation.
     * Array[0] contains the text of an error, array[1] contains values for the placeholders in the error message
     */
    private function validateSubnet($ip)
    {
        if (!is_string($ip)) {
            return [$this->wrongIp, []];
        }

        $negation = null;
        $cidr = null;
        $isCidrDefault = false;

        if (preg_match($this->getIpParsePattern(), $ip, $matches)) {
            $negation = ($matches[1] !== '') ? $matches[1] : null;
            $ip = $matches[2];
            $cidr = isset($matches[4]) ? $matches[4] : null;
        }

        if ($this->subnet === true && $cidr === null) {
            return [$this->noSubnet, []];
        }
        if ($this->subnet === false && $cidr !== null) {
            return [$this->hasSubnet, []];
        }
        if ($this->negation === false && $negation !== null) {
            return [$this->wrongIp, []];
        }

        if ($this->getIpVersion($ip) == 6) {
            if ($cidr !== null) {
                if ($cidr > static::IPV6_ADDRESS_LENGTH || $cidr < 0) {
                    return [$this->wrongCidr, []];
                }
            } else {
                $isCidrDefault = true;
                $cidr = static::IPV6_ADDRESS_LENGTH;
            }

            if (!$this->ipv6) {
                return [$this->ipv6NotAllowed, []];
            }
            if (!$this->validateIPv6($ip)) {
                return [$this->wrongIp, []];
            }

            if ($this->expandIPv6) {
                $ip = $this->expandIPv6($ip);
            }
        } else {
            if ($cidr !== null) {
                if ($cidr > static::IPV4_ADDRESS_LENGTH || $cidr < 0) {
                    return [$this->wrongCidr, []];
                }
            } else {
                $isCidrDefault = true;
                $cidr = static::IPV4_ADDRESS_LENGTH;
            }

            if (!$this->ipv4) {
                return [$this->ipv4NotAllowed, []];
            }
            if (!$this->validateIPv4($ip)) {
                return [$this->wrongIp, []];
            }
        }

        if (!$this->isAllowed($ip, $cidr)) {
            return [$this->notInRange, []];
        }

        $result = $negation . $ip;

        if ($this->subnet !== false && (!$isCidrDefault || $isCidrDefault && $this->normalize)) {
            $result .= "/$cidr";
        }

        return $result;
    }

    /**
     * Expands an IPv6 address to it's full notation. For example `2001:db8::1` will be
     * expanded to `2001:0db8:0000:0000:0000:0000:0000:0001`
     *
     * @param string $ip the original IPv6
     * @return string the expanded IPv6
     */
    private function expandIPv6($ip)
    {
        $hex = unpack('H*hex', inet_pton($ip));
        return substr(preg_replace('/([a-f0-9]{4})/i', '$1:', $hex['hex']), 0, -1);
    }

    /**
     * The method checks whether the IP address with specified CIDR is allowed according to the [[ranges]] list.
     *
     * @param string $ip
     * @param integer $cidr
     * @return boolean
     * @see ranges
     */
    private function isAllowed($ip, $cidr)
    {
        if (empty($this->ranges)) {
            return true;
        }

        foreach ($this->ranges as $string) {
            list($isNegated, $range) = $this->parseNegatedRange($string);
            if ($this->inRange($ip, $cidr, $range)) {
                return !$isNegated;
            }
        }

        return false;
    }

    /**
     * Parses IP address/range for the negation with [[NEGATION_CHAR]].
     *
     * @param $string
     * @return array `[0 => boolean, 1 => string]`
     *  - boolean: whether the string is negated
     *  - string: the string without negation (when the negation were present)
     */
    private function parseNegatedRange ($string) {
        $isNegated = strpos($string, static::NEGATION_CHAR) === 0;
        return [$isNegated, ($isNegated ? substr($string, strlen(static::NEGATION_CHAR)) : $string)];
    }

    /**
     * Prepares array to fill in [[ranges]]:
     *  - Recursively substitutes aliases, described in [[networks]] with their values
     *  - Removes duplicates
     *
     *
     * @param $ranges
     * @return array
     * @see networks
     */
    private function prepareRanges($ranges) {
        $result = [];
        foreach ($ranges as $string) {
            list($isRangeNegated, $range) = $this->parseNegatedRange($string);
            if (isset($this->networks[$range])) {
                $replacements = $this->prepareRanges($this->networks[$range]);
                foreach ($replacements as &$replacement) {
                    list($isReplacementNegated, $replacement) = $this->parseNegatedRange($replacement);
                    $result[] = ($isRangeNegated && !$isReplacementNegated ? static::NEGATION_CHAR : '') . $replacement;
                }
            } else {
                $result[] = $string;
            }
        }
        return array_unique($result);
    }

    /**
     * Validates IPv4 address
     *
     * @param string $value
     * @return boolean
     */
    protected function validateIPv4($value)
    {
        return preg_match($this->ipv4Pattern, $value) !== 0;
    }

    /**
     * Validates IPv6 address
     *
     * @param string $value
     * @return boolean
     */
    protected function validateIPv6($value)
    {
        return preg_match($this->ipv6Pattern, $value) !== 0;
    }

    /**
     * Gets the IP version
     *
     * @param string $ip
     * @return integer
     */
    private function getIpVersion($ip)
    {
        return strpos($ip, ':') === false ? 4 : 6;
    }

    /**
     * Used to get the Regexp pattern for initial IP address parsing
     * @return string
     */
    private function getIpParsePattern()
    {
        return '/^(' . preg_quote(static::NEGATION_CHAR) . '?)(.+?)(\/(\d+))?$/';
    }

    /**
     * Checks whether the IP is in subnet range
     *
     * @param string $ip an IPv4 or IPv6 address
     * @param integer $cidr
     * @param string $range subnet in CIDR format e.g. `10.0.0.0/8` or `2001:af::/64`
     * @return bool
     */
    private function inRange($ip, $cidr, $range)
    {
        $ipVersion = $this->getIpVersion($ip);
        $binIp = $this->ip2bin($ip);

        $parts = explode('/', $range);
        $net = array_shift($parts);
        $range_cidr = array_shift($parts);


        $netVersion = $this->getIpVersion($net);
        if ($ipVersion !== $netVersion) {
            return false;
        }
        if ($range_cidr === null) {
            $range_cidr = $netVersion === 4 ? static::IPV4_ADDRESS_LENGTH : static::IPV6_ADDRESS_LENGTH;
        }

        $binNet = $this->ip2bin($net);
        if (substr($binIp, 0, $range_cidr) === substr($binNet, 0, $range_cidr) && $cidr >= $range_cidr) {
            return true;
        }
        return false;
    }

    /**
     * Converts IP address to bits representation
     *
     * @param string $ip
     * @return string bits as a string
     */
    private function ip2bin($ip)
    {
        if ($this->getIpVersion($ip) === 4) {
            return str_pad(base_convert(ip2long($ip), 10, 2), static::IPV4_ADDRESS_LENGTH, '0', STR_PAD_LEFT);
        } else {
            $unpack = unpack('A16', inet_pton($ip));
            $binStr = array_shift($unpack);
            $bytes = static::IPV6_ADDRESS_LENGTH / 8; // 128 bit / 8 = 16 bytes
            $result = '';
            while ($bytes-- > 0) {
                $result = sprintf('%08b', isset($binStr[$bytes]) ? ord($binStr[$bytes]) : '0') . $result;
            }
            return $result;
        }
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $messages = [
            'ipv6NotAllowed' => $this->ipv6NotAllowed,
            'ipv4NotAllowed' => $this->ipv4NotAllowed,
            'wrongIp' => $this->wrongIp,
            'noSubnet' => $this->noSubnet,
            'hasSubnet' => $this->hasSubnet,
        ];
        foreach ($messages as &$message) {
            $message = Uni::$app->getI18n()->format($message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ], Uni::$app->language);
        }

        $options = [
            'ipv4Pattern' => new JsExpression(Html::escapeJsRegularExpression($this->ipv4Pattern)),
            'ipv6Pattern' => new JsExpression(Html::escapeJsRegularExpression($this->ipv6Pattern)),
            'messages' => $messages,
            'ipv4' => (boolean)$this->ipv4,
            'ipv6' => (boolean)$this->ipv6,
            'ipParsePattern' => new JsExpression(Html::escapeJsRegularExpression($this->getIpParsePattern())),
            'negation' => $this->negation,
            'subnet' => $this->subnet
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);

        return 'uni.validation.ip(value, messages, ' . Json::htmlEncode($options) . ');';
    }
}
