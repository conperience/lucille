<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Command;
use Lucille\Request\PutRequest;
use Lucille\Routing\PutRouter;

class PutRoutingChainTestRouter extends PutRouter {
    public function route(PutRequest $request): Command {
        return $this->getNext()->route($request);
    }
}
