<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Command;
use Lucille\Request\DeleteRequest;
use Lucille\Routing\DeleteRouter;

class DeleteRoutingChainTestRouter extends DeleteRouter {
    public function route(DeleteRequest $request): Command {
        return $this->getNext()->route($request);
    }
}
