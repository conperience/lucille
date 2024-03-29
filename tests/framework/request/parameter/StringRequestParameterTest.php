<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\Parameter\StringRequestParameter;
use Lucille\Request\Parameter\StringRequestParameterName;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\Parameter\StringRequestParameter
 */
class StringRequestParameterTest extends TestCase {

    /**
     * @covers ::__construct
     * @covers ::getName
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::asString
     */
    public function testReturnsInitialParameterName() {
        $param = new StringRequestParameter(new StringRequestParameterName('param1'), 'bar');
        $this->assertSame('param1', $param->getName()->asString());
    }
    
    /**
     * @covers ::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testReturnsInitialValueAsString() {
        $param = new StringRequestParameter(new StringRequestParameterName('test'), '1000');
        $this->assertSame('1000', $param->asString());
        $this->assertIsString($param->asString());
    }

    /**
     * @covers ::asInt
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testReturnsInitialValueAsInt() {
        $param = new StringRequestParameter(new StringRequestParameterName('test'), '1000');
        $this->assertSame(1000, $param->asInt());
        $this->assertIsInt($param->asInt());
    }

    /**
     * @covers ::asFloat
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     */
    public function testReturnsInitialValueAsFloat() {
        $param = new StringRequestParameter(new StringRequestParameterName('test'), '12.7');
        $this->assertSame(12.7, $param->asFloat());
        $this->assertIsFloat($param->asFloat());
    }
        
}
