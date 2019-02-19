<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Response;
    
use Lucille\Header\Header;
use Lucille\Header\HeaderCollection;

/**
 * Class GenericResponse
 *
 * @package Lucille\Response
 */
abstract class GenericResponse implements Response {
    
    /**
     * @var int
     */
    private $responseCode = 200;
    
    /**
     * @var HeaderCollection
     */
    private $headerCollection;
    
    /**
     * GenericResponse constructor.
     */
    public function __construct() {
        $this->headerCollection = new HeaderCollection();
    }
    
    /**
     * @param int $code http response status code
     * @return void
     */
    public function setResponseCode(int $code): void {
        $this->responseCode = $code;
    }
    
    /**
     * @return int
     */
    public function getResponseCode(): int {
        return $this->responseCode;
    }
    
    /**
     * @param Header $header Header object
     * @return void
     */
    public function addHeader(Header $header): void {
        $this->headerCollection->addHeader($header);
    }
    
    /**
     * @return HeaderCollection
     */
    public function getHeaderCollection(): HeaderCollection {
        return $this->headerCollection;
    }
    
    /**
     * @return void
     */
    abstract public function send(): void;
    
}
