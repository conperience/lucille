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
 * Class UnsupportedRequestMethodException
 *
 * @package Lucille\Exceptions
 */
class UnsupportedRequestMethodException extends LucilleException {
    
    /**
     * @param string $requestMethod HTTP request method
     */
    public function __construct(string $requestMethod) {
        parent::__construct('HTTP method type is not supported ('.$requestMethod.')');
    }
    
}
