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
 * Class StringRequestParameter
 *
 * @package Lucille\Request\Parameter
 */
class StringRequestParameter implements RequestParameter {
    
    /**
     * @var RequestParameterName
     */
    private $name;
    
    /**
     * @var string
     */
    private $value;
    
    /**
     * @param RequestParameterName $name  Parameter name
     * @param string               $value Parameter value
     */
    public function __construct(RequestParameterName $name, string $value) {
        $this->name = $name;
        $this->value = $value;
    }
    
    /**
     * @return RequestParameterName
     */
    public function getName(): RequestParameterName {
        return $this->name;
    }

    /**
     * @return string
     */
    public function asString(): string {
        return (string)$this->value;
    }

    /**
     * @return int
     */
    public function asInt(): int {
        return (int)$this->value;
    }

    /**
     * @return float
     */
    public function asFloat(): float {
        return (float)$this->value;
    }
    
}
