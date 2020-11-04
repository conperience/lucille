<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Query;
use Lucille\Request\GetRequest;
use Lucille\Routing\GetRouter;

class TestGetRouter1 extends GetRouter {
    public function route(GetRequest $request): Query {
        return new TestQuery1();
    }
}
