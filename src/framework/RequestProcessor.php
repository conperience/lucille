<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille;
    
use Lucille\Components\Xml\XhtmlContentResultRouter;
use Lucille\Components\Xml\XmlContentResultRouter;
use Lucille\Exceptions\LucilleException;
use Lucille\Exceptions\RoutingChainConfigurationException;
use Lucille\Exceptions\UnsupportedRoutingChainException;
use Lucille\Request\Request;
use Lucille\Response\LucilleErrorResponse;
use Lucille\Response\Response;
use Lucille\Routing\DeleteRoutingChain;
use Lucille\Routing\GetRoutingChain;
use Lucille\Routing\PatchRoutingChain;
use Lucille\Routing\PostRoutingChain;
use Lucille\Routing\PutRoutingChain;
use Lucille\Routing\ResultRoutingChain;
use Lucille\Routing\RoutingChain;
use Lucille\Request\PostRequest;
use Lucille\Request\PutRequest;
use Lucille\Request\PatchRequest;
use Lucille\Request\DeleteRequest;

/**
 * Class RequestProcessor
 *
 * @package Lucille
 */
class RequestProcessor {
    
    /**
     * @var bool
     */
    private $verboseError = false;
    
    /**
     * @var GetRoutingChain
     */
    private $getRoutingChain;

    /**
     * @var PostRoutingChain
     */
    private $postRoutingChain;

    /**
     * @var PutRoutingChain
     */
    private $putRoutingChain;

    /**
     * @var PatchRoutingChain
     */
    private $patchRoutingChain;
    
    /**
     * @var DeleteRoutingChain
     */
    private $deleteRoutingChain;

    /**
     * @var ResultRoutingChain
     */
    private $resultRoutingChain;

    /**
     * Display exception messages and trace info on errors
     * @return void
     */
    public function enableVerboseErrors(): void {
        $this->verboseError = true;
    }
    
    /**
     * @param RoutingChain $routingChain routing chain
     * @return void
     * @throws LucilleException
     */
    public function addRoutingChain(RoutingChain $routingChain): void {
        switch (get_class($routingChain)) {
            case GetRoutingChain::class: {
                $this->getRoutingChain = $routingChain;
                break;
            }
            case PostRoutingChain::class: {
                $this->postRoutingChain = $routingChain;
                break;
            }
            case PutRoutingChain::class: {
                $this->putRoutingChain = $routingChain;
                break;
            }
            case PatchRoutingChain::class: {
                $this->patchRoutingChain = $routingChain;
                break;
            }
            case DeleteRoutingChain::class: {
                $this->deleteRoutingChain = $routingChain;
                break;
            }
            case ResultRoutingChain::class: {
                $this->resultRoutingChain = $routingChain;
                break;
            }
            default: {
                throw new UnsupportedRoutingChainException("Routing chain type is not supported");
            }
        }
    }
    
    /**
     * @param Request $request HTTP request object
     * @return Response
     */
    public function run(Request $request): Response {
        try {
            $chain = null;
            switch (get_class($request)) {
                case 'Lucille\Request\GetRequest': {
                    $chain = $this->getRoutingChain;
                    break;
                }
                case PostRequest::class: {
                    $chain = $this->postRoutingChain;
                    break;
                }
                case PutRequest::class: {
                    $chain = $this->putRoutingChain;
                    break;
                }
                case PatchRequest::class: {
                    $chain = $this->patchRoutingChain;
                    break;
                }
                case DeleteRequest::class: {
                    $chain = $this->deleteRoutingChain;
                    break;
                }
            }
            
            if ($chain === null) {
                throw new RoutingChainConfigurationException('No routing chain found for current request type');
            }
            
            $result = $chain->route($request)->execute();
            
            // result routing
            if ($this->resultRoutingChain == null) {
                $this->resultRoutingChain = new ResultRoutingChain();
            }
            
            // register default router
            $this->resultRoutingChain->addRouter(new XhtmlContentResultRouter());
            $this->resultRoutingChain->addRouter(new XmlContentResultRouter());
            
            // route result
            $response = $this->resultRoutingChain->route($result);
            return $response;
        } catch (LucilleException $e) {
            return new LucilleErrorResponse($e, $this->verboseError);
        }
    }
    
}
