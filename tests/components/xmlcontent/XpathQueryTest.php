<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Xml\XPathQuery;

use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Components\Xml\XPathQuery
 */
class XpathQueryTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::asString
     */
    public function testReturnsInitialXpathQueryString() {
        $xp = new XPathQuery('/root/@label');
        $this->assertEquals('/root/@label', $xp->asString());
    }
    
}
    
