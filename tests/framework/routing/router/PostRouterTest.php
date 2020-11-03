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
use Lucille\Routing\PostRouter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Routing\PostRouter
 */
class PostRouterTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\PostRouter::setNext()
     * @covers \Lucille\Routing\PostRouter::getNext()
     */
    public function testSetNext() {
        $router = new PostTestRouter();
        $router->setNext(new PostTestRouter());
        
        $this->assertInstanceOf(PostTestRouter::class, $router->getNext());
    }
    
    /**
     * @covers \Lucille\Routing\PostRouter::getNext()
     * @uses   \Lucille\Routing\PostRouter::setNext()
     *
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testGetNextThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $router = new PostTestRouter();
        $router->getNext();
    }
        
}
