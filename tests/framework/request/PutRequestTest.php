<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Header\Header;
use Lucille\Header\HeaderCollection;
use Lucille\Request\Body\RawRequestBody;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\Parameter\StringRequestParameter;
use Lucille\Request\Parameter\StringRequestParameterName;
use Lucille\Request\PutRequest;
use Lucille\Request\Uri;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Request\PutRequest
 */
class PutRequestTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     * @uses   \Lucille\Request\Body\RawRequestBody
     */
    public function testPostRequest() {
        $request = $this->buildPutRequest();
        
        $this->assertEquals('/demo',   $request->getUri()->asString());
        $this->assertEquals('h1: v1',  $request->getHeaderCollection()->getHeader('h1')->asString());
        $this->assertEquals('value1',  $request->getParameterCollection()->getParam('param1')->asString());
    }
    
    /**
     * @covers ::getBody
     * @uses   \Lucille\Request\PutRequest::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     * @uses   \Lucille\Request\Body\RawRequestBody
     */
    public function testGetRawRequestBody() {
        $request = $this->buildPutRequest();
        
        $this->assertEquals('foo bar', $request->getBody()->asString());
    }
    
    private function buildPutRequest(): PutRequest {
        $uri = new Uri('/demo');
        
        $headerCollection = new HeaderCollection();
        $headerCollection->addHeader(
            new Header('h1', 'v1')
        );
        
        $parameterCollection = new RequestParameterCollection();
        $parameterCollection->addParam(
            new StringRequestParameter(
                new StringRequestParameterName('param1'), 'value1'
            )
        );
        
        $body = new RawRequestBody('foo bar');
        return new PutRequest($uri, $headerCollection, $parameterCollection, $body);
    }
    
}
