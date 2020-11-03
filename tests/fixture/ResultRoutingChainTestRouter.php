<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Response\Response;
use Lucille\Result\Result;
use Lucille\Routing\ResultRouter;

class ResultRoutingChainTestRouter extends ResultRouter {
    public function route(Result $result): Response {
        return $this->getNext()->route($result);
    }
}
