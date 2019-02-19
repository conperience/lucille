<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Exceptions\RequestParameterNotFoundException;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Exceptions\RequestParameterNotFoundException
 */
class RequestParameterNotFoundExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::getParameterName
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testGetParameterName() {
        try {
            throw new RequestParameterNotFoundException('param1');
        } catch (RequestParameterNotFoundException $e) {
            $this->assertEquals('param1', $e->getParameterName());
        }
    }
    
}
    
