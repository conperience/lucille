<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Exceptions\FileNotFoundException;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Exceptions\FileNotFoundException
 */
class FileNotFoundExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::getFilename
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testGetFilenameReturnsFilenameString() {
        try {
            throw new FileNotFoundException('/tmp/foo.log');
        } catch (FileNotFoundException $e) {
            $this->assertEquals('/tmp/foo.log', $e->getFilename());
        }
    }
    
}
    
