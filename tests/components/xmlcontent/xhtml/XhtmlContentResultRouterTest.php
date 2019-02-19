<?php declare(strict_types=1);
/**
 * lucille
 *
 * @copyright  Andreas Habel
 * @author     Andreas Habel <mail@ahabel.de>
 *
 */

namespace Lucille\UnitTests;
        
use Lucille\Components\Xml\XhtmlContent;
use Lucille\Components\Xml\XhtmlContentResultRouter;
use Lucille\Components\Xml\XhtmlResponse;

use Lucille\Components\Xml\XmlContent;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Components\Xml\XhtmlContentResultRouter
 */
class XhtmlContentResultRouterTest extends TestCase {
    
    /**
     * @covers ::route
     * @uses   \Lucille\Components\Xml\XhtmlContent
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     * @uses   \Lucille\Components\Xml\XhtmlResponse
     * @uses   \Lucille\Response\GenericResponse
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     */
    public function testReturnsXhtmlResponse() {
        $router = new XhtmlContentResultRouter();
        
        $response = $router->route(
            new XhtmlContent()
        );
        
        $this->assertInstanceOf(XhtmlResponse::class, $response);
    }
    
    /**
     * @covers ::route
     * @uses   \Lucille\Components\Xml\XhtmlContent
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\XhtmlResponse
     * @uses   \Lucille\Routing\ResultRouter::getNext
     *
     * @uses   \Lucille\Exceptions\LucilleException::__construct
     * @uses   \Lucille\Exceptions\RoutingChainConfigurationException::__construct
    
     * @expectedException \Lucille\Exceptions\RoutingChainConfigurationException
     */
    public function testUnsupportedResultTypeInvokesNextRouter() {
        $router = new XhtmlContentResultRouter();
        $router->route(new XmlContent());
    }
    
}

