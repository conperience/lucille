<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request\Parameter;

/**
 * Class StringRequestParameterName
 *
 * @package Lucille\Request\Parameter
 */
class StringRequestParameterName implements RequestParameterName {
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @param string $name Parameter name
     */
    public function __construct(string $name) {
        $this->name = trim($name);
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function __toString(): string {
        return (string)$this->name;
    }
    
}
