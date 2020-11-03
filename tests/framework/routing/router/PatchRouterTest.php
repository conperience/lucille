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
use Lucille\Routing\PatchRouter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Routing\PatchRouter
 */
class PatchRouterTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\PatchRouter::setNext()
     * @covers \Lucille\Routing\PatchRouter::getNext()
     */
    public function testSetNext() {
        $router = new PatchTestRouter();
        $router->setNext(new PatchTestRouter());
        
        $this->assertInstanceOf(PatchTestRouter::class, $router->getNext());
    }
    
    /**
     * @covers \Lucille\Routing\PatchRouter::getNext()
     * @uses   \Lucille\Routing\PatchRouter::setNext()
     *
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testGetNextThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $router = new PatchTestRouter();
        $router->getNext();
    }
        
}
