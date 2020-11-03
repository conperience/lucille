<?php declare(strict_types=1);


namespace Lucille\UnitTests;

use Lucille\Response\Response;
use Lucille\Result\Result;
use Lucille\Routing\ResultRouter;

class ResultTestRouter extends ResultRouter {
    public function route(Result $request): Response {
        return $this->getNext()->route($request);
    }
}
