<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Command;
use Lucille\Components\Xml\XhtmlContent;
use Lucille\Result\Result;

class TestCommand1 implements Command {
    public function execute(): Result {
        return new XhtmlContent();
    }
}
