<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Xml\GenericXmlContent;
use Lucille\Components\Xml\XmlContentInterface;

class TestXmlContent extends GenericXmlContent implements XmlContentInterface {
    public function append(string $id, GenericXmlContent $content): void {
    }
    public function insertBefore(string $id, GenericXmlContent $content): void {
    }
    public function replace(string $id, GenericXmlContent $content): void {
    }
}
