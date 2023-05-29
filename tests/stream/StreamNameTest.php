<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Components\Stream\StreamName;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Components\Stream\StreamName
 */
class StreamNameTest extends TestCase {
    
    /**
     * @covers ::asString
     * @covers ::__construct
     */
    public function testReturnsInitialStreamName() {
        $streamName = new StreamName('test');
        $this->assertSame('test', $streamName->asString());
    }
    
}
