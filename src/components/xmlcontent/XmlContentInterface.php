<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Xml;
    
use Lucille\Filename;

/**
 * Interface XmlContentInterface
 *
 * @package Lucille\Components\Xml
 */
interface XmlContentInterface {

    /**
     * @param Filename|null $file XML document filename
     */
    public function __construct(Filename $file = null);

    /**
     * @param Filename $file XML document filename
     * @return void
     */
    public function load(Filename $file): void;

    /**
     * @param \DOMDocument $dom DOMDocument instance
     * @return void
     */
    public function loadDocument(\DOMDocument $dom): void;

    /**
     * @param string $id DOMNode target id attribute
     * @return \DOMElement
     */
    public function findById(string $id): \DOMElement;

    /**
     * @param XPathQuery  $xpath   XPath query
     * @param \DOMElement $context XPath context node
     * @return \DOMNodeList
     */
    public function query(XPathQuery $xpath, \DOMElement $context = null): \DOMNodeList;

    /**
     * @param XPathQuery  $xpath   XPath query
     * @param \DOMElement $context XPath context node
     * @return \DOMElement
     */
    public function queryOne(XPathQuery $xpath, \DOMElement $context = null): \DOMElement;
    
    /**
     * @param string            $id      DOMNode target id attribute
     * @param GenericXmlContent $content GenericXmlResult content instance
     * @return void
     */
    public function append(string $id, GenericXmlContent $content): void;
    
    /**
     * @param string      $id         DOMNode id attribute
     * @param \DOMElement $domElement DOMElement node
     * @return void
     *
     * @throws Exceptions\XmlTargetIdNotFoundException
     * @throws Exceptions\XmlTargetIdNotUniqueException
     */
    public function appendNode(string $id, \DOMElement $domElement): void;
    
    /**
     * @param string            $id      DOMNode target id attribute
     * @param GenericXmlContent $content GenericXmlResult content instance
     * @return void
     */
    public function insertBefore(string $id, GenericXmlContent $content): void;

    /**
     * @param string            $id      DOMNode target id attribute
     * @param GenericXmlContent $content GenericXmlResult content instance
     * @return void
     */
    public function replace(string $id, GenericXmlContent $content): void;
    
    /**
     * @param string      $id         DOMNode id attribute
     * @param \DOMElement $domElement DOMElement instance
     * @return void
     *
     * @throws Exceptions\XmlTargetIdNotFoundException
     * @throws Exceptions\XmlTargetIdNotUniqueException
     */
    public function replaceNode(string $id, \DOMElement $domElement): void;
    
    /**
     * @param string $id DOMNode id attribute
     * @return void
     *
     * @throws Exceptions\XmlTargetIdNotFoundException
     * @throws Exceptions\XmlTargetIdNotUniqueException
     */
    public function remove(string $id): void;
    
    /**
     * @return \DOMDocument
     */
    public function getContentDom(): \DOMDocument;

    /**
     * @return \DOMXPath
     */
    public function getContentXP(): \DOMXPath;
    
}
