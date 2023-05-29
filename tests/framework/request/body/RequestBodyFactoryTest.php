<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\Body\EmptyRequestBody;
use Lucille\Request\Body\RawRequestBody;
use Lucille\Request\Body\RequestBodyFactory;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\Body\RequestBodyFactory
 */
class RequestBodyFactoryTest extends TestCase {
    
    /**
     * @covers ::fromStream
     */
    public function testFromStreamReturnsEmptyBody() {
        $body = RequestBodyFactory::fromStream('/dev/null');
        $this->assertInstanceOf(EmptyRequestBody::class, $body);
    }
    
    /**
     * @covers ::fromStream
     * @uses   \Lucille\Request\Body\RawRequestBody::__construct
     * @uses   \Lucille\Request\Body\RawRequestBody::asString
     */
    public function testFromStreamReturnsRawRequestBody() {
        $body = RequestBodyFactory::fromStream(__DIR__.'/fixtures/body.txt');
        $this->assertInstanceOf(RawRequestBody::class, $body);
        $this->assertSame("demo=foo\nbar=123\n", $body->asString());
    }
    
}
