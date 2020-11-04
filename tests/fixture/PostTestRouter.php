<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Command;
use Lucille\Request\PostRequest;
use Lucille\Routing\PostRouter;
use PHPUnit\Framework\TestCase;

class PostTestRouter extends PostRouter {
    public function route(PostRequest $request): Command {
        return $this->getNext()->route($request);
    }
}
