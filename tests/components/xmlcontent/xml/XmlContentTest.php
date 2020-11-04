<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Xml\XmlContent;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Components\Xml\XmlContent
 */
class XmlContentTest extends TestCase {
    
    /**
     * @covers ::append
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testAppend() {
        $xml1 = new XmlContent();
        $xml1->loadDocument($this->createDom('<root><n1 id="n1"/></root>'));
        
        $xml2 = new XmlContent();
        $xml2->loadDocument($this->createDom('<root><demo><foo label="test"/></demo></root>'));
        
        $xml1->append('n1', $xml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.XmlContent.append.result.xml', $xml1->getContentDom()->saveXML());
    }
    
    /**
     * @covers ::insertBefore
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testInsertBefore() {
        $xml1 = new XmlContent();
        $xml1->loadDocument($this->createDom('<root><n1 id="n1"/></root>'));
        
        $xml2 = new XmlContent();
        $xml2->loadDocument($this->createDom('<root><demo><foo label="test"/></demo></root>'));
        
        $xml1->insertBefore('n1', $xml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.XmlContent.insertbefore.result.xml', $xml1->getContentDom()->saveXML());
    }
    
    /**
     * @covers ::replace
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testReplace() {
        $xml1 = new XmlContent();
        $xml1->loadDocument($this->createDom('<root><n1 id="n1"/></root>'));
        
        $xml2 = new XmlContent();
        $xml2->loadDocument($this->createDom('<root><demo><foo label="test"/></demo></root>'));
        
        $xml1->replace('n1', $xml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.XmlContent.replace.result.xml', $xml1->getContentDom()->saveXML());
    }
    
    private function createDom(string $xml): \DOMDocument {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="utf-8"?>'.$xml);
        return $dom;
    }
    
}
