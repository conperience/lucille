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
 * Class UriRegEx
 *
 * @package Lucille\Request
 */
class UriRegEx {
    
    /**
     * @var string
     */
    private $pattern;
    
    /**
     * @param string $pattern RegEx pattern
     */
    public function __construct(string $pattern) {
        $this->pattern = $pattern;
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return $this->pattern;
    }
    
}
