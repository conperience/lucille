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
use Lucille\Components\Xml\XhtmlContent;
use Lucille\Query;
use Lucille\Request\DeleteRequest;
use Lucille\Request\GetRequest;
use Lucille\Request\PatchRequest;
use Lucille\Request\PostRequest;
use Lucille\Request\PutRequest;
use Lucille\Result\Result;
use Lucille\Routing\DeleteRouter;
use Lucille\Routing\GetRouter;
use Lucille\Routing\PatchRouter;
use Lucille\Routing\PostRouter;
use Lucille\Routing\PutRouter;
use Lucille\Routing\RoutingChain;
    
#
# Invalid routing chain
#
class InvalidRoutingChain implements RoutingChain {
}


#
# COMMAND / QUERY
#
class TestQuery1 implements Query {
    public function execute(): Result {
        return new XhtmlContent();
    }
}

class TestCommand1 implements Command {
    public function execute(): Result {
        return new XhtmlContent();
    }
}


#
# ROUTER
#
class TestGetRouter1 extends GetRouter {
    public function route(GetRequest $request): Query {
        return new TestQuery1();
    }
}

class TestPostRouter1 extends PostRouter {
    public function route(PostRequest $request): Command {
        return new TestCommand1();
    }
}

class TestPutRouter1 extends PutRouter {
    public function route(PutRequest $request): Command {
        return new TestCommand1();
    }
}

class TestPatchRouter1 extends PatchRouter {
    public function route(PatchRequest $request): Command {
        return new TestCommand1();
    }
}
    
class TestDeleteRouter extends DeleteRouter {
    public function route(DeleteRequest $request): Command {
        return new TestCommand1();
    }
}

class CustomExceptionThrowerRouter extends GetRouter {
    public function route(GetRequest $request): Query {
        throw new \Exception("custom ex", 3);
    }
}
