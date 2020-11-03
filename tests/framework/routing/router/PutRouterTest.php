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
use Lucille\Request\PutRequest;
use Lucille\Routing\PutRouter;
use PHPUnit\Framework\TestCase;
    
class PutTestRouter extends PutRouter {
    public function route(PutRequest $request): Command {
        return $this->getNext()->route($request);
    }
}

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
