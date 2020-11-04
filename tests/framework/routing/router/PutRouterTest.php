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
use Lucille\Routing\PutRouter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Routing\PutRouter
 */
class PutRouterTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\PutRouter::setNext()
     * @covers \Lucille\Routing\PutRouter::getNext()
     */
    public function testSetNext() {
        $router = new PutTestRouter();
        $router->setNext(new PutTestRouter());
        
        $this->assertInstanceOf(PutTestRouter::class, $router->getNext());
    }
    
    /**
     * @covers \Lucille\Routing\PutRouter::getNext()
     * @uses   \Lucille\Routing\PutRouter::setNext()
     *
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testGetNextThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $router = new PutTestRouter();
        $router->getNext();
    }
        
}
