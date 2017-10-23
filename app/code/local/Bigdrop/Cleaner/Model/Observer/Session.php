<?php
/**
 * Module for clear magento system
 *
 * @category Bigdrop
 * @package  Bigdrop_Cleaner
 * @author   Dmitry Kaplin <dmitry.kaplin@bigdropinc.com>
 */
class Bigdrop_Cleaner_Model_Observer_Session extends Bigdrop_Cleaner_Model_Observer_Abstract
{
    /**
     * Xml path for session clean enabled
     */
    const XML_PATH_SESSION_CLEAN_ENABLED = 'bd_cleaner/settings/session_enabled';

    /**
     * Clear old session
     *
     * @return $this
     */
    public function execute()
    {
        if (Mage::getStoreConfigFlag(self::XML_PATH_SESSION_CLEAN_ENABLED)) {
            try {
                $this->getAdapter()->execute();
            } catch (Exception $e) {
                $this->log($e);
            }
        }

        return $this;
    }

    /**
     * Get adapter for session bd_cleaner
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function getAdapter()
    {
        $factoryName = 'bd_cleaner/observer_session_' . Mage::getSingleton('core/session')->getSessionSaveMethod();
        return Mage::getSingleton($factoryName);
    }
}