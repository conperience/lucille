<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Header\Header;
use Lucille\Header\HeaderCollection;
use Lucille\Response\GenericResponse;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Response\GenericResponse
 */
class GenericResponseTest extends TestCase {

    /**
     * @covers ::__construct
     * @uses   \Lucille\Response\GenericResponse::getHeaderCollection
     * @uses   \Lucille\Header\HeaderCollection
     */
    public function testReturnsInitialEmptyHeaderCollection() {
        $res = new TestResponse();
        
        $this->assertInstanceOf(HeaderCollection::class, $res->getHeaderCollection());
        $this->assertCount(0, $res->getHeaderCollection());
    }
    
    
    /**
     * @covers ::getResponseCode
     * @covers ::setResponseCode
     * @uses   \Lucille\Response\GenericResponse
     */
    public function testGetResponseCode() {
        $res = new TestResponse();
        $res->setResponseCode(340);
        
        $this->assertEquals(340, $res->getResponseCode());
    }

    /**
     * @covers ::getHeaderCollection
     * @covers ::addHeader
     * @uses   \Lucille\Header\HeaderCollection::addHeader
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Response\GenericResponse
     */
    public function testGetHeaderCollection() {
        $res = new TestResponse();
        $res->addHeader(new Header('h1', 'foo'));
        
        $this->assertInstanceOf(HeaderCollection::class, $res->getHeaderCollection());
    }

}
