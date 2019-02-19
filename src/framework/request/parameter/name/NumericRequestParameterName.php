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
 * Class NumericRequestParameterName
 *
 * @package Lucille\Request\Parameter
 */
class NumericRequestParameterName implements RequestParameterName {
    
    /**
     * @var int
     */
    private $name;
    
    /**
     * @param int $name Parameter name
     */
    public function __construct(int $name) {
        $this->name = $name;
    }
    
    /**
     * @return int
     */
    public function asInt(): int {
        return $this->name;
    }
    
}
