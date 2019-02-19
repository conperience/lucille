<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Components\Xml\Exceptions\XmlTargetIdNotUniqueException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Components\Xml\Exceptions\XmlTargetIdNotUniqueException
 */
class XmlTargetIdNotUniqueExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\LucilleException
     *                                            
     * @expectedException \Lucille\Components\Xml\Exceptions\XmlTargetIdNotUniqueException
     */
    public function testXmlTargetIdNotUniqueException() {
        throw new XmlTargetIdNotUniqueException('node2');
    }
    
    /**
     * @covers ::getTargetId
     * @uses   \Lucille\Components\Xml\Exceptions\XmlTargetIdNotUniqueException::__construct
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testGetTargetIdReturnsTargetIdAsString() {
        try {
            throw new XmlTargetIdNotUniqueException('node2');
        } catch (XmlTargetIdNotUniqueException $e) {
            $this->assertEquals('node2', $e->getTargetId());
        }
    }
    
}
