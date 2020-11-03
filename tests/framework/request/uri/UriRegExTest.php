<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\UriRegEx;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\UriRegEx
 */
class UriRegExTest extends TestCase {
    
    /**
     * @covers ::asString
     * @covers ::__construct
     */
    public function testReturnsInitialRegexPattern() {
        $regex = new UriRegEx('#(.*)#');
        $this->assertEquals('#(.*)#', $regex->asString());
    }
    
}
