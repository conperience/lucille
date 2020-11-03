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
use Lucille\Header\HeaderCollection;
use Lucille\Query;
use Lucille\Request\GetRequest;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\Uri;
use Lucille\Routing\GetRouter;
use Lucille\Routing\GetRoutingChain;

use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Routing\GetRoutingChain
 */
class GetRoutingChainTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\GetRoutingChain::addRouter
     * @covers \Lucille\Routing\GetRoutingChain::route
     * @uses   \Lucille\Request\GetRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingOneRouterObjectReturnsQuery() {
        $queryRouter = new GetRoutingChainTestReturnsQueryRouter();
        
        $chain = new GetRoutingChain();
        $chain->addRouter($queryRouter);
        
        $res = $chain->route(new GetRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection()));
        $this->assertInstanceOf(Query::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\GetRoutingChain::addRouter
     * @covers \Lucille\Routing\GetRoutingChain::route
     * @uses   \Lucille\Routing\GetRouter::setNext
     * @uses   \Lucille\Routing\GetRouter::getNext
     * @uses   \Lucille\Request\GetRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingMultipleRouterObjectsReturnsQuery() {
        $nextRouter  = new GetRoutingChainTestRouter();
        $queryRouter = new GetRoutingChainTestReturnsQueryRouter();
        
        $chain = new GetRoutingChain();
        $chain->addRouter($nextRouter);
        $chain->addRouter($queryRouter);
        
        $res = $chain->route(new GetRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection()));
        $this->assertInstanceOf(Query::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\GetRoutingChain::addRouter
     * @covers \Lucille\Routing\GetRoutingChain::route
     * @uses   \Lucille\Routing\GetRouter::setNext
     * @uses   \Lucille\Routing\GetRouter::getNext
     * @uses   \Lucille\Request\GetRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testRoutingChainHasNoRoutersThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $chain = new GetRoutingChain();
        $chain->route(new GetRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection()));
    }
    
}
