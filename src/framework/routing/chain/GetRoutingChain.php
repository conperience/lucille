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
use Lucille\Query;
use Lucille\Request\GetRequest;

/**
 * Class GetRoutingChain
 *
 * @package Lucille\Routing
 */
class GetRoutingChain implements RoutingChain {
    
    /**
     * @var GetRouter
     */
    protected $start;

    /**
     * @var GetRouter
     */
    protected $previous;
    
    /**
     * @param GetRouter $router GetRouter instance
     * @return void
     */
    public function addRouter(GetRouter $router): void {
        if ($this->start === null) {
            $this->start = $router;
        }
        
        if ($this->previous !== null) {
            $this->previous->setNext($router);
        }
        $this->previous = $router;
    }

    /**
     * @param GetRequest $request GetRequest instance
     * @return Query
     * @throws RoutingChainConfigurationException
     */
    public function route(GetRequest $request): Query {
        if ($this->start === null) {
            throw new RoutingChainConfigurationException('No routing target found');
        }
        return $this->start->route($request);
    }
    
}
