<?php
/**
 * Module for clear magento system
 *
 * @category Bigdrop
 * @package  Bigdrop_Cleaner
 * @author   Dmitry Kaplin <dmitry.kaplin@bigdropinc.com>
 */
use Bigdrop_Cleaner_Helper as Helper;

class Bigdrop_Cleaner_Model_Observer_Session_Db
{
    /**
     * Clear old session in database
     *
     * @throws Mage_Core_Exception
     * @return $this
     */
    public function execute()
    {
        try {
            // Mage_Core_Model_Resource_Session::gc() is too random
            $resource = Mage::getSingleton('core/resource');
            $resource->getConnection('core_write')
                ->delete(
                    $resource->getTableName('core/session'),
                    array('session_expires < ?' => time())
                );
        } catch (Exception $e) {
            Mage::throwException(Helper::__(
                'An error occurred while cleaning database session table: %s', $e->getMessage(), $e->getTraceAsString()
            ));
        }
        return $this;
    }
}