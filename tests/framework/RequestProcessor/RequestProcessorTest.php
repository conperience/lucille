<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;
    
require_once __DIR__ . '/data.php';

use Lucille\Components\Xml\XhtmlResponse;
use Lucille\Exceptions\UnsupportedRoutingChainException;
use Lucille\Header\HeaderCollection;
use Lucille\Request\Body\EmptyRequestBody;
use Lucille\Request\DeleteRequest;
use Lucille\Request\GetRequest;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\PatchRequest;
use Lucille\Request\PostRequest;
use Lucille\Request\PutRequest;
use Lucille\Request\Uri;
use Lucille\RequestProcessor;
use Lucille\Response\LucilleErrorResponse;
use Lucille\Routing\DeleteRoutingChain;
use Lucille\Routing\GetRoutingChain;
use Lucille\Routing\PatchRoutingChain;
use Lucille\Routing\PostRoutingChain;
use Lucille\Routing\PutRoutingChain;
use Lucille\Routing\ResultRoutingChain;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\RequestProcessor
 */
class RequestProcessorTest extends TestCase {
    
    /**
     * @covers ::enableVerboseErrors
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testSetEnableVerboseErrors() {
        $proc = new RequestProcessor();
        $proc->enableVerboseErrors();
        $this->assertTrue($this->getPrivateClassProperty($proc, 'verboseError'));
    }

    /**
     * @covers ::addRoutingChain
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testAddGetRoutingChain() {
        $proc = new RequestProcessor();
        $chain = new GetRoutingChain();
        $proc->addRoutingChain($chain);
        
        $this->assertEquals($chain, $this->getPrivateClassProperty($proc, 'getRoutingChain'));
    }

    /**
     * @covers ::addRoutingChain
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testAddPostRoutingChain() {
        $proc = new RequestProcessor();
        $chain = new PostRoutingChain();
        $proc->addRoutingChain($chain);

        $this->assertEquals($chain, $this->getPrivateClassProperty($proc, 'postRoutingChain'));
    }

    /**
     * @covers ::addRoutingChain
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testAddPutRoutingChain() {
        $proc = new RequestProcessor();
        $chain = new PutRoutingChain();
        $proc->addRoutingChain($chain);
        
        $this->assertEquals($chain, $this->getPrivateClassProperty($proc, 'putRoutingChain'));
    }

    /**
     * @covers ::addRoutingChain
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testAddPatchRoutingChain() {
        $proc = new RequestProcessor();
        $chain = new PatchRoutingChain();
        $proc->addRoutingChain($chain);

        $this->assertEquals($chain, $this->getPrivateClassProperty($proc, 'patchRoutingChain'));
    }

    /**
     * @covers ::addRoutingChain
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testAddDeleteRoutingChain() {
        $proc = new RequestProcessor();
        $chain = new DeleteRoutingChain();
        $proc->addRoutingChain($chain);

        $this->assertEquals($chain, $this->getPrivateClassProperty($proc, 'deleteRoutingChain'));
    }

    /**
     * @covers ::addRoutingChain
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testAddResultRoutingChain() {
        $proc = new RequestProcessor();
        $chain = new ResultRoutingChain();
        $proc->addRoutingChain($chain);

        $this->assertEquals($chain, $this->getPrivateClassProperty($proc, 'resultRoutingChain'));
    }
    
    /**
     * @covers ::addRoutingChain
     * @uses   \Lucille\Exceptions\UnsupportedRoutingChainException
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testAddUnsupportedRoutingChainThrowsException() {
        $this->expectException(UnsupportedRoutingChainException::class);
        
        $proc = new RequestProcessor();
        $proc->addRoutingChain(new InvalidRoutingChain());
    }
    
    /**
     * @covers ::run
     *
     * @uses   \Lucille\RequestProcessor::addRoutingChain
     * @uses   \Lucille\Routing\ResultRoutingChain
     * @uses   \Lucille\Routing\GetRoutingChain
     * @uses   \Lucille\Request\GetRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Components\Xml\XhtmlContentResultRouter
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Components\Xml\XhtmlContent
     * @uses   \Lucille\Components\Xml\XhtmlResponse
     * @uses   \Lucille\Response\GenericResponse
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Routing\ResultRouter
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     */
    public function testProcessGetRequest() {
        $request = new GetRequest(new Uri('/de/page1'), new HeaderCollection(), new RequestParameterCollection());
        
        $chain = new GetRoutingChain();
        $chain->addRouter(new TestGetRouter1());
        
        $proc = new RequestProcessor();
        $proc->addRoutingChain($chain);
        
        $response = $proc->run($request);
        $this->assertInstanceOf(XhtmlResponse::class, $response);
    }

    /**
     * @covers ::run
     *
     * @uses   \Lucille\RequestProcessor::addRoutingChain
     * @uses   \Lucille\Routing\ResultRoutingChain
     * @uses   \Lucille\Routing\PostRoutingChain
     * @uses   \Lucille\Request\PostRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Components\Xml\XhtmlContentResultRouter
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Components\Xml\XhtmlContent
     * @uses   \Lucille\Components\Xml\XhtmlResponse
     * @uses   \Lucille\Response\GenericResponse
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Routing\ResultRouter
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     */
    public function testRunPostRequest() {
        $request = new PostRequest(new Uri('/de/page1'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody());

        $chain = new PostRoutingChain();
        $chain->addRouter(new TestPostRouter1());

        $proc = new RequestProcessor();
        $proc->addRoutingChain($chain);

        $response = $proc->run($request);
        $this->assertInstanceOf(XhtmlResponse::class, $response);
    }
    
    /**
     * @covers ::run
     *
     * @uses   \Lucille\RequestProcessor::addRoutingChain
     * @uses   \Lucille\Routing\ResultRoutingChain
     * @uses   \Lucille\Routing\PutRoutingChain
     * @uses   \Lucille\Request\PutRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Components\Xml\XhtmlContentResultRouter
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Components\Xml\XhtmlContent
     * @uses   \Lucille\Components\Xml\XhtmlResponse
     * @uses   \Lucille\Response\GenericResponse
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Routing\ResultRouter
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     */
    public function testRunPutRequest() {
        $request = new PutRequest(new Uri('/de/page1'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody());
        
        $chain = new PutRoutingChain();
        $chain->addRouter(new TestPutRouter1());

        $proc = new RequestProcessor();
        $proc->addRoutingChain($chain);
        
        $response = $proc->run($request);
        $this->assertInstanceOf(XhtmlResponse::class, $response);
    }

    /**
     * @covers ::run
     *
     * @uses   \Lucille\RequestProcessor::addRoutingChain
     * @uses   \Lucille\Routing\ResultRoutingChain
     * @uses   \Lucille\Routing\PatchRoutingChain
     * @uses   \Lucille\Request\PatchRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Components\Xml\XhtmlContentResultRouter
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Components\Xml\XhtmlContent
     * @uses   \Lucille\Components\Xml\XhtmlResponse
     * @uses   \Lucille\Response\GenericResponse
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Routing\ResultRouter
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     */
    public function testRunPatchRequest() {
        $request = new PatchRequest(new Uri('/de/page1'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody());
        
        $chain = new PatchRoutingChain();
        $chain->addRouter(new TestPatchRouter1());

        $proc = new RequestProcessor();
        $proc->addRoutingChain($chain);

        $response = $proc->run($request);
        $this->assertInstanceOf(XhtmlResponse::class, $response);
    }

    /**
     * @covers ::run
     *
     * @uses   \Lucille\RequestProcessor::addRoutingChain
     * @uses   \Lucille\Routing\ResultRoutingChain
     * @uses   \Lucille\Routing\DeleteRoutingChain
     * @uses   \Lucille\Request\DeleteRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Components\Xml\XhtmlContentResultRouter
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Components\Xml\XhtmlContent
     * @uses   \Lucille\Components\Xml\XhtmlResponse
     * @uses   \Lucille\Response\GenericResponse
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Routing\ResultRouter
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     */
    public function testRunDeleteRequest() {
        $request = new DeleteRequest(new Uri('/de/page1'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody());
        
        $chain = new DeleteRoutingChain();
        $chain->addRouter(new TestDeleteRouter());
        
        $proc = new RequestProcessor();
        $proc->addRoutingChain($chain);
        
        $response = $proc->run($request);
        $this->assertInstanceOf(XhtmlResponse::class, $response);
    }

    /**
     * @covers ::run
     *
     * @uses   \Lucille\RequestProcessor::addRoutingChain
     * @uses   \Lucille\Routing\ResultRoutingChain
     * @uses   \Lucille\Routing\GetRoutingChain
     * @uses   \Lucille\Request\GetRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Components\Xml\XhtmlContentResultRouter
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Components\Xml\XhtmlContent
     * @uses   \Lucille\Components\Xml\XhtmlResponse
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Routing\ResultRouter
     * @uses   \Lucille\Response\LucilleErrorResponse
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testProcessRequestWithoutRoutingChainDefined() {
        $request = new GetRequest(new Uri('/de/page1'), new HeaderCollection(), new RequestParameterCollection());
        $proc = new RequestProcessor();
        $response = $proc->run($request);
        
        $this->assertInstanceOf(LucilleErrorResponse::class, $response);
    }

    /**
     * @covers ::run
     *
     * @uses   \Lucille\RequestProcessor::addRoutingChain
     * @uses   \Lucille\Routing\ResultRoutingChain
     * @uses   \Lucille\Routing\GetRoutingChain
     * @uses   \Lucille\Request\GetRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Routing\ResultRouter
     * @uses   \Lucille\Response\LucilleErrorResponse
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testProcessRequestRouterThrowsCustomException() {
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(3);
        $this->expectExceptionMessage('custom ex');
        
        $request = new GetRequest(new Uri('/de/page1'), new HeaderCollection(), new RequestParameterCollection());
        
        $chain = new GetRoutingChain();
        $chain->addRouter(new CustomExceptionThrowerRouter());
        
        $proc = new RequestProcessor();
        $proc->addRoutingChain($chain);
        
        $proc->run($request);
    }
    
    
    
    
    private function getPrivateClassProperty($class, string $property) {
        $rfl = new \ReflectionClass($class);
        $prop = $rfl->getProperty($property);
        $prop->setAccessible(true);
        return $prop->getValue($class);
    }
    
}
