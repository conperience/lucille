<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Exceptions\RequestParameterNotFoundException;
use Lucille\Header\HeaderCollection;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\Parameter\StringRequestParameter;
use Lucille\Request\Request;
use Lucille\Request\Uri;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Request\Request
 */
class RequestTest extends TestCase {

    /**
     * @covers ::getUri
     * @covers ::__construct
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::fromArray
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     * @uses   \Lucille\Header\HeaderCollection::fromSource
     */
    public function testReturnsUri() {
        $request = $this->buildTestRequest();
        $this->assertInstanceOf(Uri::class, $request->getUri());
    }

    /**
     * @covers ::getParam
     * @covers ::__construct
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::fromArray
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParam
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     * @uses   \Lucille\Header\HeaderCollection::fromSource
     */
    public function testReturnsParamByName() {
        $request = $this->buildTestRequest();

        $this->assertInstanceOf(StringRequestParameter::class, $request->getParam('param1'));
        $this->assertInstanceOf(StringRequestParameter::class, $request->getParam('param2'));
        $this->assertInstanceOf(StringRequestParameter::class, $request->getParam('param3'));

        $this->assertSame('foo', $request->getParam('param1')->asString());
        $this->assertSame('123', $request->getParam('param2')->asString());
        $this->assertSame('baz', $request->getParam('param3')->asString());
    }

    /**
     * @covers ::getParam
     * @covers ::__construct
     *
     * @uses   \Lucille\Request\Uri::__construct
     *
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Exceptions\RequestParameterNotFoundException::__construct
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Header\HeaderCollection::fromSource
     */
    public function testParamByNameNotFoundThrowsException() {
        $this->expectException(RequestParameterNotFoundException::class);

        $request = $this->buildTestRequest();
        $request->getParam('doesnotexist');
    }

    /**
     * @covers ::getHeaderCollection
     * @uses   \Lucille\Request\Request::__construct
     *
     * @uses   \Lucille\Request\Uri::__construct
     *
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Exceptions\RequestParameterNotFoundException::__construct
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     * @uses   \Lucille\Header\HeaderCollection::fromSource
     * @uses   \Lucille\Header\HeaderCollection::addHeader
     * @uses   \Lucille\Header\Header
     */
    public function testReturnsRequestHeaderCollection() {
        $header = array(
            'HTTP_X_H1' => 'foo',
            'HTTP_X_H2' => 'bar'
        );

        $request = $this->buildTestRequest($header);
        $collection = $request->getHeaderCollection();
        $this->assertInstanceOf(HeaderCollection::class, $collection);
    }

    /**
     * @covers ::getParameterCollection
     * @uses   \Lucille\Request\Request::__construct
     *
     * @uses   \Lucille\Request\Uri::__construct
     *
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Exceptions\RequestParameterNotFoundException::__construct
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Header\Header
     */
    public function testReturnsRequestParameterCollection() {
        $request = $this->buildTestRequest();
        $collection = $request->getParameterCollection();

        $this->assertInstanceOf(RequestParameterCollection::class, $collection);
    }

    /**
     * @covers ::getParameterCollection
     * @uses   \Lucille\Request\Request::__construct
     *
     * @uses   \Lucille\Request\Uri::__construct
     *
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameter
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName
     * @uses   \Lucille\Request\Uri::__construct
     * @uses   \Lucille\Header\HeaderCollection
     * @uses   \Lucille\Header\Header
     */
    public function testReturnsRequestParameterCollectionByName() {
        $parameterSource = array(
            'param1' => 'foo',
            'param2' => 123,
            'list1' => array(
                'f1'   => 'a',
                'f2'   => 'b',
                'f3'   => 'c'
            )
        );

        $request = $this->buildTestRequest(array(), $parameterSource);
        $this->assertInstanceOf(RequestParameterCollection::class, $request->getParameterCollection('list1'));
    }


    private function buildTestRequest(array $headerSource = array(), array $parameterSource = null): TestRequest {
        $uri = new Uri('/document/demo/123');
        $headerCollection = HeaderCollection::fromSource($headerSource);

        if ($parameterSource !== null) {
            $parameterCollection = RequestParameterCollection::fromArray($parameterSource);
        } else {
            $parameterCollection = RequestParameterCollection::fromArray(
                array(
                    'param1' => 'foo',
                    'param2' => 123,
                    'param3' => 'baz'
                )
            );
        }

        return new TestRequest($uri, $headerCollection, $parameterCollection);
    }

}
