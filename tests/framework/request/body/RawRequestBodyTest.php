<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\Body\RawRequestBody;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\Body\RawRequestBody
 */
class RawRequestBodyTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::asString
     */
    public function testReturnsInitialContent() {
        $str = "test string\ndemo=foo";
        $body = new RawRequestBody($str);
        $this->assertEquals($str, $body->asString());
    }
    
}
    
