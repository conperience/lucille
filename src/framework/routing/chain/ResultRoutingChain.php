<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Routing;

use Lucille\Exceptions\RoutingChainConfigurationException;
use Lucille\Response\Response;
use Lucille\Result\Result;

/**
 * Class ResultRoutingChain
 *
 * @package Lucille\Routing
 */
class ResultRoutingChain implements RoutingChain {
    
    /**
     * @var ResultRouter
     */
    protected $start;
    
    /**
     * @var ResultRouter
     */
    protected $previous;

    /**
     * @param ResultRouter $router ResultRouter instance
     * @return void
     */
    public function addRouter(ResultRouter $router): void {
        if ($this->start === null) {
            $this->start = $router;
        }
        
        if ($this->previous !== null) {
            $this->previous->setNext($router);
        }
        $this->previous = $router;
    }
    
    /**
     * @param Result $result ResultRouter instance
     * @return Response
     * @throws RoutingChainConfigurationException
     */
    public function route(Result $result): Response {
        if ($this->start === null) {
            throw new RoutingChainConfigurationException('No routing target found');
        }
        return $this->start->route($result);
    }
    
}
