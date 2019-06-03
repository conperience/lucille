<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Request\Parameter\StringRequestParameter;
use Lucille\Request\Parameter\NumericRequestParameterName;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Request\Parameter\NumericRequestParameterName
 */
class NumericRequestParameterNameTest extends TestCase {

    /**
     * @covers ::__construct
     * @covers ::asInt
     * @uses   \Lucille\Request\Parameter\NumericRequestParameterName::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::__construct
     * @uses   \Lucille\Request\Parameter\StringRequestParameter::getName
     */
    public function testReturnsNameAsInt() {
        $param = new StringRequestParameter(new NumericRequestParameterName(1001), '1000');
        $this->assertIsInt($param->getName()->asInt());
    }
    
}
    
