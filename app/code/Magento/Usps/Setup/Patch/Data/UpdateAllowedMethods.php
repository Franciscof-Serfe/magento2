<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Usps\Setup\Patch\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

/**
 * Class UpdateAllowedMethods
 * @package Magento\Usps\Setup\Patch
 */
class UpdateAllowedMethods implements DataPatchInterface, PatchVersionInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * UpdateAllowedMethods constructor.
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $connection = $this->moduleDataSetup->getConnection();
        $configDataTable = $this->moduleDataSetup->getTable('core_config_data');
        $oldToNewMethodCodesMap = [
'0' => 'All Mail Classes (1-digit)',
        '000' => 'All Mail Classes (3-digit)',
        '9000' => 'All HAZMAT Mail Classes (4-digit)',
        '1' => 'Priority Mail Express',
        '9001' => 'Priority Mail Express HAZMAT',
        '2' => 'Priority Mail',
        '9002' => 'Priority Mail HAZMAT',
        '201' => 'Priority Mail 1-Day (Deprecated)',
        '202' => 'Priority Mail 2-Day (Deprecated)',
        '203' => 'Priority Mail 3-Day (Deprecated)',
        '204' => 'Priority Mail Military',
        '9204' => 'Priority Mail Military HAZMAT',
        '205' => 'Priority Mail DPO',
        '9205' => 'Priority Mail DPO HAZMAT',
        '206' => 'Priority Mail Offshore',
        '9206' => 'Priority Mail Offshore HAZMAT',
        '3' => 'USPS Ground Advantage (up to 15.999 oz)',
        '301' => 'First-Class Mail Letters',
        '302' => 'First-Class Mail Flats',
        '303' => 'First-Class Mail Cards',
        '304' => 'USPS Ground Advantage (up to 15.999 oz)',
        '9304' => 'USPS Ground Advantage (up to 15.999 oz) HAZMAT',
        '4' => 'Standard Mail',
        '401' => 'Standard Mail Letters',
        '402' => 'Standard Mail Flats',
        '403' => 'Standard Mail Marketing Parcels',
        '404' => 'Standard Mail Simple Samples',
        '405' => 'Parcel Select Lightweight (Deprecated)',
        '5' => 'Periodicals',
        '501' => 'Periodicals',
        '502' => 'Parcel Shaped Periodicals',
        '6' => 'Package Services',
        '601' => 'Parcel Select (Deprecated)',
        '602' => 'Standard Post',
        '603' => 'Media Mail',
        '604' => 'Library Mail',
        '605' => 'Bound Printed Matter',
        '7' => 'USPS Ground Advantage (up to 15.999 oz)',
        '9007' => 'USPS Ground Advantage (up to 15.999 oz) HAZMAT',
        '9' => 'USPS Ground Advantage (1 to 70lbs)',
        '9009' => 'USPS Ground Advantage (1 to 70lbs) HAZMAT',
        ];

        $select = $connection->select()
            ->from($configDataTable)
            ->where(
                'path IN (?)',
                ['carriers/usps/free_method', 'carriers/usps/allowed_methods']
            );
        $oldConfigValues = $connection->fetchAll($select);

        foreach ($oldConfigValues as $oldValue) {
            if (stripos($oldValue['path'], 'free_method') !== false
                && isset($oldToNewMethodCodesMap[$oldValue['value']])
            ) {
                $newValue = $oldToNewMethodCodesMap[$oldValue['value']];
            } elseif (stripos($oldValue['path'], 'allowed_methods') !== false) {
                $newValuesList = [];
                foreach (explode(',', $oldValue['value']) as $shippingMethod) {
                    if (isset($oldToNewMethodCodesMap[$shippingMethod])) {
                        $newValuesList[] = $oldToNewMethodCodesMap[$shippingMethod];
                    }
                }
                $newValue = implode(',', $newValuesList);
            } else {
                continue;
            }

            if ($newValue && $newValue != $oldValue['value']) {
                $whereConfigId = $connection->quoteInto('config_id = ?', $oldValue['config_id']);
                $connection->update($configDataTable, ['value' => $newValue], $whereConfigId);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getVersion()
    {
        return '2.0.1';
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
