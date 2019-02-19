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
 * Class GetRouter
 *
 * @package Lucille\Routing
 */
abstract class GetRouter {
    
    /**
     * @var GetRouter
     */
    private $next;
    
    /**
     * @param GetRouter $router GetRouter reference
     * @return void
     */
    public function setNext(GetRouter $router) {
        $this->next = $router;
    }
    
    /**
     * @return GetRouter
     * @throws RoutingChainConfigurationException
     */
    public function getNext(): GetRouter {
        if ($this->next === null) {
            throw new RoutingChainConfigurationException('Cannot invoke next router');
        }
        return $this->next;
    }
    
    /**
     * @param GetRequest $request GetRequest object
     * @return Query
     */
    abstract public function route(GetRequest $request): Query;
    
}
