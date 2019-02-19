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
 * Class HeaderNotFoundException
 *
 * @package Lucille\Exceptions
 */
class HeaderNotFoundException extends LucilleException {

    /**
     * @var string
     */
    private $headerName;
    
    /**
     * @param string $name Header name
     */
    public function __construct(string $name) {
        parent::__construct('Header with name '.$name.' was not found');
        $this->headerName = $name;
    }
    
    /**
     * @return string
     */
    public function getHeaderName(): string {
        return $this->headerName;
    }
    
}
