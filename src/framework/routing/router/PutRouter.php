<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Routing;
    
use Lucille\Command;
use Lucille\Exceptions\RoutingChainConfigurationException;
use Lucille\Request\PutRequest;

/**
 * Class PutRouter
 *
 * @package Lucille\Routing
 */
abstract class PutRouter {
    
    /**
     * @var PutRouter
     */
    private $next;
    
    /**
     * @param PutRouter $router PutRouter reference
     * @return void
     */
    public function setNext(PutRouter $router) {
        $this->next = $router;
    }
    
    /**
     * @return PutRouter
     * @throws RoutingChainConfigurationException
     */
    public function getNext(): PutRouter {
        if ($this->next === null) {
            throw new RoutingChainConfigurationException('Cannot invoke next router');
        }
        return $this->next;
    }
    
    /**
     * @param PutRequest $request PutRequest object
     * @return Command
     */
    abstract public function route(PutRequest $request): Command;
    
}
