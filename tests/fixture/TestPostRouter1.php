<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Command;
use Lucille\Request\PostRequest;
use Lucille\Routing\PostRouter;

class TestPostRouter1 extends PostRouter {
    public function route(PostRequest $request): Command {
        return new TestCommand1();
    }
}
