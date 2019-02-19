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
use Lucille\Header\HeaderCollection;
use Lucille\Request\Body\EmptyRequestBody;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\PatchRequest;
use Lucille\Request\Uri;
use Lucille\Result\Result;
use Lucille\Routing\PatchRouter;

use Lucille\Routing\PatchRoutingChain;
use PHPUnit\Framework\TestCase;
    

class PatchRoutingChainTestCommand implements Command {
    public function execute(): Result {
    }
}

class PatchRoutingChainTestRouter extends PatchRouter {
    public function route(PatchRequest $request): Command {
        return $this->getNext()->route($request);
    }
}

class PatchRoutingChainTestReturnsCommandRouter extends PatchRouter {
    public function route(PatchRequest $request): Command {
        return new PatchRoutingChainTestCommand();
    }
}


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
     * 
     * @expectedException \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testRoutingChainHasNoRoutersThrowsRoutingChainConfigurationException() {
        $chain = new PatchRoutingChain();
        $chain->route(new PatchRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
    }
    
}
