<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request;

/**
 * Class UriPart
 *
 * @package Lucille\Request
 */
class UriPart {
    
    /**
     * @var string
     */
    private $part;
    
    /**
     * @param string $part URI sub part
     */
    public function __construct(string $part) {
        $this->part = $part;
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return $this->part;
    }
    
}
