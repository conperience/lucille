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
use Lucille\Header\HeaderCollection;
use Lucille\Request\Body\EmptyRequestBody;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\PatchRequest;
use Lucille\Request\Uri;
use Lucille\Routing\PatchRouter;

use Lucille\Routing\PatchRoutingChain;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Routing\PatchRoutingChain
 */
class PatchRoutingChainTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\PatchRoutingChain::addRouter
     * @covers \Lucille\Routing\PatchRoutingChain::route
     * @uses   \Lucille\Request\PatchRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingOneRouterObjectReturnsCommand() {
        $commandRouter = new PatchRoutingChainTestReturnsCommandRouter();
        
        $chain = new PatchRoutingChain();
        $chain->addRouter($commandRouter);
        
        $res = $chain->route(new PatchRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
        $this->assertInstanceOf(Command::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\PatchRoutingChain::addRouter
     * @covers \Lucille\Routing\PatchRoutingChain::route
     * @uses   \Lucille\Routing\PatchRouter::setNext
     * @uses   \Lucille\Routing\PatchRouter::getNext
     * @uses   \Lucille\Request\PatchRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingMultipleRouterObjectsReturnsCommand() {
        $nextRouter    = new PatchRoutingChainTestRouter();
        $commandRouter = new PatchRoutingChainTestReturnsCommandRouter();
        
        $chain = new PatchRoutingChain();
        $chain->addRouter($nextRouter);
        $chain->addRouter($commandRouter);
        
        $res = $chain->route(new PatchRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
        $this->assertInstanceOf(Command::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\PatchRoutingChain::addRouter
     * @covers \Lucille\Routing\PatchRoutingChain::route
     * @uses   \Lucille\Routing\PatchRouter::setNext
     * @uses   \Lucille\Routing\PatchRouter::getNext
     * @uses   \Lucille\Request\PatchRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testRoutingChainHasNoRoutersThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $chain = new PatchRoutingChain();
        $chain->route(new PatchRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
    }
    
}
