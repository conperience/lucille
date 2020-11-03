<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Command;
use Lucille\Request\PutRequest;
use Lucille\Routing\PutRouter;

class PutRoutingChainTestReturnsCommandRouter extends PutRouter {
    public function route(PutRequest $request): Command {
        return new PutRoutingChainTestCommand();
    }
}
