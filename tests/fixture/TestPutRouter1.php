<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Command;
use Lucille\Request\PutRequest;
use Lucille\Routing\PutRouter;

class TestPutRouter1 extends PutRouter {
    public function route(PutRequest $request): Command {
        return new TestCommand1();
    }
}
