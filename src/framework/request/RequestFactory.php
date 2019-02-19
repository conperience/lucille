<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
*/

namespace Lucille\Request;

use Lucille\Exceptions\UnsupportedRequestMethodException;
use Lucille\Header\HeaderCollection;
use Lucille\Request\Body\RequestBodyFactory;
use Lucille\Request\Parameter\RequestParameterCollection;

/**
 * Class RequestFactory
 *
 * @package Lucille\Request
 */
class RequestFactory {

    /**
     * @var array
     */
    private $globalGet;

    /**
     * @var array
     */
    private $globalPost;

    /**
     * @var array
     */
    private $globalServer;

    /**
     * @var string
     */
    private $inputStream;
    
    /**
     * @param array  $globalGet    _GET source data
     * @param array  $globalPost   _POST source data
     * @param array  $globalServer _SERVER source data
     * @param string $inputStream  Input stream (default: php://input)
     */
    public function __construct(array $globalGet, array $globalPost, array $globalServer, string $inputStream) {
        $this->globalGet    = $globalGet;
        $this->globalPost   = $globalPost;
        $this->globalServer = $globalServer;
        $this->inputStream  = $inputStream;
    }
    
    /**
     * @return Request
     * @throws UnsupportedRequestMethodException
     */
    public function createRequest(): Request {
        $url = new Uri($this->globalServer['REQUEST_URI']);
        
        // build header collection
        $headerCollection = HeaderCollection::fromSource($this->globalServer);
        
        switch (strtoupper($this->globalServer['REQUEST_METHOD'])) {
            case RequestMethod::GET: {
                $parameterCollection = RequestParameterCollection::fromArray($this->globalGet);
                return new GetRequest($url, $headerCollection, $parameterCollection);
            }
            case RequestMethod::POST: {
                $parameterCollection = RequestParameterCollection::fromArray($this->globalPost);
                $requestBody = RequestBodyFactory::fromStream($this->inputStream);
                return new PostRequest($url, $headerCollection, $parameterCollection, $requestBody);
            }
            case RequestMethod::PUT: {
                $parameterCollection = RequestParameterCollection::fromArray($this->globalGet);
                $requestBody = RequestBodyFactory::fromStream($this->inputStream);
                return new PutRequest($url, $headerCollection, $parameterCollection, $requestBody);
            }
            case RequestMethod::PATCH: {
                $parameterCollection = RequestParameterCollection::fromArray($this->globalGet);
                $requestBody = RequestBodyFactory::fromStream($this->inputStream);
                return new PatchRequest($url, $headerCollection, $parameterCollection, $requestBody);
            }
            case RequestMethod::DELETE: {
                $parameterCollection = RequestParameterCollection::fromArray($this->globalGet);
                $requestBody = RequestBodyFactory::fromStream($this->inputStream);
                return new DeleteRequest($url, $headerCollection, $parameterCollection, $requestBody);
            }
            default: {
                throw new UnsupportedRequestMethodException($this->globalServer['REQUEST_METHOD']);
            }
        }
    }
    
}
