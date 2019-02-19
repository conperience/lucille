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
 * Class UriPartIndexOutOfBoundsException
 *
 * @package Lucille\Exceptions
 */
class UriPartIndexOutOfBoundsException extends LucilleException {

    /**
     * @param string $message Exception message
     */
    public function __construct(string $message) {
        parent::__construct($message);
    }
    
}
