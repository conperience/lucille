<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Exceptions\RequestParameterCollectionNotFoundException;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Exceptions\RequestParameterCollectionNotFoundException
 */
class RequestParameterCollectionNotFoundExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @covers ::getParameterCollectionName
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testGetParameterCollectionName() {
        try {
            throw new RequestParameterCollectionNotFoundException('list01');
        } catch (RequestParameterCollectionNotFoundException $e) {
            $this->assertEquals('list01', $e->getParameterCollectionName());
        }
    }
    
}
    
