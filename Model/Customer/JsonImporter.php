<?php
/**
 * @author Magesource
 * @copyright Magesource. All rights reserved.
 * @package Customer Import Module for Magento 2.
 */

declare(strict_types=1);

namespace Magesource\CustomerImport\Model\Customer;

use Magesource\CustomerImport\Api\ImportInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;

class JsonImporter implements ImportInterface
{
    /**
     * @var File
     */
    private $file;
    
    /**
     * @var DirectoryList
     */
    protected $dir;

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * CsvImporter constructor.
     * @param File $file
     * @param DirectoryList $dir
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        File $file,
        DirectoryList $dir,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->file = $file;
        $this->dir = $dir;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }
    /**
     * @inheritDoc
     */
    public function getImportData(InputInterface $input): array
    {
        $file = $input->getArgument(ImportInterface::SOURCE);
        return $this->readData($file);
    }

    /**
     * @inheritDoc
     * @throws LocalizedException
     * @throws Exception
     */
    public function readData(string $file): array
    {
        try {
            $import_dir_path = $this->dir->getPath('var');
            $file_path = $import_dir_path.'/import/'.$file;
            if (!$this->file->isExists($file_path)) {
                throw new LocalizedException(__('Invalid file path or no file found.'));
            }
            $data = $this->file->fileGetContents($file_path);
            $this->logger->info('JSON file is parsed');
        } catch (FileSystemException $e) {
            $this->logger->info($e->getMessage());
            throw new LocalizedException(__('File system exception' . $e->getMessage()));
        }

        return $this->formatData($data);
    }

    /**
     * Format Data
     *
     * @param string $data
     * @return array
     */
    public function formatData($data): array
    {
        return $this->serializer->unserialize($data);
    }
}
