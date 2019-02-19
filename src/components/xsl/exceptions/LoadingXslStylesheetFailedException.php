<?php declare(strict_types=1);
/**
 * Lucille
 *
 * @author     Andreas Habel <mail@ahabel.de>
 * @copyright  Conperience GmbH, Andreas Habel and contributors
 *
 */

namespace Lucille\Components\Xsl\Exceptions;
    
use Lucille\Exceptions\LucilleException;
use Lucille\Filename;

/**
 * Class LoadingXslStylesheetFailedException
 *
 * @package Lucille\Components\Xsl\Exceptions
 */
class LoadingXslStylesheetFailedException extends LucilleException {
    
    /**
     * @var Filename
     */
    private $stylesheetFilename;
    
    /**
     * @param Filename $filename Filename object
     */
    public function __construct(Filename $filename) {
        parent::__construct("Loading xsl stylesheet failed: ".$filename->asString());
        $this->stylesheetFilename = $filename;
    }
    
    /**
     * @return Filename
     */
    public function getStylesheetFilename(): Filename {
        return $this->stylesheetFilename;
    }
    
}
