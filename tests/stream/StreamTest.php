<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Components\Stream\Exceptions\CannotRegisterStreamException;
use Lucille\Components\Stream\Exceptions\CannotUnregisterStreamException;
use Lucille\Components\Stream\Exceptions\StreamAlreadyRegisteredException;
use Lucille\Components\Stream\Exceptions\StreamNotRegisteredException;
use Lucille\Components\Stream\StreamName;
use Lucille\Directory;
use Lucille\Components\Stream\Stream;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Components\Stream\Stream
 */
class StreamTest extends TestCase {
    
    /**
     * @covers ::registerStream
     * @covers ::isRegistered
     * @uses   \Lucille\Components\Stream\Stream::unregisterStream
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     */
    public function testRegisterNewScheme() {
        Stream::unregisterStream(new StreamName('templates'));
        Stream::registerStream(new StreamName('templates'), new Directory(__DIR__.'/data'));
        $this->assertTrue(Stream::isRegistered(new StreamName('templates')));
    }
    
    /**
     * @covers ::registerStream
     * @covers ::isRegistered
     * @uses   \Lucille\Components\Stream\Stream::unregisterStream
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     *
     * @uses   \Lucille\Components\Stream\Exceptions\CannotRegisterStreamException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testRegisterInternalDefinedStreamThrowsException() {
        $this->expectException(CannotRegisterStreamException::class);
        @Stream::registerStream(new StreamName('php'), new Directory(__DIR__.'/data'));
    }
    
    /**
     * @covers ::registerStream
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     *
     * @uses   \Lucille\Components\Stream\Exceptions\StreamAlreadyRegisteredException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testRegisterAlreadyDefinedSchemeThrowsException() {
        $this->expectException(StreamAlreadyRegisteredException::class);
        Stream::registerStream(new StreamName('templates'), new Directory(__DIR__.'/data'));
        Stream::registerStream(new StreamName('templates'), new Directory(__DIR__.'/data'));
    }
    
    /**
     * @covers ::unregisterStream
     * @uses   \Lucille\Components\Stream\Stream::registerStream
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     */
    public function testUnregisterScheme() {
        Stream::unregisterStream(new StreamName('templates'));
        Stream::registerStream(new StreamName('templates'), new Directory(__DIR__.'/data'));
        Stream::unregisterStream(new StreamName('templates'));
        $this->assertFalse(Stream::isRegistered(new StreamName('templates')));
    }
    
    /**
     * @covers ::unregisterStream
     * @uses   \Lucille\Components\Stream\Stream::registerStream
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     *
     * @uses   \Lucille\Components\Stream\Exceptions\CannotUnregisterStreamException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testUnregisterAlreadyUnregisteredSchemeThrowsException() {
        $this->expectException(CannotUnregisterStreamException::class);
        
        Stream::unregisterStream(new StreamName('test'));
        Stream::registerStream(new StreamName('test'), new Directory(__DIR__.'/data'));
        stream_wrapper_unregister('test');
        @Stream::unregisterStream(new StreamName('test'));
    }
    
    /**
     * @covers ::getRegisteredPath
     * @uses   \Lucille\Components\Stream\Stream::registerStream
     * @uses   \Lucille\Components\Stream\Stream::unregisterStream
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     */
    public function testGetRegisteredPathReturnsSchemePathString() {
        Stream::registerStream(new StreamName('templates'), new Directory(__DIR__.'/data'));
        $this->assertEquals(__DIR__.'/data', Stream::getRegisteredPath(new StreamName('templates')));
    }
    
    /**
     * @covers ::getRegisteredPath
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\Stream::unregisterStream
     * @uses   \Lucille\Components\Stream\StreamName
     *
     * @uses   \Lucille\Components\Stream\Exceptions\StreamNotRegisteredException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testGetRegisteredPathForUndefinedSchemeThrowsException() {
        $this->expectException(StreamNotRegisteredException::class);
        Stream::getRegisteredPath(new StreamName('notdefined'));
    }
    
    /**
     * @covers ::translate
     * @uses   \Lucille\Components\Stream\Stream::registerStream
     * @uses   \Lucille\Components\Stream\Stream::unregisterStream
     * @uses   \Lucille\Components\Stream\Stream::getRegisteredPath
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     */
    public function testTranslateReturnsFullPath() {
        Stream::unregisterStream(new StreamName('templates'));
        Stream::registerStream(new StreamName('templates'), new Directory(__DIR__.'/data'));
        $this->assertEquals(__DIR__.'/data/demo/1.xsl', Stream::translate('templates://demo/1.xsl'));
    }
    
    /**
     * @covers ::translate
     * @uses   \Lucille\Components\Stream\Stream::registerStream
     * @uses   \Lucille\Components\Stream\Stream::unregisterStream
     * @uses   \Lucille\Components\Stream\Stream::getRegisteredPath
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     */
    public function testTranslateRootDirectoryReturnsPath() {
        Stream::unregisterStream(new StreamName('templates'));
        Stream::registerStream(new StreamName('templates'), new Directory(__DIR__.'/data'));
        $this->assertEquals(__DIR__.'/data/1.xsl', Stream::translate('templates:///1.xsl'));
    }
    
    /**
     * @covers ::translate
     * @uses   \Lucille\Components\Stream\Stream::registerStream
     * @uses   \Lucille\Components\Stream\Stream::unregisterStream
     * @uses   \Lucille\Components\Stream\Stream::getRegisteredPath
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     */
    public function testTranslateUnregisteredStreamReturnsInitialPath() {
        Stream::unregisterStream(new StreamName('templates'));
        $this->assertEquals('templates://demo/1.xsl', Stream::translate('templates://demo/1.xsl'));
    }
    
    /**
     * @covers ::stream_read
     * @covers ::stream_open
     * @uses   \Lucille\Components\Stream\Stream::registerStream
     * @uses   \Lucille\Components\Stream\Stream::unregisterStream
     * @uses   \Lucille\Components\Stream\Stream::getRegisteredPath
     * @uses   \Lucille\Components\Stream\Stream::isRegistered
     * @uses   \Lucille\Components\Stream\Stream::translate
     * @uses   \Lucille\Components\Stream\StreamName
     *
     * @uses   \Lucille\Components\Stream\Stream::stream_open
     * @uses   \Lucille\Components\Stream\Stream::stream_close
     * @uses   \Lucille\Components\Stream\Stream::stream_eof
     *
     * @uses   \Lucille\Directory
     */
    public function testStreamReadReturnsFileContent() {
        Stream::unregisterStream(new StreamName('templates'));
        Stream::registerStream(new StreamName('templates'), new Directory(__DIR__.'/data'));
        
        $handle = fopen('templates://test.txt', 'r');
        $data = fread($handle, 100);
        $this->assertEquals("123\n", $data);
    }
    
}
