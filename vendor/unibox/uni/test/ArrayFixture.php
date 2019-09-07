<?php
/**
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 */

namespace uni\test;

use Uni;
use uni\base\ArrayAccessTrait;
use uni\base\InvalidConfigException;

/**
 * ArrayFixture represents arbitrary fixture that can be loaded from PHP files.
 *
 * @author Mark Jebri <mark.github@yandex.ru>
 * @since alfa version
 */
class ArrayFixture extends Fixture implements \IteratorAggregate, \ArrayAccess, \Countable
{
    use ArrayAccessTrait;

    /**
     * @var array the data rows. Each array element represents one row of data (column name => column value).
     */
    public $data = [];
    /**
     * @var string|boolean the file path or path alias of the data file that contains the fixture data
     * to be returned by [[getData()]]. You can set this property to be false to prevent loading any data.
     */
    public $dataFile;


    /**
     * Loads the fixture.
     *
     * The default implementation simply stores the data returned by [[getData()]] in [[data]].
     * You should usually override this method by putting the data into the underlying database.
     */
    public function load()
    {
        $this->data = $this->getData();
    }

    /**
     * Returns the fixture data.
     *
     * The default implementation will try to return the fixture data by including the external file specified by [[dataFile]].
     * The file should return the data array that will be stored in [[data]] after inserting into the database.
     *
     * @return array the data to be put into the database
     * @throws InvalidConfigException if the specified data file does not exist.
     */
    protected function getData()
    {
        if ($this->dataFile === false || $this->dataFile === null) {
            return [];
        }
        $dataFile = Uni::getAlias($this->dataFile);
        if (is_file($dataFile)) {
            return require($dataFile);
        } else {
            throw new InvalidConfigException("Fixture data file does not exist: {$this->dataFile}");
        }
    }

    /**
     * @inheritdoc
     */
    public function unload()
    {
        parent::unload();
        $this->data = [];
    }

}
