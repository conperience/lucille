<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */
    
namespace Lucille\UnitTests;

use Lucille\Response\Response;
use Lucille\Result\Result;
use Lucille\Routing\ResultRouter;
use PHPUnit\Framework\TestCase;
    
class ResultTestRouter extends ResultRouter {
    public function route(Result $request): Response {
        return $this->getNext()->route($request);
    }
}

/**
 * @coversDefaultClass \Lucille\Routing\ResultRouter
 */
class ResultRouterTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\ResultRouter::setNext()
     * @covers \Lucille\Routing\ResultRouter::getNext()
     */
    public function testSetNext() {
        $router = new ResultTestRouter();
        $router->setNext(new ResultTestRouter());
        
        $this->assertInstanceOf(ResultTestRouter::class, $router->getNext());
    }
    
    /**
     * @covers \Lucille\Routing\ResultRouter::getNext()
     * @uses   \Lucille\Routing\ResultRouter::setNext()
     *
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     * 
     * @expectedException \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testGetNextThrowsRoutingChainConfigurationException() {
        $router = new ResultTestRouter();
        $router->getNext();
    }
        
}
    
