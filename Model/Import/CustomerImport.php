<?php
/**
 * @author Magesource
 * @copyright Magesource. All rights reserved.
 * @package Customer Import Module for Magento 2.
 */

declare(strict_types=1);

namespace Magesource\CustomerImport\Model\Import;
 
use Magento\CustomerImportExport\Model\Import\Customer;
 
class CustomerImport extends Customer
{
    /**
     * Function to Import Customer Data
     *
     * @param array $rowData
     */
    public function importCustomerData(array $rowData)
    {
        $this->prepareCustomerData($rowData);
        $entitiesToCreate = [];
        $entitiesToUpdate = [];
        $entitiesToDelete = [];
        $attributesToSave = [];
        
        $processedData = $this->_prepareDataForUpdate($rowData);
        $entitiesToCreate = array_merge($entitiesToCreate, $processedData[self::ENTITIES_TO_CREATE_KEY]);
        $entitiesToUpdate = array_merge($entitiesToUpdate, $processedData[self::ENTITIES_TO_UPDATE_KEY]);
        foreach ($processedData[self::ATTRIBUTES_TO_SAVE_KEY] as $tableName => $customerAttributes) {
            if (!isset($attributesToSave[$tableName])) {
                $attributesToSave[$tableName] = [];
            }
            $attributesToSave[$tableName] = array_diff_key(
                $attributesToSave[$tableName],
                $customerAttributes
            ) + $customerAttributes;
        }
        
        $this->updateItemsCounterStats($entitiesToCreate, $entitiesToUpdate, $entitiesToDelete);
        
        /**
        * Save prepared data
        */
        if ($entitiesToCreate || $entitiesToUpdate) {
            $this->_saveCustomerEntities($entitiesToCreate, $entitiesToUpdate);
        }
        if ($attributesToSave) {
            $this->_saveCustomerAttributes($attributesToSave);
        }
        
        return $entitiesToCreate[0]['entity_id'] ?? $entitiesToUpdate[0]['entity_id'] ?? null;
    }
}
