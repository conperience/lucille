<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Stream\Exceptions\StreamNotRegisteredException;
use Lucille\Components\Stream\StreamName;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Components\Stream\Exceptions\StreamNotRegisteredException
 */
class StreamNotRegisteredExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::getProtocolName
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Components\Stream\StreamName
     */
    public function testGetParameterCollectionName() {
        try {
            throw new StreamNotRegisteredException(new StreamName('templates'));
        } catch (StreamNotRegisteredException $e) {
            $this->assertEquals('templates', $e->getProtocolName()->asString());
        }
    }
    
}
