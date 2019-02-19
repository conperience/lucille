<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Header;

/**
 * Class Header
 *
 * @package Lucille\Header
 */
class Header {
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var string
     */
    private $value;
    
    /**
     * @param string $name  Header name
     * @param string $value Header value
     */
    public function __construct(string $name, string $value) {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return sprintf('%s: %s', $this->getName(), $this->getValue());
    }
    
}
