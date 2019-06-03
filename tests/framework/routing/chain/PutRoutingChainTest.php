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
use Lucille\Request\PutRequest;
use Lucille\Request\Uri;
use Lucille\Result\Result;
use Lucille\Routing\PutRouter;

use Lucille\Routing\PutRoutingChain;
use PHPUnit\Framework\TestCase;
    

class PutRoutingChainTestCommand implements Command {
    public function execute(): Result {
    }
}

class PutRoutingChainTestRouter extends PutRouter {
    public function route(PutRequest $request): Command {
        return $this->getNext()->route($request);
    }
}

class PutRoutingChainTestReturnsCommandRouter extends PutRouter {
    public function route(PutRequest $request): Command {
        return new PutRoutingChainTestCommand();
    }
}


/**
 * @coversDefaultClass \Lucille\Routing\PutRoutingChain
 */
class PutRoutingChainTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\PutRoutingChain::addRouter
     * @covers \Lucille\Routing\PutRoutingChain::route
     * @uses   \Lucille\Request\PutRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingOneRouterObjectReturnsCommand() {
        $commandRouter = new PutRoutingChainTestReturnsCommandRouter();
        
        $chain = new PutRoutingChain();
        $chain->addRouter($commandRouter);
        
        $res = $chain->route(new PutRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
        $this->assertInstanceOf(Command::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\PutRoutingChain::addRouter
     * @covers \Lucille\Routing\PutRoutingChain::route
     * @uses   \Lucille\Routing\PutRouter::setNext
     * @uses   \Lucille\Routing\PutRouter::getNext
     * @uses   \Lucille\Request\PutRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingMultipleRouterObjectsReturnsCommand() {
        $nextRouter    = new PutRoutingChainTestRouter();
        $commandRouter = new PutRoutingChainTestReturnsCommandRouter();
        
        $chain = new PutRoutingChain();
        $chain->addRouter($nextRouter);
        $chain->addRouter($commandRouter);
        
        $res = $chain->route(new PutRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
        $this->assertInstanceOf(Command::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\PutRoutingChain::addRouter
     * @covers \Lucille\Routing\PutRoutingChain::route
     * @uses   \Lucille\Routing\PutRouter::setNext
     * @uses   \Lucille\Routing\PutRouter::getNext
     * @uses   \Lucille\Request\PutRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testRoutingChainHasNoRoutersThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $chain = new PutRoutingChain();
        $chain->route(new PutRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
    }
    
}
