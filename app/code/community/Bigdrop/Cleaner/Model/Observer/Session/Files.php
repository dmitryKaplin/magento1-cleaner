<?php
/**
 * Module for clear magento system
 *
 * @category Bigdrop
 * @package  Bigdrop_Cleaner
 * @author   Dmitry Kaplin <dmitry.kaplin@bigdropinc.com>
 */
use Bigdrop_Cleaner_Helper as Helper;

class Bigdrop_Cleaner_Model_Observer_Session_Files
{
    /**
     * Clear old session files
     *
     * @throws Mage_Core_Exception
     * @return $this
     */
    public function execute()
    {
        $sessionPath = Mage::getSingleton('core/session')->getSessionSavePath();
        $sessions = glob($sessionPath.DS.'sess_*');
        $errors = false;
        if (is_array($sessions) && !empty($sessions)) {
            $timeLimit = time() - (int) Mage::getResourceSingleton('core/session')->getLifeTime();

            foreach ($sessions as $session) {
                if (file_exists($session) && is_file($session) && filemtime($session) < $timeLimit) {
                    if (!@unlink($session) && !$errors) {
                        $errors = true;
                    }
                }
            }
        }

        if ($errors) {
            Mage::throwException(Helper::__('Some sessions files could not be deleted.'));
        }
        return $this;
    }
}