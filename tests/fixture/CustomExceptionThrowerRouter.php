<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Query;
use Lucille\Request\GetRequest;
use Lucille\Routing\GetRouter;

class CustomExceptionThrowerRouter extends GetRouter {
    public function route(GetRequest $request): Query {
        throw new \Exception("custom ex", 3);
    }
}
