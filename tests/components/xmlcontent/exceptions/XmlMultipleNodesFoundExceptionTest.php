<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Components\Xml\Exceptions\XmlMultipleNodesFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Components\Xml\Exceptions\XmlMultipleNodesFoundException
 */
class XmlMultipleNodesFoundExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\LucilleException
     *                                            
     * @expectedException \Lucille\Components\Xml\Exceptions\XmlMultipleNodesFoundException
     */
    public function testXmlMultipleNodesFoundException() {
        throw new XmlMultipleNodesFoundException();
    }
    
}
