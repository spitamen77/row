<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\validators;

use DateTime;
use IntlDateFormatter;
use Uni;
use uni\base\InvalidConfigException;
use uni\helpers\FormatConverter;

/**
 * DateValidator verifies if the attribute represents a date, time or datetime in a proper [[format]].
 *
 * It can also parse internationalized dates in a specific [[locale]] like e.g. `12 мая 2014` when [[format]]
 * is configured to use a time pattern in ICU format.
 *
 * It is further possible to limit the date within a certain range using [[min]] and [[max]].
 *
 * Additional to validating the date it can also export the parsed timestamp as a machine readable format
 * which can be configured using [[timestampAttribute]].
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @author Carsten Brandt <mail@cebe.cc>
 * @since alfa version
 */
class DateValidator extends Validator
{
    /**
     * @var string the date format that the value being validated should follow.
     * This can be a date time pattern as described in the [ICU manual](http://userguide.icu-project.org/formatparse/datetime#TOC-Date-Time-Format-Syntax).
     *
     * Alternatively this can be a string prefixed with `php:` representing a format that can be recognized by the PHP Datetime class.
     * Please refer to <http://php.net/manual/en/datetime.createfromformat.php> on supported formats.
     *
     * If this property is not set, the default value will be obtained from `Uni::$app->formatter->dateFormat`, see [[\uni\i18n\Formatter::dateFormat]] for details.
     *
     * Here are some example values:
     *
     * ```php
     * 'MM/dd/yyyy' // date in ICU format
     * 'php:m/d/Y' // the same date in PHP format
     * 'MM/dd/yyyy HH:mm' // not only dates but also times can be validated
     * ```
     *
     * **Note:** the underlying date parsers being used vary dependent on the format. If you use the ICU format and
     * the [PHP intl extension](http://php.net/manual/en/book.intl.php) is installed, the [IntlDateFormatter](http://php.net/manual/en/intldateformatter.parse.php)
     * is used to parse the input value. In all other cases the PHP [DateTime](http://php.net/manual/en/datetime.createfromformat.php) class
     * is used. The IntlDateFormatter has the advantage that it can parse international dates like `12. Mai 2015` or `12 мая 2014`, while the
     * PHP parser is limited to English only. The PHP parser however is more strict about the input format as it will not accept
     * `12.05.05` for the format `php:d.m.Y`, but the IntlDateFormatter will accept it for the format `dd.MM.yyyy`.
     * If you need to use the IntlDateFormatter you can avoid this problem by specifying a [[min|minimum date]].
     */
    public $format;
    /**
     * @var string the locale ID that is used to localize the date parsing.
     * This is only effective when the [PHP intl extension](http://php.net/manual/en/book.intl.php) is installed.
     * If not set, the locale of the [[\uni\base\Application::formatter|formatter]] will be used.
     * See also [[\uni\i18n\Formatter::locale]].
     */
    public $locale;
    /**
     * @var string the timezone to use for parsing date and time values.
     * This can be any value that may be passed to [date_default_timezone_set()](http://www.php.net/manual/en/function.date-default-timezone-set.php)
     * e.g. `UTC`, `Europe/Berlin` or `America/Chicago`.
     * Refer to the [php manual](http://www.php.net/manual/en/timezones.php) for available timezones.
     * If this property is not set, [[\uni\base\Application::timeZone]] will be used.
     */
    public $timeZone;
    /**
     * @var string the name of the attribute to receive the parsing result.
     * When this property is not null and the validation is successful, the named attribute will
     * receive the parsing result.
     *
     * This can be the same attribute as the one being validated. If this is the case,
     * the original value will be overwritten with the timestamp value after successful validation.
     * @see timestampAttributeFormat
     * @see timestampAttributeTimeZone
     */
    public $timestampAttribute;
    /**
     * @var string the format to use when populating the [[timestampAttribute]].
     * The format can be specified in the same way as for [[format]].
     *
     * If not set, [[timestampAttribute]] will receive a UNIX timestamp.
     * If [[timestampAttribute]] is not set, this property will be ignored.
     * @see format
     * @see timestampAttribute
     * @since alfa version.4
     */
    public $timestampAttributeFormat;
    /**
     * @var string the timezone to use when populating the [[timestampAttribute]]. Defaults to `UTC`.
     *
     * This can be any value that may be passed to [date_default_timezone_set()](http://www.php.net/manual/en/function.date-default-timezone-set.php)
     * e.g. `UTC`, `Europe/Berlin` or `America/Chicago`.
     * Refer to the [php manual](http://www.php.net/manual/en/timezones.php) for available timezones.
     *
     * If [[timestampAttributeFormat]] is not set, this property will be ignored.
     * @see timestampAttributeFormat
     * @since alfa version.4
     */
    public $timestampAttributeTimeZone = 'UTC';
    /**
     * @var integer|string upper limit of the date. Defaults to null, meaning no upper limit.
     * This can be a unix timestamp or a string representing a date time value.
     * If this property is a string, [[format]] will be used to parse it.
     * @see tooBig for the customized message used when the date is too big.
     * @since alfa version.4
     */
    public $max;
    /**
     * @var integer|string lower limit of the date. Defaults to null, meaning no lower limit.
     * This can be a unix timestamp or a string representing a date time value.
     * If this property is a string, [[format]] will be used to parse it.
     * @see tooSmall for the customized message used when the date is too small.
     * @since alfa version.4
     */
    public $min;
    /**
     * @var string user-defined error message used when the value is bigger than [[max]].
     * @since alfa version.4
     */
    public $tooBig;
    /**
     * @var string user-defined error message used when the value is smaller than [[min]].
     * @since alfa version.4
     */
    public $tooSmall;
    /**
     * @var string user friendly value of upper limit to display in the error message.
     * If this property is null, the value of [[max]] will be used (before parsing).
     * @since alfa version.4
     */
    public $maxString;
    /**
     * @var string user friendly value of lower limit to display in the error message.
     * If this property is null, the value of [[min]] will be used (before parsing).
     * @since alfa version.4
     */
    public $minString;

    /**
     * @var array map of short format names to IntlDateFormatter constant values.
     */
    private $_dateFormats = [
        'short'  => 3, // IntlDateFormatter::SHORT,
        'medium' => 2, // IntlDateFormatter::MEDIUM,
        'long'   => 1, // IntlDateFormatter::LONG,
        'full'   => 0, // IntlDateFormatter::FULL,
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Uni::t('uni', 'The format of {attribute} is invalid.');
        }
        if ($this->format === null) {
            $this->format = Uni::$app->formatter->dateFormat;
        }
        if ($this->locale === null) {
            $this->locale = Uni::$app->language;
        }
        if ($this->timeZone === null) {
            $this->timeZone = Uni::$app->timeZone;
        }
        if ($this->min !== null && $this->tooSmall === null) {
            $this->tooSmall = Uni::t('uni', '{attribute} must be no less than {min}.');
        }
        if ($this->max !== null && $this->tooBig === null) {
            $this->tooBig = Uni::t('uni', '{attribute} must be no greater than {max}.');
        }
        if ($this->maxString === null) {
            $this->maxString = (string) $this->max;
        }
        if ($this->minString === null) {
            $this->minString = (string) $this->min;
        }
        if ($this->max !== null && is_string($this->max)) {
            $timestamp = $this->parseDateValue($this->max);
            if ($timestamp === false) {
                throw new InvalidConfigException("Invalid max date value: {$this->max}");
            }
            $this->max = $timestamp;
        }
        if ($this->min !== null && is_string($this->min)) {
            $timestamp = $this->parseDateValue($this->min);
            if ($timestamp === false) {
                throw new InvalidConfigException("Invalid min date value: {$this->min}");
            }
            $this->min = $timestamp;
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $timestamp = $this->parseDateValue($value);
        if ($timestamp === false) {
            $this->addError($model, $attribute, $this->message, []);
        } elseif ($this->min !== null && $timestamp < $this->min) {
            $this->addError($model, $attribute, $this->tooSmall, ['min' => $this->minString]);
        } elseif ($this->max !== null && $timestamp > $this->max) {
            $this->addError($model, $attribute, $this->tooBig, ['max' => $this->maxString]);
        } elseif ($this->timestampAttribute !== null) {
            if ($this->timestampAttributeFormat === null) {
                $model->{$this->timestampAttribute} = $timestamp;
            } else {
                $model->{$this->timestampAttribute} = $this->formatTimestamp($timestamp, $this->timestampAttributeFormat);
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $timestamp = $this->parseDateValue($value);
        if ($timestamp === false) {
            return [$this->message, []];
        } elseif ($this->min !== null && $timestamp < $this->min) {
            return [$this->tooSmall, ['min' => $this->minString]];
        } elseif ($this->max !== null && $timestamp > $this->max) {
            return [$this->tooBig, ['max' => $this->maxString]];
        } else {
            return null;
        }
    }

    /**
     * Parses date string into UNIX timestamp
     *
     * @param string $value string representing date
     * @return integer|false a UNIX timestamp or `false` on failure.
     */
    protected function parseDateValue($value)
    {
        if (is_array($value)) {
            return false;
        }
        $format = $this->format;
        if (strncmp($this->format, 'php:', 4) === 0) {
            $format = substr($format, 4);
        } else {
            if (extension_loaded('intl')) {
                return $this->parseDateValueIntl($value, $format);
            } else {
                // fallback to PHP if intl is not installed
                $format = FormatConverter::convertDateIcuToPhp($format, 'date');
            }
        }
        return $this->parseDateValuePHP($value, $format);
    }

    /**
     * Parses a date value using the IntlDateFormatter::parse()
     * @param string $value string representing date
     * @param string $format the expected date format
     * @return integer|boolean a UNIX timestamp or `false` on failure.
     */
    private function parseDateValueIntl($value, $format)
    {
        if (isset($this->_dateFormats[$format])) {
            $formatter = new IntlDateFormatter($this->locale, $this->_dateFormats[$format], IntlDateFormatter::NONE, 'UTC');
        } else {
            // if no time was provided in the format string set time to 0 to get a simple date timestamp
            $hasTimeInfo = (strpbrk($format, 'ahHkKmsSA') !== false);
            $formatter = new IntlDateFormatter($this->locale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, $hasTimeInfo ? $this->timeZone : 'UTC', null, $format);
        }
        // enable strict parsing to avoid getting invalid date values
        $formatter->setLenient(false);

        // There should not be a warning thrown by parse() but this seems to be the case on windows so we suppress it here
        // See https://github.com/unisoft/uni2/issues/5962 and https://bugs.php.net/bug.php?id=68528
        $parsePos = 0;
        $parsedDate = @$formatter->parse($value, $parsePos);
        if ($parsedDate === false || $parsePos !== mb_strlen($value, Uni::$app ? Uni::$app->charset : 'UTF-8')) {
            return false;
        }

        return $parsedDate;
    }

    /**
     * Parses a date value using the DateTime::createFromFormat()
     * @param string $value string representing date
     * @param string $format the expected date format
     * @return integer|boolean a UNIX timestamp or `false` on failure.
     */
    private function parseDateValuePHP($value, $format)
    {
        // if no time was provided in the format string set time to 0 to get a simple date timestamp
        $hasTimeInfo = (strpbrk($format, 'HhGgis') !== false);

        $date = DateTime::createFromFormat($format, $value, new \DateTimeZone($hasTimeInfo ? $this->timeZone : 'UTC'));
        $errors = DateTime::getLastErrors();
        if ($date === false || $errors['error_count'] || $errors['warning_count']) {
            return false;
        }

        if (!$hasTimeInfo) {
            $date->setTime(0, 0, 0);
        }
        return $date->getTimestamp();
    }

    /**
     * Formats a timestamp using the specified format
     * @param integer $timestamp
     * @param string $format
     * @return string
     */
    private function formatTimestamp($timestamp, $format)
    {
        if (strncmp($format, 'php:', 4) === 0) {
            $format = substr($format, 4);
        } else {
            $format = FormatConverter::convertDateIcuToPhp($format, 'date');
        }

        $date = new DateTime();
        $date->setTimestamp($timestamp);
        $date->setTimezone(new \DateTimeZone($this->timestampAttributeTimeZone));
        return $date->format($format);
    }
}
