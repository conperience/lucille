<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;
        
use Lucille\Components\Xsl\Exceptions\ImportingXslStylesheetFailedException;
use Lucille\Components\Xsl\Exceptions\LoadingXslStylesheetFailedException;
use Lucille\Components\Xsl\XslProcessor;
use Lucille\Filename;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Components\Xsl\XslProcessor
 */
class XslProcessorTest extends TestCase {
    
    /**
     * @covers ::getXsltProcessor
     * @uses   \Lucille\Components\Xsl\XslProcessor::__construct
     * @uses   \Lucille\Components\Xsl\XslProcessor::loadStylesheet
     * @uses   \Lucille\Filename
     */
    public function testGetXsltProcessor() {
        $xsl = new XslProcessor(new Filename(__DIR__.'/data/test.valid.xsl'));
        $this->assertInstanceOf(\XSLTProcessor::class, $xsl->getXsltProcessor());
    }
    
    /**
     * @covers ::loadStylesheet
     * @covers ::__construct
     * @covers ::transform
     * @uses   \Lucille\Components\Xsl\XslProcessor::transform
     * @uses   \Lucille\Filename
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     */
    public function testLoadStyleSheet() {
        $xsl = new XslProcessor(new Filename(__DIR__.'/data/test.valid.xsl'));
        $res = $xsl->transform($this->createTestDom());
        
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.valid.result.xml', $res->getContentDom()->saveXML());
    }
    
    /**
     * @covers ::setParameter
     * @covers ::__construct
     * @uses   \Lucille\Components\Xsl\XslProcessor::loadStylesheet
     * @uses   \Lucille\Components\Xsl\XslProcessor::transform
     * @uses   \Lucille\Filename
     * @uses   \Lucille\Components\Xml\GenericXmlContent
     */
    public function testSetParameter() {
        $xsl = new XslProcessor(new Filename(__DIR__.'/data/test.valid.parameter.xsl'));
        $xsl->setParameter('p1', 'bar baz FOO');
        $res = $xsl->transform($this->createTestDom());
        
        $this->assertXmlStringEqualsXmlFile(__DIR__.'/data/test.valid.parameter.result.xml', $res->getContentDom()->saveXML());
    }
    
    /**
     * @covers ::loadStylesheet
     * @uses   \Lucille\Filename
     * @uses   \Lucille\Components\Xsl\XslProcessor::__construct
     *
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Components\xsl\Exceptions\LoadingXslStylesheetFailedException
     */
    public function testLoadInvalidStyleSheetThrowsException() {
        $this->expectException(LoadingXslStylesheetFailedException::class);
        
        $xsl = @new XslProcessor(new Filename(__DIR__.'/data/test.broken.xsl'));
    }
    
    /**
     * @covers ::loadStylesheet
     * @uses   \Lucille\Filename
     * @uses   \Lucille\Components\Xsl\XslProcessor::__construct
     *
     * @uses   \Lucille\Exceptions\LucilleException
     * @uses   \Lucille\Components\Xsl\Exceptions\ImportingXslStylesheetFailedException
     */
    public function testImportingInvalidStyleSheetButValidXmlDocumentThrowsException() {
        $this->expectException(ImportingXslStylesheetFailedException::class);
        
        $xsl = @new XslProcessor(new Filename(__DIR__.'/data/test.invalid.xsl'));
    }
    
    private function createTestDom(): \DOMDocument {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="utf-8"?><root></root>');
        return $dom;
    }
}
