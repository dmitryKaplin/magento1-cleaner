<?php
/**
 * Module for clear magento system
 *
 * @category Bigdrop
 * @package  Bigdrop_Cleaner
 * @author   Dmitry Kaplin <dmitry.kaplin@bigdropinc.com>
 */
class Bigdrop_Cleaner_Model_Observer_Abstract
{
    /**
     * Xml paths
     */
    const XML_PATH_LOG_FILE = 'bd_cleaner/settings/log_file';
    const XML_PATH_LOGGER_ENABLED = 'bd_cleaner/settings/log_enabled';

    /**
     * Logger
     *
     * @param string|Exception $data
     * @return $this
     */
    protected function log($data)
    {
        if (is_string($data)) {
            $message = $data;
        } else if ($data instanceof Exception) {
            $message = $data->getMessage();
        }

        if (Mage::getStoreConfigFlag(self::XML_PATH_LOGGER_ENABLED) && isset($message) && !empty($message)) {
            $dir = Mage::getBaseDir('var') . DS . 'log' . DS;
            $file = Mage::getStoreConfig(self::XML_PATH_LOG_FILE);
            $filepath = $dir . $file;
            $prefix = "\n";
            if (!file_exists($filepath)) {
                $prefix = '';
            }
            file_put_contents($filepath, $prefix . $message, FILE_APPEND | LOCK_EX);
        }
        return $this;
    }
}