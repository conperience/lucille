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
use Lucille\Components\Xml\XmlContentResultRouter;
use Lucille\Components\Xml\XmlContent;

use Lucille\Components\Xml\XmlResponse;
use Lucille\Exceptions\RoutingChainConfigurationException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Lucille\Components\Xml\XmlContentResultRouter
 */
class XmlContentResultRouterTest extends TestCase {
    
    /**
     * @covers ::route
     * @uses   \Lucille\Components\Xml\XmlContent
     * @uses   \Lucille\Components\Xml\GenericXmlContent::__construct
     * @uses   \Lucille\Components\Xml\GenericXmlContent::getContentDom
     * @uses   \Lucille\Components\Xml\XmlResponse
     * @uses   \Lucille\Response\GenericResponse
     * @uses   \Lucille\Header\Header
     * @uses   \Lucille\Header\HeaderCollection
     */
    public function testReturnsXmlResponse() {
        $router = new XmlContentResultRouter();
        
        $response = $router->route(
            new XmlContent()
        );
        
        $this->assertInstanceOf(XmlResponse::class, $response);
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
     */
    public function testUnsupportedResultTypeInvokesNextRouter() {
        $this->expectException(RoutingChainConfigurationException::class);
        
        $router = new XmlContentResultRouter();
        $router->route(new XhtmlContent());
    }
    
}
