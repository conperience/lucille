<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\Parameter\StringRequestParameter;
use Lucille\Request\Parameter\StringRequestParameterName;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\Parameter\StringRequestParameterName
 */
class StringRequestParameterNameTest extends TestCase {

    /**
     * @covers ::__construct
     * @covers ::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     */
    public function testGetValueReturnsInitialParameterNameTrimmed() {
        $param = new StringRequestParameter(new StringRequestParameterName('    paramname             '), 'bar');
        $this->assertEquals('paramname', $param->getName()->asString());
        $this->assertIsString($param->getName()->asString());
    }
    
    /**
     * @covers ::asString
     * @uses   \Lucille\Request\Parameter\StringRequestParameterName::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     */
    public function testReturnsNameAsString() {
        $param = new StringRequestParameter(new StringRequestParameterName('test'), '1000');
        $this->assertIsString($param->getName()->asString());
    }
    
}
    
