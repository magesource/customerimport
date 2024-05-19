<?php

/**
 * @author Magesource
 * @copyright Magesource. All rights reserved.
 * @package Customer Import Module for Magento 2.
 */

declare(strict_types=1);

namespace Magesource\CustomerImport\Model;
 
use Magento\Framework\Exception;
use Magento\Framework\Filesystem\Io\File;
use Magento\Store\Model\StoreManagerInterface;
use Magesource\CustomerImport\Model\Import\CustomerImport;
 
class Customer
{
    /**
     * @var File
     */
    private $file;
    
    /**
     * @var StoreManagerInterface
     */
    private $storeManagerInterface;

    /**
     * @var CustomerImport
     */
    private $customerImport;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @param File $file
     * @param StoreManagerInterface $storeManagerInterface
     * @param CustomerImport $customerImport
     */
    public function __construct(
        File $file,
        StoreManagerInterface $storeManagerInterface,
        CustomerImport $customerImport
    ) {
        $this->file = $file;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->customerImport = $customerImport;
    }

    /**
     * Create customer
     *
     * @param array $data
     * @param int $websiteId
     * @param int $storeId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function createCustomer(array $data, int $websiteId, int $storeId): void
    {
        try {
            // collect the customer data
            $customerData = [
                'email'         => $data['emailaddress'],
                '_website'      => 'base',
                '_store'        => 'default',
                'firstname'     => $data['fname'],
                'lastname'      => $data['lname'],
                'store_id'      => $storeId,
                'website_id'    => $websiteId,
            ];
            
            // save the customer data
            $this->customerImport->importCustomerData($customerData);
        } catch (Exception $e) {
            $this->output->writeln(
                '<error>'. $e->getMessage() .'</error>',
                OutputInterface::OUTPUT_NORMAL
            );
        }
    }
}
