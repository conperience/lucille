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
use Lucille\Response\Response;
use Lucille\Routing\ResultRouter;
use Lucille\Routing\ResultRoutingChain;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Routing\ResultRoutingChain
 */
class ResultRoutingChainTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\ResultRoutingChain::addRouter
     * @covers \Lucille\Routing\ResultRoutingChain::route
     */
    public function testAddingOneRouterReturnsResponse() {
        $chain = new ResultRoutingChain();
        $chain->addRouter(new ResultRoutingChainTestReturnsResponseRouter());
        
        $res = $chain->route(new TestResult());
        $this->assertInstanceOf(Response::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\ResultRoutingChain::addRouter
     * @covers \Lucille\Routing\ResultRoutingChain::route
     * @uses   \Lucille\Routing\ResultRouter::setNext
     * @uses   \Lucille\Routing\ResultRouter::getNext
     */
    public function testAddRouter_MultipleRouterReturnsResponse() {
        $chain = new ResultRoutingChain();
        $chain->addRouter(new ResultRoutingChainTestRouter());
        $chain->addRouter(new ResultRoutingChainTestReturnsResponseRouter());
        
        $res = $chain->route(new TestResult());
        $this->assertInstanceOf(Response::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\ResultRoutingChain::addRouter
     * @covers \Lucille\Routing\ResultRoutingChain::route
     * @uses   \Lucille\Routing\ResultRouter::setNext
     * @uses   \Lucille\Routing\ResultRouter::getNext
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testAddRouter_ChainHasNoRouters() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $chain = new ResultRoutingChain();
        $res = $chain->route(new TestResult());
        $this->assertInstanceOf(Response::class, $res);
    }
    
}
