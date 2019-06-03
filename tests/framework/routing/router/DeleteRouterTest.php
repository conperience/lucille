<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */
    
namespace Lucille\UnitTests;

use Lucille\Command;
use Lucille\Exceptions\RoutingChainConfigurationException;
use Lucille\Request\DeleteRequest;
use Lucille\Routing\DeleteRouter;
use PHPUnit\Framework\TestCase;
    
class DeleteTestRouter extends DeleteRouter {
    public function route(DeleteRequest $request): Command {
        return $this->getNext()->route($request);
    }
}

/**
 * @coversDefaultClass \Lucille\Routing\DeleteRouter
 */
class DeleteRouterTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\DeleteRouter::setNext()
     * @covers \Lucille\Routing\DeleteRouter::getNext()
     */
    public function testSetNext() {
        $router = new DeleteTestRouter();
        $router->setNext(new DeleteTestRouter());
        
        $this->assertInstanceOf(DeleteTestRouter::class, $router->getNext());
    }
    
    /**
     * @covers \Lucille\Routing\DeleteRouter::getNext()
     * @uses   \Lucille\Routing\DeleteRouter::setNext()
     *
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testGetNextThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $router = new DeleteTestRouter();
        $router->getNext();
    }
        
}
    
