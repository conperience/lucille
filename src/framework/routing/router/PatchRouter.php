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
use Lucille\Request\PatchRequest;

/**
 * Class PatchRouter
 *
 * @package Lucille\Routing
 */
abstract class PatchRouter {
    
    /**
     * @var PatchRouter
     */
    private $next;
    
    /**
     * @param PatchRouter $router PatchRouter reference
     * @return void
     */
    public function setNext(PatchRouter $router) {
        $this->next = $router;
    }
    
    /**
     * @return PatchRouter
     * @throws RoutingChainConfigurationException
     */
    public function getNext(): PatchRouter {
        if ($this->next === null) {
            throw new RoutingChainConfigurationException('Cannot invoke next router');
        }
        return $this->next;
    }
    
    /**
     * @param PatchRequest $request PatchRequest object
     * @return Command
     */
    abstract public function route(PatchRequest $request): Command;
    
}
