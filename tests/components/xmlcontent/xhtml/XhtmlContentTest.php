<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Xml\XhtmlContent;
use Lucille\Filename;
use PHPUnit\Framework\TestCase;


/**
 * @coversDefaultClass \Lucille\Components\Xml\XhtmlContent
 */
class XhtmlContentTest extends TestCase {
    
    /**
     * @covers ::load
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testLoadWithHtmlNamespace() {
        $xhtml1 = new XhtmlContent(new Filename(__DIR__.'/data/test.xhtml'));
        
        $node = $xhtml1->getContentXP()->query('//html:p/text()')->item(0);
        $this->assertEquals('test', $node->nodeValue);
    }
    
    /**
     * @covers ::loadDocument
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testLoadDocumentWithHtmlNamespace() {
        $dom = new \DOMDocument();
        $dom->load(__DIR__.'/data/test.xhtml');
        
        $xhtml1 = new XhtmlContent();
        $xhtml1->loadDocument($dom);
        
        $node = $xhtml1->getContentXP()->query('//html:p/text()')->item(0);
        $this->assertEquals('test', $node->nodeValue);
    }
    
    /**
     * @covers ::append
     * @uses   \Lucille\Components\Xml\XhtmlContent::load
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testAppendWithXhtmlWrapperTag() {
        $xhtml1 = new XhtmlContent(new Filename(__DIR__.'/data/test.xhtml'));
        $xhtml2 = new XhtmlContent(new Filename(__DIR__.'/data/test2.xhtmltag.xhtml'));

        $xhtml1->append('container', $xhtml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/result.append.xhtmltag.xhtml', $xhtml1->getContentDom()->saveXML());
    }

    /**
     * @covers ::append
     * @uses   \Lucille\Components\Xml\XhtmlContent::load
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testAppendWithoutXhtmlWrapperTag() {
        $xhtml1 = new XhtmlContent(new Filename(__DIR__.'/data/test.xhtml'));
        $xhtml2 = new XhtmlContent(new Filename(__DIR__.'/data/test2.xhtml'));

        $xhtml1->append('container', $xhtml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/result.append.xhtml', $xhtml1->getContentDom()->saveXML());
    }

    /**
     * @covers ::replace
     * @uses   \Lucille\Components\Xml\XhtmlContent::load
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename 
     */
    public function testReplaceWithXhtmlWrapperTag() {
        $xhtml1 = new XhtmlContent(new Filename(__DIR__.'/data/test.xhtml'));
        $xhtml2 = new XhtmlContent(new Filename(__DIR__.'/data/test2.xhtmltag.xhtml'));
        
        $xhtml1->replace('container', $xhtml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/result.replace.xhtmltag.xhtml', $xhtml1->getContentDom()->saveXML());
    }

    /**
     * @covers ::replace
     * @uses   \Lucille\Components\Xml\XhtmlContent::load
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testReplaceWithoutXhtmlWrapperTag() {
        $xhtml1 = new XhtmlContent(new Filename(__DIR__.'/data/test.xhtml'));
        $xhtml2 = new XhtmlContent(new Filename(__DIR__.'/data/test2.xhtml'));

        $xhtml1->replace('container', $xhtml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/result.replace.xhtml', $xhtml1->getContentDom()->saveXML());
    }

    /**
     * @covers ::insertBefore
     * @uses   \Lucille\Components\Xml\XhtmlContent::load
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testInsertBeforeWithXhtmlWrapperTag() {
        $xhtml1 = new XhtmlContent(new Filename(__DIR__.'/data/test.xhtml'));
        $xhtml2 = new XhtmlContent(new Filename(__DIR__.'/data/test2.xhtmltag.xhtml'));
        
        $xhtml1->insertBefore('container', $xhtml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/result.insertbefore.xhtmltag.xhtml', $xhtml1->getContentDom()->saveXML());
    }

    /**
     * @covers ::insertBefore
     * @uses   \Lucille\Components\Xml\XhtmlContent::load
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     * @uses   \Lucille\Filename
     */
    public function testInsertBeforeWithoutXhtmlWrapperTag() {
        $xhtml1 = new XhtmlContent(new Filename(__DIR__.'/data/test.xhtml'));
        $xhtml2 = new XhtmlContent(new Filename(__DIR__.'/data/test2.xhtml'));
        
        $xhtml1->insertBefore('container', $xhtml2);
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/result.insertbefore.xhtml', $xhtml1->getContentDom()->saveXML());
    }
    
}
