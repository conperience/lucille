<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Xml\XhtmlContent;
use Lucille\Query;
use Lucille\Result\Result;

class TestQuery1 implements Query {
    public function execute(): Result {
        return new XhtmlContent();
    }
}
