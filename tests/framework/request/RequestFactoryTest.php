<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;
    
use Lucille\Exceptions\UnsupportedRequestMethodException;
use Lucille\Request\DeleteRequest;
use Lucille\Request\GetRequest;
use Lucille\Request\PatchRequest;
use Lucille\Request\PostRequest;
use Lucille\Request\PutRequest;
use Lucille\Request\RequestFactory;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\RequestFactory
 */
class RequestFactoryTest extends TestCase {
    
    /**
     * @covers ::createRequest
     * @covers ::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\GetRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     */
    public function testCreateRequestReturnsGetRequest() {
        $request = $this->buildRequest('GET');
        $this->assertInstanceOf(GetRequest::class, $request);
    }

    /**
     * @covers ::createRequest
     * @covers ::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\PostRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Body\RequestBodyFactory
     */
    public function testCreateRequestReturnsPostRequest() {
        $request = $this->buildRequest('POST');
        $this->assertInstanceOf(PostRequest::class, $request);
    }

    /**
     * @covers ::createRequest
     * @covers ::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\PutRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Body\RequestBodyFactory
     */
    public function testCreateRequestReturnsPutRequest() {
        $request = $this->buildRequest('PUT');
        $this->assertInstanceOf(PutRequest::class, $request);
    }

    /**
     * @covers ::createRequest
     * @covers ::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\PatchRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Body\RequestBodyFactory
     */
    public function testCreateRequestReturnsPatchRequest() {
        $request = $this->buildRequest('PATCH');
        $this->assertInstanceOf(PatchRequest::class, $request);
    }

    /**
     * @covers ::createRequest
     * @covers ::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\DeleteRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Body\RequestBodyFactory
     */
    public function testCreateRequestReturnsDeleteRequest() {
        $request = $this->buildRequest('DELETE');
        $this->assertInstanceOf(DeleteRequest::class, $request);
    }

    /**
     * @covers ::createRequest
     * @covers ::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\DeleteRequest
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\UnsupportedRequestMethodException::__construct
     */
    public function testCreateRequestThrowsExceptionOnUnsupportedRequestMethod() {
        $this->expectException(UnsupportedRequestMethodException::class);
        
        $request = $this->buildRequest('INVALID');
    }
    
    private function buildRequest(string $requestMethod) {
        $server = array(
            'REQUEST_URI'    => '/test/100',
            'REQUEST_METHOD' => $requestMethod
        );
        return (new RequestFactory(array(), array(), $server, 'php://input'))->createRequest();
    }
    
}//class
