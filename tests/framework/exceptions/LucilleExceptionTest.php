<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Exceptions\LucilleException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Exceptions\LucilleException
 */
class LucilleExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @expectedException \Lucille\Exceptions\LucilleException
     */
    public function testLucilleException() {
        throw new LucilleException('generic exception');
    }
    
    /**
     * @covers ::getFullMessage()
     * @uses   \Lucille\Exceptions\LucilleException::__construct()
     */
    public function testGetFullMessage() {
        try {
            throw new LucilleException('generic exception', 12);
        } catch (LucilleException $e) {
            $full = substr($e->getFullMessage(), 0, 56);
            $expected = "Lucille Framework Error (12) 'generic exception' at line";
            $this->assertEquals($expected, $full);
        }
    }
    
}
