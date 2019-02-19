<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille;
    
use Lucille\Exceptions\DirectoryNotFoundException;

/**
 * Class Directory
 *
 * @package Lucille
 */
class Directory {
    
    /**
     * @var string
     */
    private $path;
    
    /**
     * @param string $path Directory path
     * @throws DirectoryNotFoundException
     */
    public function __construct(string $path) {
        if (!file_exists($path) || !is_dir($path)) {
            throw new DirectoryNotFoundException($path);
        }
        $this->path = $path;
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return $this->path;
    }
    
}
