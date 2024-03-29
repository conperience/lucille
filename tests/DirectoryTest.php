<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;
        
use Lucille\Directory;
use Lucille\Exceptions\DirectoryNotFoundException;
use Lucille\Filename;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Directory
 */
class DirectoryTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::asString
     * @uses   \Lucille\Exceptions\DirectoryNotFoundException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testReturnsInitialDirectoryPathAsString() {
        $dir = new Directory('/tmp');
        $this->assertSame('/tmp', $dir->asString());
    }
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\DirectoryNotFoundException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testThrowsExceptionIfDirectoryDoesNotExist() {
        $this->expectException(DirectoryNotFoundException::class);
        
        $dir = new Directory('/tmp/notexist');
    }
    
}
