<?php declare(strict_types=1);

namespace Lucille\UnitTests;

use Lucille\Components\Xsl\Exceptions\ImportingXslStylesheetFailedException;
use Lucille\Filename;
use PHPUnit\Framework\TestCase;
    
/**
 * @coversDefaultClass \Lucille\Components\Xsl\Exceptions\ImportingXslStylesheetFailedException
 */
class ImportingXslStylesheetFailedExceptionTest extends TestCase {

    /**
     * @covers ::__construct
     * @covers ::getStylesheetFilename
     * @uses   \Lucille\Filename
     * @uses   \Lucille\Exceptions\LucilleException
     */
    public function testGetStylesheetFilename() {
        $xslFile = new Filename(__DIR__.'/../data/test.valid.xsl');
        try {
            throw new ImportingXslStylesheetFailedException($xslFile);
        } catch (ImportingXslStylesheetFailedException $e) {
            $this->assertEquals($xslFile, $e->getStylesheetFilename());
        }
    }
    
}
