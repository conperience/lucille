<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Request;

use Lucille\Exceptions\UriPartIndexOutOfBoundsException;
    
/**
 * Class Uri
 *
 * @package Lucille\Request
 */
class Uri {
    
    /**
     * @var string
     */
    private $uri;
    
    /**
     * @var string
     */
    private $path;
    
    /**
     * @param string $uri Original request Uri
     */
    public function __construct(string $uri) {
        $this->uri = trim($uri);
        $this->path = parse_url($this->uri, PHP_URL_PATH);
        if ($this->path !== '/') {
            $this->path = rtrim($this->path, '/');
        }
    }
    
    /**
     * @return string
     */
    public function asString(): string {
        return $this->path;
    }
    
    /**
     * @return string
     */
    public function originUriAsString(): string {
        return $this->uri;
    }
    
    /**
     * @param int $index URI path index value
     * @return string
     * @throws UriPartIndexOutOfBoundsException
     */
    public function getPart(int $index): UriPart {
        $tmp = explode('/', trim(urldecode($this->asString()), '/'));
        
        if ($index > count($tmp) || $index < 0) {
            throw new UriPartIndexOutOfBoundsException("No uri segment found for given index value");
        }
        return new UriPart($tmp[$index]);
    }
    
    /**
     * @param Uri $uri Uri reference
     * @return bool
     */
    public function isEqual(Uri $uri): bool {
        return $this->asString() === $uri->asString();
    }
    
    /**
     * @param Uri $uri Uri reference
     * @return bool
     */
    public function beginsWith(Uri $uri): bool {
        if (substr($this->path, 0, strlen($uri->asString())) === $uri->asString()) {
            return true;
        }
        return false;
    }
    
    /**
     * @param UriRegEx $regexPattern RegEx pattern
     * @return bool
     */
    public function matchesRegEx(UriRegEx $regexPattern): bool {
        $rc = preg_match($regexPattern->asString(), $this->path, $m);
        return ($rc > 0 ? true : false);
    }
    
}
