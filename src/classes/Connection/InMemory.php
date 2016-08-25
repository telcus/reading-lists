<?php

namespace ReadingLists\Connection;

/**
 * A simple connection for holding repository data in an array
 *
 * This connection stores the required data in an array for later use
 * in the same call. Data stored in this connection is transitory and
 * will not survive the end of the script
 *
 *  @package ReadingLists
 *  @subpackage Connection
 *
 */
class InMemory {
    /** @var array Holds any data the repository wishes to store */
    protected $data = array();

    /**
     * Constructor for the InMemory connection
     *
     * @param array $default_data The default set of data to prime this connection
     */
    public function __construct($default_data = []) {
        $this->data = is_array($default_data) ? $default_data : [ $default_data ];
    }

    /**
     * Returns whether a particular section exists
     *
     * @param string $section the section to check
     *
     * @return bool
     */
    public function has($section) {
        return isset($this->data[$section]);
    }

    /**
     * Gets the data held for the specified key or all data when no key is specified
     *
     * @param string|null $section The section to return
     * 
     * @return mixed 
     */
    public function get($section = null) {
        if ($section !== null) {
            return isset($this->data[$section]) ? $this->data[$section] : null;
        } else {
            return $this->data;
        }
    }

    /**
     * Sets the data held for the specified key or sets all data when no key is specified
     *
     * @param string|null $section The section of the data to set
     * @param mixed $data The data to store in that section
     */
    public function set($section = null, $data) {
        if ($section !== null) {
            $this->data[$section] = $data;
        } else {
            $this->data = is_array($data) ? $data : [ $data ];
        }
    }

}

