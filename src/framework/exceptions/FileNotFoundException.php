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
 * Class FileNotFoundException
 *
 * @package Lucille\Exceptions
 */
class FileNotFoundException extends LucilleException {
    
    /**
     * @var string
     */
    private $filename;
    
    /**
     * @param string $filename Filename string
     */
    public function __construct(string $filename) {
        parent::__construct("File with name '$filename' not found");
        $this->filename = $filename;
    }
    
    /**
     * @return string
     */
    public function getFilename(): string {
        return $this->filename;
    }
    
}
