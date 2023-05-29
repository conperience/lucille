<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;
        
use Lucille\Exceptions\FileNotFoundException;
use Lucille\Filename;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Filename
 */
class FilenameTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::asString
     * @uses   \Lucille\Exceptions\FileNotFoundException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testReturnsInitialFilenameAsString() {
        $filename = new Filename(TEST_FILE);
        $this->assertSame(TEST_FILE, $filename->asString());
    }
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\FileNotFoundException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testThrowsExceptionIfFileDoesNotExist() {
        $this->expectException(FileNotFoundException::class);
        
        $filename = new Filename('/tmp/notexist');
    }
    
}
