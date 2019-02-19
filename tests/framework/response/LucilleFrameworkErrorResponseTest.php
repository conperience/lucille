<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;
    
use Lucille\Response\LucilleErrorResponse;
use PHPUnit\Framework\TestCase;

class TestEx extends \Exception {
}

/**
 * @coversDefaultClass \Lucille\Response\LucilleErrorResponse
 */
class LucilleFrameworkErrorResponseTest extends TestCase {

    /**
     * @covers \Lucille\Response\LucilleErrorResponse::__construct()
     */
    public function testConstruct() {
        $e = new TestEx();
        $res = new LucilleErrorResponse($e);
        
        $this->assertInstanceOf(LucilleErrorResponse::class, $res);
    }
        
}
