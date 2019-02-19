<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Exceptions\HeaderNotFoundException;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Exceptions\HeaderNotFoundException
 */
class HeaderNotFoundExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::getHeaderName
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testGetHeaderName() {
        try {
            throw new HeaderNotFoundException('HTTP_X_API');
        } catch (HeaderNotFoundException $e) {
            $this->assertEquals('HTTP_X_API', $e->getHeaderName());
        }
    }
    
}
    
