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
use Lucille\Query;
use Lucille\Request\GetRequest;
use Lucille\Routing\GetRouter;
use PHPUnit\Framework\TestCase;
    
class GetTestRouter extends GetRouter {
    public function route(GetRequest $request): Query {
        return $this->getNext()->route($request);
    }
}

/**
 * @coversDefaultClass \Lucille\Routing\GetRouter
 */
class GetRouterTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\GetRouter::setNext()
     * @covers \Lucille\Routing\GetRouter::getNext()
     */
    public function testSetNext() {
        $router = new GetTestRouter();
        $router->setNext(new GetTestRouter());
        
        $this->assertInstanceOf(GetTestRouter::class, $router->getNext());
    }
    
    /**
     * @covers \Lucille\Routing\GetRouter::getNext()
     * @uses   \Lucille\Routing\GetRouter::setNext()
     *
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testGetNextThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $router = new GetTestRouter();
        $router->getNext();
    }
        
}
