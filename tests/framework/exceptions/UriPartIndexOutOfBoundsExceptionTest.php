<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Exceptions\UriPartIndexOutOfBoundsException;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Exceptions\UriPartIndexOutOfBoundsException
 */
class UriPartIndexOutOfBoundsExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testException() {
        $this->expectException(UriPartIndexOutOfBoundsException::class);
        
        throw new UriPartIndexOutOfBoundsException('message');
    }
    
}
    
