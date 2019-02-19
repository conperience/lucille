<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request\Body;

/**
 * Class RawRequestBody
 *
 * @package Lucille\Request\Body
 */
class RawRequestBody implements RequestBody {
    
    /**
     * @var string
     */
    private $content;
    
    /**
     * @param string $content Http request body content
     */
    public function __construct(string $content) {
        $this->content = $content;
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return $this->content;
    }
    
}
