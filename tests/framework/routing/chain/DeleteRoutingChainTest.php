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
use Lucille\Request\DeleteRequest;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\Uri;
use Lucille\Result\Result;
use Lucille\Routing\DeleteRouter;
use Lucille\Routing\DeleteRoutingChain;

use PHPUnit\Framework\TestCase;
    

class DeleteRoutingChainTestCommand implements Command {
    public function execute(): Result {
    }
}

class DeleteRoutingChainTestRouter extends DeleteRouter {
    public function route(DeleteRequest $request): Command {
        return $this->getNext()->route($request);
    }
}

class DeleteRoutingChainTestReturnsCommandRouter extends DeleteRouter {
    public function route(DeleteRequest $request): Command {
        return new DeleteRoutingChainTestCommand();
    }
}


/**
 * @coversDefaultClass \Lucille\Routing\DeleteRoutingChain
 */
class DeleteRoutingChainTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\DeleteRoutingChain::addRouter
     * @covers \Lucille\Routing\DeleteRoutingChain::route
     * @uses   \Lucille\Request\DeleteRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingOneRouterObjectReturnsCommand() {
        $commandRouter = new DeleteRoutingChainTestReturnsCommandRouter();
        
        $chain = new DeleteRoutingChain();
        $chain->addRouter($commandRouter);
        
        $res = $chain->route(new DeleteRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
        $this->assertInstanceOf(Command::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\DeleteRoutingChain::addRouter
     * @covers \Lucille\Routing\DeleteRoutingChain::route
     * @uses   \Lucille\Routing\DeleteRouter::setNext
     * @uses   \Lucille\Routing\DeleteRouter::getNext
     * @uses   \Lucille\Request\DeleteRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingMultipleRouterObjectsReturnsCommand() {
        $nextRouter    = new DeleteRoutingChainTestRouter();
        $commandRouter = new DeleteRoutingChainTestReturnsCommandRouter();
        
        $chain = new DeleteRoutingChain();
        $chain->addRouter($nextRouter);
        $chain->addRouter($commandRouter);
        
        $res = $chain->route(new DeleteRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
        $this->assertInstanceOf(Command::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\DeleteRoutingChain::addRouter
     * @covers \Lucille\Routing\DeleteRoutingChain::route
     * @uses   \Lucille\Routing\DeleteRouter::setNext
     * @uses   \Lucille\Routing\DeleteRouter::getNext
     * @uses   \Lucille\Request\DeleteRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testRoutingChainHasNoRoutersThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $chain = new DeleteRoutingChain();
        $chain->route(new DeleteRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
    }
    
}
