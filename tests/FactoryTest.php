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
use Lucille\Factory;
use Lucille\Request\RequestFactory;
use Lucille\RequestProcessor;
use Lucille\Routing\DeleteRoutingChain;
use Lucille\Routing\GetRoutingChain;
use Lucille\Routing\PatchRoutingChain;
use Lucille\Routing\PostRoutingChain;
use Lucille\Routing\PutRoutingChain;
use Lucille\Routing\ResultRoutingChain;
use Lucille\Components\Stream\Stream;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Factory
 */
class FactoryTest extends TestCase {
    
    private $factory;
    
    public function setUp(): void {
        $this->factory = new Factory();
    }
    
    /**
     * @covers ::createRequestFactory
     * @uses   \Lucille\Request\RequestFactory
     */
    public function testCreateRequestFactoryWithDefaults() {
        $this->assertInstanceOf(RequestFactory::class, $this->factory->createRequestFactory());
    }

    /**
     * @covers ::createGetRoutingChain
     * @uses   \Lucille\Routing\GetRoutingChain
     */
    public function testCreateGetRoutingChain() {
        $this->assertInstanceOf(GetRoutingChain::class, $this->factory->createGetRoutingChain());
    }

    /**
     * @covers ::createPostRoutingChain
     * @uses   \Lucille\Routing\PostRoutingChain
     */
    public function testCreatePostRoutingChain() {
        $this->assertInstanceOf(PostRoutingChain::class, $this->factory->createPostRoutingChain());
    }
    
    /**
     * @covers ::createPutRoutingChain
     * @uses   \Lucille\Routing\PutRoutingChain
     */
    public function testCreatePutRoutingChain() {
        $this->assertInstanceOf(PutRoutingChain::class, $this->factory->createPutRoutingChain());
    }

    /**
     * @covers ::createPatchRoutingChain
     * @uses   \Lucille\Routing\PatchRoutingChain
     */
    public function testCreatePatchRoutingChain() {
        $this->assertInstanceOf(PatchRoutingChain::class, $this->factory->createPatchRoutingChain());
    }

    /**
     * @covers ::createDeleteRoutingChain
     * @uses   \Lucille\Routing\DeleteRoutingChain
     */
    public function testCreateDeleteRoutingChain() {
        $this->assertInstanceOf(DeleteRoutingChain::class, $this->factory->createDeleteRoutingChain());
    }

    /**
     * @covers ::createResultRoutingChain
     * @uses   \Lucille\Routing\ResultRoutingChain
     */
    public function testCreateResultRoutingChain() {
        $this->assertInstanceOf(ResultRoutingChain::class, $this->factory->createResultRoutingChain());
    }
    
    /**
     * @covers ::createRequestProcessor
     */
    public function testCreateRequestProcessor() {
        $this->assertInstanceOf(RequestProcessor::class, $this->factory->createRequestProcessor());
    }
    
    /**
     * @covers ::registerStream
     * @uses   \Lucille\Components\Stream\Stream
     * @uses   \Lucille\Components\Stream\StreamName
     * @uses   \Lucille\Directory
     */
    public function testRegisterStream() {
        @stream_wrapper_unregister('templates');
        $this->factory->registerStream('templates', '/tmp');
        $this->assertTrue(Stream::isRegistered(new StreamName('templates')));
    }
    
}
