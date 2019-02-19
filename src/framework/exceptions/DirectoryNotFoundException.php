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
 * Class DirectoryNotFoundException
 *
 * @package Lucille\Exceptions
 */
class DirectoryNotFoundException extends LucilleException {
    
    /**
     * @var string
     */
    private $path;
    
    /**
     * @param string $path Directory path
     */
    public function __construct(string $path) {
        parent::__construct("Directory path '$path' does not exist");
        $this->path = $path;
    }
    
    /**
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }
    
}
