<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Header\Header;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Header\Header
 */
class HeaderTest extends TestCase {
    
    /**
     * @covers ::getName
     * @covers ::__construct
     */
    public function testReturnsHeaderName() {
        $header = new Header('header_name', 'demo123');
        $this->assertEquals('header_name', $header->getName());
    }
    
    /**
     * @covers ::getValue
     * @uses   Lucille\Header\Header::__construct
     */
    public function testReturnsHeaderValue() {
        $header = new Header('header_name', 'demo123');
        $this->assertEquals('demo123', $header->getValue());
    }

    /**
     * @covers ::asString
     * @uses   Lucille\Header\Header::__construct
     * @uses   Lucille\Header\Header::getName
     * @uses   Lucille\Header\Header::getValue
     */
    public function testReturnsHeaderAsString() {
        $header = new Header('header_name', 'demo123');
        $this->assertEquals('header_name: demo123', $header->asString());
    }
    
}
    
