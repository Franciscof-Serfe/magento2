<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Usps\Test\Unit\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Usps\Helper\Data;
use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    /**
     * @var Data
     */
    protected $_helperData;

    protected function setUp(): void
    {
        $helper = new ObjectManager($this);
        $arguments = [
            'context' => $this->createMock(Context::class),
        ];

        $this->_helperData = $helper->getObject(Data::class, $arguments);
    }

    /**
     * @covers \Magento\Usps\Helper\Data::displayGirthValue
     * @dataProvider shippingMethodDataProvider
     */
    public function testDisplayGirthValue($shippingMethod)
    {
        $this->assertTrue($this->_helperData->displayGirthValue($shippingMethod));
    }

    /**
     * @covers \Magento\Usps\Helper\Data::displayGirthValue
     */
    public function testDisplayGirthValueFalse()
    {
        $this->assertFalse($this->_helperData->displayGirthValue('test_shipping_method'));
    }

    /**
     * @return array shipping method name
     */
    public function shippingMethodDataProvider()
    {
        return [
            ['usps_0'],          // All Mail Classes (1-digit)
            ['usps_000'],        // All Mail Classes (3-digit)
            ['usps_9000'],       // All HAZMAT Mail Classes (4-digit)
            ['usps_1'],          // Priority Mail Express
            ['usps_9001'],       // Priority Mail Express HAZMAT
            ['usps_2'],          // Priority Mail
            ['usps_9002'],       // Priority Mail HAZMAT
            ['usps_201'],        // Priority Mail 1-Day (Deprecated)
            ['usps_202'],        // Priority Mail 2-Day (Deprecated)
            ['usps_203'],        // Priority Mail 3-Day (Deprecated)
            ['usps_204'],        // Priority Mail Military
            ['usps_9204'],       // Priority Mail Military HAZMAT
            ['usps_205'],        // Priority Mail DPO
            ['usps_9205'],       // Priority Mail DPO HAZMAT
            ['usps_206'],        // Priority Mail Offshore
            ['usps_9206'],       // Priority Mail Offshore HAZMAT
            ['usps_3'],          // First-Class
            ['usps_301'],        // First-Class Mail Letters
            ['usps_302'],        // First-Class Mail Flats
            ['usps_303'],        // First-Class Mail Cards
            ['usps_304'],        // First-Class Mail Parcel/Package (FCPS)
            ['usps_304'],        // Retail Ground (RG)
            ['usps_9304'],       // First-Class Mail Parcel/Package and Retail Ground HAZMAT
            ['usps_4'],          // Standard Mail
            ['usps_401'],        // Standard Mail Letters
            ['usps_402'],        // Standard Mail Flats
            ['usps_403'],        // Standard Mail Marketing Parcels
            ['usps_404'],        // Standard Mail Simple Samples
            ['usps_405'],        // Parcel Select Lightweight (Deprecated)
            ['usps_5'],          // Periodicals
            ['usps_501'],        // Periodicals
            ['usps_502'],        // Parcel Shaped Periodicals
            ['usps_6'],          // Package Services
            ['usps_6'],          // Retail Ground HAZMAT (deprecated), LIVES, Offshore
            ['usps_601'],        // Parcel Select (Deprecated)
            ['usps_602'],        // Standard Post
            ['usps_603'],        // Media Mail
            ['usps_604'],        // Library Mail
            ['usps_605'],        // Bound Printed Matter
            ['usps_7'],          // Parcel Select Ground
            ['usps_9007'],       // Parcel Select Ground HAZMAT
        ];
    }
}
