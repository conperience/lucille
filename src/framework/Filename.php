<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille;
    
use Lucille\Exceptions\FileNotFoundException;

/**
 * Class Filename
 *
 * @package Lucille
 */
class Filename {
    
    /**
     * @var string
     */
    private $filename;

    /**
     * @param string $filename Filename
     * @throws FileNotFoundException
     */
    public function __construct(string $filename) {
        if (!file_exists($filename) || !is_file($filename)) {
            throw new FileNotFoundException($filename);
        }
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function asString(): string {
        return $this->filename;
    }
    
}
