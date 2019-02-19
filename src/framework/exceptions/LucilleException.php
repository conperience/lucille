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
 * Class LucilleException
 *
 * @package Lucille\Exceptions
 */
class LucilleException extends \Exception {
    
    /**
     * @param string $message exception message
     * @param int    $code    exceptionn code
     */
    public function __construct(string $message = '', int $code = 0) {
        parent::__construct($message, $code);
    }
    
    /**
     * @return string
     */
    public function getFullMessage(): string {
        return "Lucille Framework Error ({$this->code}) '{$this->message}' at line {$this->line} in file {$this->file}";
    }
    
}
