<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Response\Response;

class ResultRoutingChainTestResponse implements Response {
    public function send(): void {
        die('dump');
    }
}
