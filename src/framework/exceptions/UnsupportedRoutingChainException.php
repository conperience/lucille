<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Exceptions;

/**
 * Class UnsupportedRoutingChainException
 *
 * @package Lucille\Exceptions
 */
class UnsupportedRoutingChainException extends LucilleException {

    /**
     * @param string $message Exception message
     */
    public function __construct(string $message = '') {
        parent::__construct($message);
    }
    
}
