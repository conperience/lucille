<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Xml;

/**
 * Class XPathQuery
 *
 * @package Lucille\Components\Xml
 */
class XPathQuery {
    
    /**
     * @var string
     */
    private $queryString;
    
    /**
     * @param string $queryString XPath query string
     */
    public function __construct(string $queryString) {
        $this->queryString = $queryString;
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return $this->queryString;
    }

}
