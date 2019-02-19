<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */
    
namespace Lucille\Components\Xml;

use Lucille\Header\Header;
use Lucille\Response\GenericResponse;

/**
 * Class XhtmlResponse
 *
 * @package Lucille\Components\Xml
 */
class XhtmlResponse extends GenericResponse {
    
    /**
     * @var string
     */
    private $content;
    
    /**
     * @param XhtmlContent $content XhtmlContent object
     */
    public function __construct(XhtmlContent $content) {
        parent::__construct();
        $this->content = $content->getContentDom()->saveXML();
        
        $headerCollection = $this->getHeaderCollection();
        $headerCollection->addHeader(new Header('Content-Type', 'application/xhtml+xml; charset=utf-8'));
        $headerCollection->addHeader(new Header('Content-Encoding', 'UTF-8'));
        $headerCollection->addHeader(new Header('Content-Length', (string)strlen($this->content)));
    }
    
    /**
     * @return void
     */
    public function send(): void {
        // set HTTP status code
        http_response_code($this->getResponseCode());
        
        if (count($this->getHeaderCollection()) > 0) {
            foreach ($this->getHeaderCollection() as $header) {
                header($header->asString());
            }
        }
        
        echo $this->content;
    }
    
}
