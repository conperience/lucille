<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Stream\Exceptions\CannotRegisterStreamException;
use Lucille\Components\Stream\StreamName;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Components\Stream\Exceptions\CannotRegisterStreamException
 */
class CannotRegisterStreamExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::getProtocolName
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Components\Stream\StreamName
     */
    public function testGetProtocolName() {
        try {
            throw new CannotRegisterStreamException(new StreamName('templates'));
        } catch (CannotRegisterStreamException $e) {
            $this->assertEquals('templates', $e->getProtocolName()->asString());
        }
    }
    
}
    
