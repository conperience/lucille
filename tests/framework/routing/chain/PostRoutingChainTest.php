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
use Lucille\Request\PostRequest;
use Lucille\Request\Parameter\RequestParameterCollection;
use Lucille\Request\Uri;
use Lucille\Result\Result;
use Lucille\Routing\PostRouter;
use Lucille\Routing\PostRoutingChain;

use PHPUnit\Framework\TestCase;
    

class PostRoutingChainTestCommand implements Command {
    public function execute(): Result {
    }
}

class PostRoutingChainTestRouter extends PostRouter {
    public function route(PostRequest $request): Command {
        return $this->getNext()->route($request);
    }
}

class PostRoutingChainTestReturnsCommandRouter extends PostRouter {
    public function route(PostRequest $request): Command {
        return new PostRoutingChainTestCommand();
    }
}


/**
 * @coversDefaultClass \Lucille\Routing\PostRoutingChain
 */
class PostRoutingChainTest extends TestCase {
    
    /**
     * @covers \Lucille\Routing\PostRoutingChain::addRouter
     * @covers \Lucille\Routing\PostRoutingChain::route
     * @uses   \Lucille\Request\PostRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingOneRouterObjectReturnsCommand() {
        $commandRouter = new PostRoutingChainTestReturnsCommandRouter();
        
        $chain = new PostRoutingChain();
        $chain->addRouter($commandRouter);
        
        $res = $chain->route(new PostRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
        $this->assertInstanceOf(Command::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\PostRoutingChain::addRouter
     * @covers \Lucille\Routing\PostRoutingChain::route
     * @uses   \Lucille\Routing\PostRouter::setNext
     * @uses   \Lucille\Routing\PostRouter::getNext
     * @uses   \Lucille\Request\PostRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     */
    public function testAddingMultipleRouterObjectsReturnsCommand() {
        $nextRouter    = new PostRoutingChainTestRouter();
        $commandRouter = new PostRoutingChainTestReturnsCommandRouter();
        
        $chain = new PostRoutingChain();
        $chain->addRouter($nextRouter);
        $chain->addRouter($commandRouter);
        
        $res = $chain->route(new PostRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
        $this->assertInstanceOf(Command::class, $res);
    }
    
    /**
     * @covers \Lucille\Routing\PostRoutingChain::addRouter
     * @covers \Lucille\Routing\PostRoutingChain::route
     * @uses   \Lucille\Routing\PostRouter::setNext
     * @uses   \Lucille\Routing\PostRouter::getNext
     * @uses   \Lucille\Request\PostRequest
     * @uses   \Lucille\Request\Request
     * @uses   \Lucille\Request\Uri
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testRoutingChainHasNoRoutersThrowsRoutingChainConfigurationException() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $chain = new PostRoutingChain();
        $chain->route(new PostRequest(new Uri('/'), new HeaderCollection(), new RequestParameterCollection(), new EmptyRequestBody()));
    }
    
}
