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
 * Class XhtmlContent
 *
 * @package Lucille\Components\Xml
 */
class XhtmlContent extends GenericXmlContent implements XmlContentInterface {
    
    /**
     * @param Filename $file XML document filename
     * @return void
     *
     * @throws Exceptions\LoadingXmlFileFailedException
     */
    public function load(Filename $file): void {
        parent::load($file);
        $this->contentXP->registerNamespace('html', 'http://www.w3.org/1999/xhtml');
    }
    
    /**
     * @param \DOMDocument $dom XML document (DOMDocument instance)
     * @return void
     *
     * @throws Exceptions\LoadingXmlFailedException
     */
    public function loadDocument(\DOMDocument $dom): void {
        parent::loadDocument($dom);
        $this->contentXP->registerNamespace('html', 'http://www.w3.org/1999/xhtml');
    }
    
    /**
     * @param string            $id      DOMNode id attribute
     * @param GenericXmlContent $content GenericXmlResult instance
     * @return void
     *
     * @throws Exceptions\XmlTargetIdNotFoundException
     * @throws Exceptions\XmlTargetIdNotUniqueException
     */
    public function append(string $id, GenericXmlContent $content): void {
        $source = $content->getContentDom()->documentElement;
        
        // filter out xhtml tags if required
        if ($source->localName == 'xhtml') {
            $mergerTmp = $this->content->createDocumentFragment();
            foreach ($source->childNodes as $node) {
                $tt = $this->content->importNode($node, true);
                $mergerTmp->appendChild($tt);
            }
        } else {
            $mergerTmp = $this->content->importNode($source, true);
        }
        
        $this->findById($id)->appendChild($mergerTmp);
    }
    
    /**
     * @param string            $id      DOMNode id attribute
     * @param GenericXmlContent $content GenericXmlResult instance
     * @return void
     *
     * @throws Exceptions\XmlTargetIdNotFoundException
     * @throws Exceptions\XmlTargetIdNotUniqueException
     */
    public function insertBefore(string $id, GenericXmlContent $content): void {
        $source = $content->getContentDom()->documentElement;
        
        // filter out xhtml tags if required
        if ($source->localName == 'xhtml') {
            $mergerTmp = $this->content->createDocumentFragment();
            foreach ($source->childNodes as $node) {
                $tt = $this->content->importNode($node, true);
                $mergerTmp->appendChild($tt);
            }
        } else {
            $mergerTmp = $this->content->importNode($source, true);
        }
        
        $target = $this->findById($id);
        $target->parentNode->insertBefore($mergerTmp, $target);
    }
    
    /**
     * @param string            $id      DOMNode id attribute
     * @param GenericXmlContent $content GenericXmlResult instance
     * @return void
     *
     * @throws Exceptions\XmlTargetIdNotFoundException
     * @throws Exceptions\XmlTargetIdNotUniqueException
     */
    public function replace(string $id, GenericXmlContent $content): void {
        $source = $content->getContentDom()->documentElement;
        
        // filter out xhtml wrapper tag if required
        if ($source->localName == 'xhtml') {
            $mergerTmp = $this->content->createDocumentFragment();
            foreach ($source->childNodes as $node) {
                $tt = $this->content->importNode($node, true);
                $mergerTmp->appendChild($tt);
            }
        } else {
            $mergerTmp = $this->content->importNode($source, true);
        }

        $target = $this->findById($id);
        $target->parentNode->replaceChild($mergerTmp, $target);
    }
            
}
