<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Exceptions\UnsupportedRequestMethodException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Exceptions\UnsupportedRequestMethodException
 */
class UnsupportedHttpRequestMethodExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\LucilleException
     *                                            
     * @expectedException \Lucille\Exceptions\UnsupportedRequestMethodException
     */
    public function testUnsupportedHttpRequestMethodException() {
        throw new UnsupportedRequestMethodException('PATCH');
    }
    
}
