<?php

namespace ReadingLists\Type;

/**
 * A type for holding a numeric identifier
 *
 * @package ReadingLists
 * @subpackage Type
 */

class Id {
    /** @var float The numeric identifier */
    protected $id = null;

    /** 
     * The id that represents a new identifier that must be exchanged
     * when stored in the repository
     */
    const NEW_ID = 0;

    /**
     * Creates a new identifier
     *
     * @param float $id The numeric identifier
     */
    public function __construct($id = 0) {
        $this->id = is_numeric($id) ? $id : (int)$id;

        if ($this->id < static::NEW_ID) {
            $id = static::NEW_ID;
        }
    }

    /**
     * Whether the identifier is a new id and must be exchanged when stored
     *
     * @return bool
     */
    public function isNew() {
        return $this->id == static::NEW_ID;
    }

    /** 
     * Compares this identifier to another identifier
     *
     * @return bool
     */
    public function equals(Id $id) {
        return $this->id = $id->getId();
    }

    /**
     * Gets the internal identifier
     *
     * @return float
     */
    public function getId() {
        return $this->id;
    }

}

