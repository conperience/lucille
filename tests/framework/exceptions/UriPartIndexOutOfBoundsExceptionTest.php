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
     *                                                          
     * @expectedException \Lucille\Exceptions\UriPartIndexOutOfBoundsException
     */
    public function testException() {
        throw new UriPartIndexOutOfBoundsException('message');
    }
    
}
    
