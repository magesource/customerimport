<?php

/**
 * @author Magesource
 * @copyright Magesource. All rights reserved.
 * @package Customer Import Module for Magento 2.
 */

declare(strict_types=1);

namespace Magesource\CustomerImport\Api;

use Symfony\Component\Console\Input\InputInterface;

interface ImportInterface
{
    public const PROFILE_NAME = "profile";
    public const SOURCE = "source";

    /**
     * Get Import Data
     *
     * @param InputInterface $input
     * @return array
     */
    public function getImportData(InputInterface $input): array;

    /**
     * Read Import Data
     *
     * @param string $data
     * @return array
     */
    public function readData(string $data): array;

    /**
     * Format Data
     *
     * @param mixed $data
     * @return array
     */
    public function formatData($data): array;
}
