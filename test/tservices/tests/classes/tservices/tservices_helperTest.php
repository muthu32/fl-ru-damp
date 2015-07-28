<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2014-04-02 at 19:50:22.
 */
class tservices_helperTest extends PHPUnit_Framework_TestCase {

    /**
     * @var tservices_helper
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    
    protected function setUp() {
        //$this->object = new tservices_helper;
        global $order_whitelist;
        
        if(isset($order_whitelist))
        {
            $order_whitelist[1] = 'kazakov';
            $_SESSION['login'] = 'kazakov';
        }
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    
    
    
    public function testGetOrderUrl() {
        $url = (isset($_SESSION))?tservices_helper::url('order_url'):tservices_helper::url('sbr_url');
        $this->assertEquals(tservices_helper::getOrderUrl(7777), sprintf($url,7777));
    }

    
    
    
    
    public function testIsAllowOrderReserve() {
        $this->assertTrue(tservices_helper::isAllowOrderReserve(1));
    }

    



    /**
     * Generated from @assert ('alex') == TRUE.
     *
     * @covers tservices_helper::isUserOrderWhiteList
     */
    public function testIsUserOrderWhiteList() {
        $this->assertTrue(
                tservices_helper::isUserOrderWhiteList('alex')
        );
    }

    /**
     * Generated from @assert () == TRUE.
     *
     * @covers tservices_helper::isUserOrderWhiteList
     */
    public function testIsUserOrderWhiteList2() {
        $this->assertTRUE(
                tservices_helper::isUserOrderWhiteList()
        );
    }

    /**
     * Generated from @assert ('fake') == FALSE.
     *
     * @covers tservices_helper::isUserOrderWhiteList
     */
    public function testIsUserOrderWhiteList3() {
        $this->assertFalse(
                tservices_helper::isUserOrderWhiteList('fake')
        );
    }

    /**
     * @covers tservices_helper::setProtocol
     * @todo   Implement testSetProtocol().
     */
    public function testSetProtocol() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::setFlashMessageFromConstWithTitle
     * @todo   Implement testSetFlashMessageFromConstWithTitle().
     */
    public function testSetFlashMessageFromConstWithTitle() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::setFlashMessage
     * @todo   Implement testSetFlashMessage().
     */
    public function testSetFlashMessage() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::showFlashMessages
     * @todo   Implement testShowFlashMessages().
     */
    public function testShowFlashMessages() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::input_element_error
     * @todo   Implement testInput_element_error().
     */
    public function testInput_element_error() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::tooltip
     * @todo   Implement testTooltip().
     */
    public function testTooltip() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::url
     * @todo   Implement testUrl().
     */
    public function testUrl() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::translit
     * @todo   Implement testTranslit().
     */
    public function testTranslit() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::image_src
     * @todo   Implement testImage_src().
     */
    public function testImage_src() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::photo_src
     * @todo   Implement testPhoto_src().
     */
    public function testPhoto_src() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::card_link
     * @todo   Implement testCard_link().
     */
    public function testCard_link() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::edit_link
     * @todo   Implement testEdit_link().
     */
    public function testEdit_link() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::new_url
     * @todo   Implement testNew_url().
     */
    public function testNew_url() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::category_url
     * @todo   Implement testCategory_url().
     */
    public function testCategory_url() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::cost_format
     * @todo   Implement testCost_format().
     */
    public function testCost_format() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers tservices_helper::date_text
     * @todo   Implement testDate_text().
     */
    public function testDate_text() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }
    
}
