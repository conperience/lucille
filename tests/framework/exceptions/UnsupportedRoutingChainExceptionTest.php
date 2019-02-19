<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Exceptions\UnsupportedRoutingChainException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Exceptions\UnsupportedRoutingChainException
 */
class UnsupportedRoutingChainExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Exceptions\LucilleException
     *                                            
     * @expectedException \Lucille\Exceptions\UnsupportedRoutingChainException
     */
    public function testNoRouterConfigurationException() {
        throw new UnsupportedRoutingChainException('No routing target found');
    }
    
}
