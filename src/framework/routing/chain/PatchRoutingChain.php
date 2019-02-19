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
 * Class PatchRoutingChain
 *
 * @package Lucille\Routing
 */
class PatchRoutingChain implements RoutingChain {
    
    /**
     * @var PatchRouter
     */
    protected $start;

    /**
     * @var PatchRouter
     */
    protected $previous;

    /**
     * @param PatchRouter $router PatchRouter instance
     * @return void
     */
    public function addRouter(PatchRouter $router): void {
        if ($this->start === null) {
            $this->start = $router;
        }
        
        if ($this->previous !== null) {
            $this->previous->setNext($router);
        }
        $this->previous = $router;
    }
    
    /**
     * @param PatchRequest $request PatchRequest instance
     * @return Command
     * @throws RoutingChainConfigurationException
     */
    public function route(PatchRequest $request): Command {
        if ($this->start === null) {
            throw new RoutingChainConfigurationException('No routing target found');
        }
        return $this->start->route($request);
    }
    
}
