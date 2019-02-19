<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Xsl;

use Lucille\Components\Xml\XmlContent;
use Lucille\Components\Xsl\Exceptions\ImportingXslStylesheetFailedException;
use Lucille\Components\Xsl\Exceptions\LoadingXslStylesheetFailedException;
use Lucille\Filename;

/**
 * Class XslProcessor
 *
 * @package Lucille\Components\Xsl
 */
class XslProcessor {
    
    /**
     * @var \XSLTProcessor
     */
    private $xslt;

    /**
     * @param Filename $filename Stylesheet Filename
     * @return void
     * @throws ImportingXslStylesheetFailedException
     * @throws LoadingXslStylesheetFailedException
     */
    public function __construct(Filename $filename) {
        $this->xslt = new \XSLTProcessor();
        $this->loadStylesheet($filename);
    }
    
    /**
     * @param Filename $filename Stylesheet Filename
     * @return void
     * @throws ImportingXslStylesheetFailedException
     * @throws LoadingXslStylesheetFailedException
     */
    public function loadStylesheet(Filename $filename): void {
        $dom = new \DOMDocument();
        if (!$dom->load($filename->asString())) {
            throw new LoadingXslStylesheetFailedException($filename);
        }
        
        if (!$this->xslt->importStylesheet($dom)) {
            throw new ImportingXslStylesheetFailedException($filename);
        }
    }
    
    /**
     * @param string $name  xsl parameter name
     * @param string $value xsl parameter value
     * @return bool
     */
    public function setParameter(string $name, string $value): bool {
        return $this->xslt->setParameter('', $name, $value);
    }
    
    /**
     * @param \DOMDocument $dom DOMDocument instance
     * @return XmlContent
     * @throws \Lucille\Components\Xml\Exceptions\LoadingXmlFileFailedException
     */
    public function transform(\DOMDocument $dom): XmlContent {
        $resDom = $this->xslt->transformToDoc($dom);
        $xml = new XmlContent();
        $xml->loadDocument($resDom);
        return $xml;
    }
    
    /**
     * @return \XSLTProcessor
     */
    public function getXsltProcessor(): \XSLTProcessor {
        return $this->xslt;
    }

}
