<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\Parameter\NumericRequestParameterName;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\Parameter\StringRequestParameter;
use Lucille\Request\Parameter\StringRequestParameterName;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\Parameter\RequestParameterCollection
 */
class RequestParameterCollectionTest extends TestCase {

    /**
     * @covers ::addParam
     * @covers ::count
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testIsCountable() {
        $collection = $this->buildTestCollectionWithParams();
        $this->assertCount(2, $collection);
    }
    
    /**
     * @covers ::hasParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::count
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testCollectionHasParamReturnsTrueIfFound() {
        $collection = $this->buildTestCollectionWithParams();
        $this->assertTrue($collection->hasParam('foo'));
    }
    
    /**
     * @covers ::hasParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::count
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testCollectionHasParamReturnsFalseIfNotFound() {
        $collection = $this->buildTestCollectionWithParams();
        $this->assertFalse($collection->hasParam('doesnotexist'));
    }
    
    /**
     * @covers ::hasParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::count
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testCollectionWithoutParamsHasParamReturnsFalse() {
        $collection = $this->buildTestCollectionWithParams(false);
        $this->assertFalse($collection->hasParam('foo'));
    }

    /**
     * @covers ::getParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::count
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Exceptions\RequestParameterNotFoundException::__construct
     *                                                                        
     * @expectedException \Lucille\Exceptions\RequestParameterNotFoundException
     */
    public function testCollectionGetParamThrowsException() {
        $collection = $this->buildTestCollectionWithParams(false);
        $collection->getParam('foo');
    }

    /**
     * @covers ::getParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::count
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testCollectionGetParamReturnsRequestParameter() {
        $collection = $this->buildTestCollectionWithParams();
        $param = $collection->getParam('foo');
        $this->assertInstanceOf(StringRequestParameter::class, $param);
    }

    /**
     * @covers ::getIterator
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::count
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testCollectionGetIterator() {
        $collection = $this->buildTestCollectionWithParams();
        $list = $collection->getIterator();
        $this->assertInstanceOf(\ArrayIterator::class, $list);
    }

    /**
     * @covers ::fromArray
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::count
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testFromArrayWithoutElementsReturnsRequestParameterCollectionWithoutParameters() {
        $collection = RequestParameterCollection::fromArray(array());
        $this->assertCount(0, $collection);
    }
    
    /**
     * @covers ::fromArray
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParam
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testFromArrayReturnsRequestParameterCollectionWithParameters() {
        $source = array(
            'foo'   => 'bar',
            'bar'   => 'baz',
            'limit' => 100
        );
        $collection = RequestParameterCollection::fromArray($source);
        
        $this->assertInstanceOf(StringRequestParameter::class, $collection->getParam('foo'));
        $this->assertInstanceOf(StringRequestParameter::class, $collection->getParam('bar'));
        $this->assertInstanceOf(StringRequestParameter::class, $collection->getParam('limit'));
    }
    
    /**
     * @covers ::fromArray
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParam
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\NumericRequestParameterName::__construct
     * @uses   \Lucille\Request\Parameter\NumericRequestParameterName::asInt
     */
    public function testFromArrayReturnsRequestParameterCollectionWithNumericParameterNames() {
        $source = array(
            0 => 'foo'
        );
        $collection = RequestParameterCollection::fromArray($source);
        
        $this->assertInstanceOf(NumericRequestParameterName::class, $collection->getParam(0)->getName());
    }

    /**
     * @covers ::fromArray
     * @covers ::getParameterCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParam
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::asString
     * @uses   \Lucille\Request\Parameter\NumericRequestParameterName::__construct
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParameterCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::count
     */
    public function testFromArrayNestedArrayReturnsRequestParameterCollectionWithSubCollections() {
        $source = array(
            'list1' => array(
                'foo1.1' => 'bar1.1',
                'baz1.2' => 'bla1.2'
            ),
            'list2' => array(
                'foo2.1' => 'bar2.1',
                'baz2.2' => 'bla2.2',
                'baz3.2' => 'bla3.2'
            )
        );
        $collection = RequestParameterCollection::fromArray($source);
        
        // check for list1 sub collection
        $this->assertInstanceOf(RequestParameterCollection::class, $collection->getParameterCollection('list1'));
        $this->assertCount(2, $collection->getParameterCollection('list1'));
        
        $this->assertInstanceOf(RequestParameterCollection::class, $collection->getParameterCollection('list2'));
        $this->assertCount(3, $collection->getParameterCollection('list2'));
    }

    /**
     * @covers ::addParameterCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParameterCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::fromArray
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParam
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\NumericRequestParameterName::__construct
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParameterCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParameterCollection
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testAddParameterCollectionAddsCollectionByName() {
        $collection = RequestParameterCollection::fromArray(array());
        $collection->addParameterCollection(
            'test',
            RequestParameterCollection::fromArray(array())
        );
        
        $this->assertInstanceOf(RequestParameterCollection::class, $collection->getParameterCollection('test'));
    }
    
    /**
     * @covers ::getParameterCollection
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::addParam
     * @uses   \Lucille\Request\Parameter\RequestParameterCollection::getParam
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     * @uses   \Lucille\Request\Parameter\NumericRequestParameterName::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Exceptions\RequestParameterCollectionNotFoundException::__construct
     *                                                                         
     * @expectedException \Lucille\Exceptions\RequestParameterCollectionNotFoundException
     */
    public function testGetParameterCollectionThrowsException() {
        $collection = $this->buildTestCollectionWithParams(false);
        $collection->getParameterCollection('notexist');
    }
    
    
    
    private function buildTestCollectionWithParams(bool $withParams =true): RequestParameterCollection {
        $collection = new RequestParameterCollection();
        
        if ($withParams) {
            $collection->addParam(
                new StringRequestParameter(new StringRequestParameterName('foo'), 'bar')
            );
            $collection->addParam(
                new StringRequestParameter(new StringRequestParameterName('foo2'), 'bar2')
            );
        }
        
        return $collection;
    }
    
}
    
