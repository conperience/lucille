<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Xml\Exceptions\LoadingXmlFileFailedException;
use Lucille\Filename;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Components\Xml\Exceptions\LoadingXmlFileFailedException
 */
class LoadingXmlFailedException extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Filename
     *                                                          
     * @expectedException \Lucille\Components\Xml\Exceptions\LoadingXmlFileFailedException
     */
    public function testException() {
        throw new LoadingXmlFileFailedException(new Filename(TEST_FILE));
    }
    
    /**
     * @covers ::getFilename
     * @uses   \Lucille\Components\Xml\Exceptions\LoadingXmlFileFailedException::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Filename
     */
    public function testGetFilenameReturnsInitialValue() {
        try {
            throw new LoadingXmlFileFailedException(new Filename(TEST_FILE));
        } catch (LoadingXmlFileFailedException $e) {
            $this->assertEquals(TEST_FILE, $e->getFilename()->asString());
        }
    }
    
}
    
