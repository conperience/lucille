<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Exceptions\HeaderNotFoundException;
use Lucille\Header\Header;
use Lucille\Header\HeaderCollection;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Header\HeaderCollection
 */
class HeaderCollectionTest extends TestCase {

    /**
     * @covers ::addHeader
     * @covers ::getHeader
     * @uses   \Lucille\Header\Header
     */
    public function testAddHeader() {
        $header = new Header('HTTP_X_HEADER1', 'bar123');
        $collection = new HeaderCollection();
        $collection->addHeader($header);
        $this->assertSame($header, $collection->getHeader('HTTP_X_HEADER1'));
    }

    /**
     * @covers ::count
     */
    public function testCountableReturnsHeaderCountIfNoHeadersAreSet() {
        $collection = new HeaderCollection();
        $this->assertCount(0, $collection);
    }
    
    /**
     * @covers ::count
     * @uses   \Lucille\Header\HeaderCollection::addHeader
     * @uses   \Lucille\Header\Header
     */
    public function testCountableReturnsHeaderCountIfHeadersAreSet() {
        $collection = new HeaderCollection();
        $collection->addHeader(new Header('HTTP_X_HEADER1', 'bar'));
        $collection->addHeader(new Header('HTTP_X_HEADER2', 'foo'));
        $this->assertCount(2, $collection);
    }
    
    /**
     * @covers ::getIterator
     * @uses   \Lucille\Header\HeaderCollection::addHeader
     * @uses   \Lucille\Header\Header
     */
    public function testGetIteratorReturnsArrayIterator() {
        $collection = new HeaderCollection();
        $this->assertInstanceOf(\ArrayIterator::class, $collection->getIterator());
    }
    
    /**
     * @covers ::getHeader
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Exceptions\HeaderNotFoundException::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testGetNonExistingHeaderThrowsException() {
        $this->expectException(HeaderNotFoundException::class);
        
        $collection = new HeaderCollection();
        $collection->getHeader('test');
    }
    
    /**
     * @covers ::fromSource
     * @uses   \Lucille\Header\HeaderCollection::addHeader
     * @uses   \Lucille\Header\HeaderCollection::getHeader
     * @uses   \Lucille\Header\Header
     */
    public function testFromSourceBuildHeaderCollectionFromSource() {
        $source = array(
            'HTTP_X_HEADER1' => 'foo',
            'HTTP_X_HEADER2' => 'bar'
        );
        
        $collection = HeaderCollection::fromSource($source);
        
        $header1 = $collection->getHeader('HTTP_X_HEADER1');
        $header2 = $collection->getHeader('HTTP_X_HEADER2');
        
        $this->assertSame('HTTP_X_HEADER1', $header1->getName());
        $this->assertSame('foo', $header1->getValue());
        
        $this->assertSame('HTTP_X_HEADER2', $header2->getName());
        $this->assertSame('bar', $header2->getValue());
    }

}
