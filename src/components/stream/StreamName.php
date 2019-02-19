<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Stream;

/**
 * Class StreamName
 *
 * @package Lucille\Components\Stream
 */
class StreamName {
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @param string $name Stream Name
     */
    public function __construct(string $name) {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return $this->name;
    }
    
}
