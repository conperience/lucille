<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Header;

use Lucille\Exceptions\HeaderNotFoundException;

/**
 * Class HeaderCollection
 *
 * @package Lucille\Header
 */
class HeaderCollection implements \IteratorAggregate,\Countable {
    
    /**
     * @var array
     */
    private $headerList = array();
    
    /**
     * @param Header $header Header object
     * @return void
     */
    public function addHeader(Header $header): void {
        $this->headerList[$header->getName()] = $header;
    }
    
    /**
     * @param string $name Header name
     * @return Header
     * @throws HeaderNotFoundException
     */
    public function getHeader(string $name): Header {
        if (!isset($this->headerList[$name])) {
            throw new HeaderNotFoundException($name);
        }
        return $this->headerList[$name];
    }
    
    /**
     * @return HeaderCollection
     * @param array $headerSource Header source data (e.g. _SERVER variable)
     */
    public static function fromSource(array $headerSource): HeaderCollection {
        $headerCollection = new HeaderCollection();
        
        foreach ($headerSource as $name => $value) {
            if (substr($name, 0, 5) === 'HTTP_') {
                $headerCollection->addHeader(new Header($name, $value));
            }
        }
        
        return $headerCollection;
    }
    
    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator {
        return new \ArrayIterator($this->headerList);
    }
    
    /**
     * @return int
     */
    public function count(): int {
        return count($this->headerList);
    }
    
}
