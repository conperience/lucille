<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Xml\Exceptions;

use Lucille\Exceptions\LucilleException;
use Lucille\Filename;

/**
 * Class LoadingXmlFileFailedException
 *
 * @package Lucille\Components\Xml\Exceptions
 */
class LoadingXmlFileFailedException extends LucilleException {
    
    /**
     * @var Filename
     */
    private $filename;
    
    /**
     * @param Filename $filename Filename object
     */
    public function __construct(Filename $filename) {
        parent::__construct("Loading xml file failed: ".$filename->asString());
        $this->filename = $filename;
    }

    /**
     * @return Filename
     */
    public function getFilename(): Filename {
        return $this->filename;
    }
    
}
