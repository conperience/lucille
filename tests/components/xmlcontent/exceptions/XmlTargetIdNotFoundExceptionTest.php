<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Components\Xml\Exceptions\XmlTargetIdNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Components\Xml\Exceptions\XmlTargetIdNotFoundException
 */
class XmlTargetIdNotFoundExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testXmlTargetIdNotFoundException() {
        $this->expectException(XmlTargetIdNotFoundException::class);
        throw new XmlTargetIdNotFoundException('node1');
    }
    
    /**
     * @covers ::getTargetId
     * @uses   \Lucille\Components\Xml\Exceptions\XmlTargetIdNotFoundException::__construct
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testGetTargetIdReturnsTargetIdAsString() {
        try {
            throw new XmlTargetIdNotFoundException('node1');
        } catch (XmlTargetIdNotFoundException $e) {
            $this->assertEquals('node1', $e->getTargetId());
        }
    }
    
}
