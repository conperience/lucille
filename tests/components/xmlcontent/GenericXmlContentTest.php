<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Xml\Exceptions\LoadingXmlFileFailedException;
use Lucille\Components\Xml\Exceptions\XmlMultipleNodesFoundException;
use Lucille\Components\Xml\Exceptions\XmlNodeNotFoundException;
use Lucille\Components\Xml\Exceptions\XmlTargetIdNotFoundException;
use Lucille\Components\Xml\Exceptions\XmlTargetIdNotUniqueException;
use Lucille\Components\Xml\GenericXmlContent;
use Lucille\Components\Xml\XmlContentInterface;
use Lucille\Components\Xml\XPathQuery;
use Lucille\Filename;

use PHPUnit\Framework\TestCase;


class TestXmlContent extends GenericXmlContent implements XmlContentInterface {
    public function append(string $id, GenericXmlContent $content): void {}
    public function insertBefore(string $id, GenericXmlContent $content): void {}
    public function replace(string $id, GenericXmlContent $content): void {}
}

/**
 * @coversDefaultClass \Lucille\Components\Xml\GenericXmlContent
 */
class GenericXmlContentTest extends TestCase {
    
    /**
     * @covers ::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     * @uses   \Lucille\Filename
     */
    public function testReturnsInitialDomDocument() {
        $doc = new TestXmlContent();
        $this->assertInstanceOf(\DOMDocument::class, $doc->getContentDom());
    }
    
    /**
     * @covers ::load
     * @covers ::__construct
     * @covers ::getContentDom
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Filename
     */
    public function testLoadedDomDocumentByFilename() {
        $xmlFile = new Filename(__DIR__.'/data/test.xml');
        $doc = new TestXmlContent($xmlFile);
        
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.xml', $doc->getContentDom()->saveXML());
    }
    
    /**
     * @covers ::loadDocument
     * @covers ::getContentDom
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Filename
     */
    public function testLoadDomDocument() {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0"?><root foo="bar"></root>');
        
        $doc = new TestXmlContent();
        $doc->loadDocument($dom);

        $this->assertEquals($dom, $doc->getContentDom());
    }
    
    /**
     * @covers ::load
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     * @uses   \Lucille\Filename
     * @uses   \Lucille\Components\Xml\Exceptions\LoadingXmlFileFailedException::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testLoadInvalidXmlFileThrowsException() {
        $this->expectException(LoadingXmlFileFailedException::class);
        
        set_error_handler(function ($errno, $errstr) {});
        $doc = new TestXmlContent(
            new Filename(__DIR__ . '/data/test.invalid.xml')
        );
    }
    
    /**
     * @covers ::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     */
    public function testLoadedDomDocument() {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="utf-8"?><root></root>');
        
        $doc = new TestXmlContent();
        $doc->loadDocument($dom);

        $this->assertEquals($dom, $doc->getContentDom());
    }
    
    /**
     * @covers ::findById
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     */
    public function testFindNodeByIdReturnsDomElement() {
        $doc = $this->getTestXmlContent();
        $node = $doc->findById('10');
        
        $this->assertInstanceOf(\DOMElement::class, $node);
    }
    
    /**
     * @covers ::findById
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     *                          
     * @uses   \Lucille\Components\Xml\Exceptions\XmlTargetIdNotFoundException::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testFindNodeByIdNotFoundThrowsException() {
        $this->expectException(XmlTargetIdNotFoundException::class);
        
        $doc = $this->getTestXmlContent();
        $doc->findById('doesnotexist');
    }
    
    /**
     * @covers ::findById
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     *
     * @uses   \Lucille\Components\Xml\Exceptions\XmlTargetIdNotUniqueException::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testFindNodeByIdMultipleNodesFoundThrowsException() {
        $this->expectException(XmlTargetIdNotUniqueException::class);
        
        $doc = $this->getTestXmlContent();
        $doc->findById('20');
    }
    
    /**
     * @covers ::query
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     * @uses   \Lucille\Components\Xml\XPathQuery
     */
    public function testXpathQueryReturnsQueryResultNodeList() {
        $doc = $this->getTestXmlContent();
        $nodeList = $doc->query(new XPathQuery("//*[@id='20']"));
        
        $this->assertInstanceOf(\DOMNodeList::class, $nodeList);
        $this->assertEquals(2, $nodeList->length);
    }
    
    /**
     * @covers ::queryOne
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     * @uses   \Lucille\Components\Xml\XPathQuery
     */
    public function testQueryOneXpathQueryReturnsDomElement() {
        $doc = $this->getTestXmlContent();
        $element = $doc->queryOne(new XPathQuery("//*[@id='10']"));
        
        $this->assertInstanceOf(\DOMElement::class, $element);
    }
    
    /**
     * @covers ::queryOne
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     * @uses   \Lucille\Components\Xml\XPathQuery
     *                                        
     * @uses   \Lucille\Components\Xml\Exceptions\XmlNodeNotFoundException::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testQueryOneXpathQueryNotFoundThrowsException() {
        $this->expectException(XmlNodeNotFoundException::class);
        
        $doc = $this->getTestXmlContent();
        $doc->queryOne(new XPathQuery("/does/not/exist"));
    }
    
    /**
     * @covers ::queryOne
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     * @uses   \Lucille\Components\Xml\XPathQuery
     *
     * @uses   \Lucille\Components\Xml\Exceptions\XmlMultipleNodesFoundException::__construct
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     */
    public function testQueryOneXpathQueryMultipleNodesFoundThrowsException() {
        $this->expectException(XmlMultipleNodesFoundException::class);
        
        $doc = $this->getTestXmlContent();
        $doc->queryOne(new XPathQuery("//doc"));
    }
    
    /**
     * @covers ::getContentXP
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     */
    public function testGetContentXpReturnsBindedDomXpath() {
        $doc = $this->getTestXmlContent();
        $xp = $doc->getContentXP();
        
        $this->assertInstanceOf(\DOMXPath::class, $xp);
        $this->assertEquals('demo', $xp->query("//doc[@id='10']/@label")->item(0)->nodeValue);
    }

    /**
     * @covers ::appendNode
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testAppendNodeAppendsDomElement() {
        $xml1 = $this->getTestXmlContent();
        
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="utf-8"?><foo></foo>');
        
        $xml1->appendNode('10', $dom->documentElement);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.XmlContent.appendnode.result.xml', $xml1->getContentDom()->saveXML());
    }
    
    /**
     * @covers ::replaceNode
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testReplaceNodeReplacesSpecifiedNodeWithDomElement() {
        $xml1 = $this->getTestXmlContent();
        
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="utf-8"?><foo></foo>');
        
        $xml1->replaceNode('10', $dom->documentElement);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.XmlContent.replacenode.result.xml', $xml1->getContentDom()->saveXML());
    }
    
    /**
     * @covers ::remove
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testRemoveNode() {
        $xml1 = $this->getTestXmlContent();
        $xml1->remove('10');
        
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.XmlContent.remove.result.xml', $xml1->getContentDom()->saveXML());
    }
    
    private function getTestXmlContent(): TestXmlContent {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="utf-8"?><root><doc id="10" label="demo"/><doc id="20"/><test id="20"/></root>');
        
        $doc = new TestXmlContent();
        $doc->loadDocument($dom);
        
        return $doc;
    }
    
}
    




























