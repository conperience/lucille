<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Xml;

/**
 * Class XmlContent
 *
 * @package Lucille\Components\Xml
 */
class XmlContent extends GenericXmlContent implements XmlContentInterface {
    
    /**
     * @param string            $id      DOMNode id attribute
     * @param GenericXmlContent $content GenericXmlResult instance
     * @return void
     *
     * @throws Exceptions\XmlTargetIdNotFoundException
     * @throws Exceptions\XmlTargetIdNotUniqueException
     */
    public function append(string $id, GenericXmlContent $content): void {
        $mergerTmp = $this->content->importNode(
            $content->getContentDom()->documentElement,
            true
        );
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
        $mergerTmp = $this->content->importNode(
            $content->getContentDom()->documentElement,
            true
        );
        
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
        $mergerTmp = $this->content->importNode(
            $content->getContentDom()->documentElement,
            true
        );
        
        $target = $this->findById($id);
        $target->parentNode->replaceChild($mergerTmp, $target);
    }
    
}
