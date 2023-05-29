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
use Lucille\Request\GetRequest;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\Parameter\StringRequestParameter;
use Lucille\Request\Parameter\StringRequestParameterName;
use Lucille\Request\Uri;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Request\GetRequest
 */
class GetRequestTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     */
    public function testGetRequest() {
        $uri = new Uri('/demo');
        
        $headerCollection = new HeaderCollection();
        $headerCollection->addHeader(
            new Header('h1', 'v1')
        );
        
        $parameterCollection = new RequestParameterCollection();
        $parameterCollection->addParam(
            new StringRequestParameter(
                new StringRequestParameterName('param1'),
                'value1'
            )
        );
        
        $request = new GetRequest($uri, $headerCollection, $parameterCollection);
        
        $this->assertSame('/demo', $request->getUri()->asString());
        $this->assertSame('h1: v1', $request->getHeaderCollection()->getHeader('h1')->asString());
        $this->assertSame('value1', $request->getParameterCollection()->getParam('param1')->asString());
    }
    
}
