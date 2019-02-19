<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\UriPart;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\UriPart
 */
class UriPartTest extends TestCase {
    
    /**
     * @covers ::asString
     * @covers ::__construct
     */
    public function testReturnsInitialUriPartAsString() {
        $part = new UriPart('demo');
        $this->assertEquals('demo', $part->asString());
    }
    
}
    
