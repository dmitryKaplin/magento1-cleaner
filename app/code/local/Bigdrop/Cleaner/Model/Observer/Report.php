<?php
/**
 * Module for clear magento system
 *
 * @category Bigdrop
 * @package  Bigdrop_Cleaner
 * @author   Dmitry Kaplin <dmitry.kaplin@bigdropinc.com>
 */
class Bigdrop_Cleaner_Model_Observer_Report extends Bigdrop_Cleaner_Model_Observer_Abstract
{
    /**
     * Xml path for session clean enabled
     */
    const XML_PATH_REPORT_CLEAN_ENABLED = 'bd_cleaner/settings/report_enabled';

    // 7 * 24 * 60 * 60 (7 days)
    protected $lifetime = 604800;

    /**
     * Clear old reports
     *
     * @return $this
     */
    public function execute()
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_REPORT_CLEAN_ENABLED)) {
            $reportPath = Mage::getBaseDir('var') . DS . 'report' . DS;
            $reports = glob($reportPath . '*');
            $errors = false;
            if (is_array($reports) && !empty($reports)) {
                $timeLimit = time() - $this->lifetime;

                foreach ($reports as $report) {
                    if (file_exists($report) && is_file($report) && filemtime($report) < $timeLimit) {
                        if (!@unlink($report) && !$errors) {
                            $errors = true;
                        }
                    }
                }
            }

            if ($errors) {
                $this->log(Helper::__('Some reports files could not be deleted.'));
            }
        }

        return $this;
    }
}