<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Xml;
    
use Lucille\Components\Xml\Exceptions\LoadingXmlFileFailedException;
use Lucille\Components\Xml\Exceptions\XmlMultipleNodesFoundException;
use Lucille\Components\Xml\Exceptions\XmlNodeNotFoundException;
use Lucille\Components\Xml\Exceptions\XmlTargetIdNotFoundException;
use Lucille\Components\Xml\Exceptions\XmlTargetIdNotUniqueException;
use Lucille\Filename;
use Lucille\Result\Result;

/**
 * Class GenericXmlContent
 *
 * @package Lucille\Components\Xml
 */
abstract class GenericXmlContent implements XmlContentInterface,Result {
    
    /**
     * @var \DOMDocument
     */
    protected $content;
    
    /**
     * @var \DOMXPath
     */
    protected $contentXP;

    /**
     * @param Filename|null $file XML document filename
     * @throws LoadingXmlFileFailedException
     */
    public function __construct(Filename $file = null) {
        $this->content = new \DOMDocument("1.0", "utf-8");
        $this->content->resolveExternals = true;
        
        if ($file !== null) {
            $this->load($file);
        }
    }
    
    /**
     * @param Filename $file XML document filename
     * @return void
     * @throws LoadingXmlFileFailedException
     */
    public function load(Filename $file): void {
        if (!$this->content->load($file->asString())) {
            throw new LoadingXmlFileFailedException($file);
        }
        $this->contentXP = new \DOMXPath($this->content);
    }
    
    /**
     * @param \DOMDocument $dom XML document (DOMDocument instance)
     * @return void
     */
    public function loadDocument(\DOMDocument $dom): void {
        $this->content = $dom;
        $this->contentXP = new \DOMXPath($this->content);
    }
    
    /**
     * @param string $id DOMNode id attribute
     * @return \DOMElement
     * @throws XmlTargetIdNotFoundException
     * @throws XmlTargetIdNotUniqueException
     */
    public function findById(string $id): \DOMElement {
        $target = $this->contentXP->query("//*[@id='$id']");
        if ($target->length == 0) {
            throw new XmlTargetIdNotFoundException($id);
        }
        
        if ($target->length > 1) {
            throw new XmlTargetIdNotUniqueException($id);
        }
        
        return $target->item(0);
    }
    
    /**
     * @param XPathQuery  $xpath   XPath query
     * @param \DOMElement $context XPath context node
     * @return \DOMNodeList
     */
    public function query(XPathQuery $xpath, \DOMElement $context = null): \DOMNodeList {
        return $this->contentXP->query($xpath->asString(), $context);
    }
    
    /**
     * @param XPathQuery  $xpath   XPath query
     * @param \DOMElement $context XPath context node
     * @return \DOMElement
     *
     * @throws XmlMultipleNodesFoundException
     * @throws XmlNodeNotFoundException
     */
    public function queryOne(XPathQuery $xpath, \DOMElement $context = null): \DOMElement {
        $items = $this->contentXP->query($xpath->asString(), $context);
        if ($items->length == 0) {
            throw new XmlNodeNotFoundException();
        }
        
        if ($items->length > 1) {
            throw new XmlMultipleNodesFoundException();
        }
        
        return $items->item(0);
    }
    
    /**
     * @param string      $id         DOMNode id attribute
     * @param \DOMElement $domElement DOMElement node
     * @return void
     *
     * @throws XmlTargetIdNotFoundException
     * @throws XmlTargetIdNotUniqueException
     */
    public function appendNode(string $id, \DOMElement $domElement): void {
        $imported = $this->content->importNode($domElement, true);
        $this->findById($id)->appendChild($imported);
    }
    
    /**
     * @param string      $id         DOMNode id attribute
     * @param \DOMElement $domElement DOMElement instance
     * @return void
     *
     * @throws XmlTargetIdNotFoundException
     * @throws XmlTargetIdNotUniqueException
     */
    public function replaceNode(string $id, \DOMElement $domElement): void {
        $imported = $this->content->importNode($domElement, true);
        
        $target = $this->findById($id);
        $target->parentNode->replaceChild($imported, $target);
    }
    
    /**
     * @param string $id DOMNode id attribute
     * @return void
     *
     * @throws XmlTargetIdNotFoundException
     * @throws XmlTargetIdNotUniqueException
     */
    public function remove(string $id): void {
        $target = $this->findById($id);
        $target->parentNode->removeChild($target);
    }
    
    /**
     * @return \DOMDocument
     */
    public function getContentDom(): \DOMDocument {
        return $this->content;
    }

    /**
     * @return \DOMXPath
     */
    public function getContentXP(): \DOMXPath {
        return $this->contentXP;
    }
    
}
