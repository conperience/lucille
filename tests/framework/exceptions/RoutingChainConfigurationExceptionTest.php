<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;

use Lucille\Exceptions\RoutingChainConfigurationException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Exceptions\RoutingChainConfigurationException
 */
class RoutingChainConfigurationExceptionTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses  \Lucille\Exceptions\LucilleException
     *                                            
     * @expectedException \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testNoRouterConfigurationException() {
        throw new RoutingChainConfigurationException('No routing target found');
    }
    
}
