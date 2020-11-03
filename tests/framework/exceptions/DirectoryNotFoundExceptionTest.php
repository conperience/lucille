<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Exceptions\DirectoryNotFoundException;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Exceptions\DirectoryNotFoundException
 */
class DirectoryNotFoundExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::getPath
     * @uses   \Lucille\Exceptions\DirectoryNotFoundException::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testGetPathReturnsDirectoryPathAsString() {
        try {
            throw new DirectoryNotFoundException('/tmp');
        } catch (DirectoryNotFoundException $e) {
            $this->assertEquals('/tmp', $e->getPath());
        }
    }
    
}
