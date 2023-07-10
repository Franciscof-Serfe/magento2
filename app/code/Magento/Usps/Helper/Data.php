<?php
/**
 * Copyright © Magento, Inc.
 * See COPYING.txt for license details.
 */
namespace Magento\Usps\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Usps data helper
 */
class Data extends AbstractHelper
{
    /**
     * Available shipping methods
     *
     * @var array
     */
    protected $availableShippingMethods = [
        'usps_000',    // All Mail Classes (3-digit)
        'usps_9000',   // All HAZMAT Mail Classes (4-digit)
        'usps_1',      // Priority Mail Express
        'usps_9001',   // Priority Mail Express HAZMAT
        'usps_2',      // Priority Mail
        'usps_9002',   // Priority Mail HAZMAT
        'usps_201',    // Priority Mail 1-Day (Deprecated)
        'usps_202',    // Priority Mail 2-Day (Deprecated)
        'usps_203',    // Priority Mail 3-Day (Deprecated)
        'usps_204',    // Priority Mail Military
        'usps_9204',   // Priority Mail Military HAZMAT
        'usps_205',    // Priority Mail DPO
        'usps_9205',   // Priority Mail DPO HAZMAT
        'usps_206',    // Priority Mail Offshore
        'usps_9206',   // Priority Mail Offshore HAZMAT
        'usps_3',      // USPS Ground Advantage (up to 15.999 oz)
        'usps_301',    // First-Class Mail Letters
        'usps_302',    // First-Class Mail Flats
        'usps_303',    // First-Class Mail Cards
        'usps_304',    // USPS Ground Advantage (up to 15.999 oz)
        'usps_9304',   // USPS Ground Advantage (up to 15.999 oz) HAZMAT
        'usps_4',      // Standard Mail
        'usps_401',    // Standard Mail Letters
        'usps_402',    // Standard Mail Flats
        'usps_403',    // Standard Mail Marketing Parcels
        'usps_404',    // Standard Mail Simple Samples
        'usps_405',    // Parcel Select Lightweight (Deprecated)
        'usps_5',      // Periodicals
        'usps_501',    // Periodicals
        'usps_502',    // Parcel Shaped Periodicals
        'usps_6',      // Package Services
        'usps_601',    // Parcel Select (Deprecated)
        'usps_602',    // Standard Post
        'usps_603',    // Media Mail
        'usps_604',    // Library Mail
        'usps_605',    // Bound Printed Matter
        'usps_7',      // USPS Ground Advantage (up to 15.999 oz)
        'usps_9007',   // USPS Ground Advantage (up to 15.999 oz) HAZMAT
        'usps_9',      // USPS Ground Advantage (1 to 70lbs)
        'usps_9009',   // USPS Ground Advantage (1 to 70lbs) HAZMAT
    ];

    /**
     * Define if we need girth parameter in the package window
     *
     * @param string $shippingMethod
     * @return bool
     */
    public function displayGirthValue($shippingMethod)
    {
        return in_array($shippingMethod, $this->availableShippingMethods);
    }
}
