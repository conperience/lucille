<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\Body\EmptyRequestBody;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\Body\EmptyRequestBody
 */
class EmptyRequestBodyTest extends TestCase {
    
    /**
     * @covers ::asString
     */
    public function testReturnsInitialContent() {
        $body = new EmptyRequestBody();
        $this->assertEquals('', $body->asString());
    }
    
}
    
