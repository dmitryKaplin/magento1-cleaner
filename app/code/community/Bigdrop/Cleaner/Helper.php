<?php
/**
 * Module for clear magento system
 *
 * @category Bigdrop
 * @package  Bigdrop_Cleaner
 * @author   Dmitry Kaplin <dmitry.kaplin@bigdropinc.com>
 */
class Bigdrop_Cleaner_Helper
{
    /**
     * All helpers
     *
     * @var array
     */
    private static $helpers = array();

    /**
     * Get data helper
     *
     * @return BD_Attachment_Helper_Data
     */
    public static function getData()
    {
        if (!isset(self::$helpers['data'])) {
            $helpers['data'] = Mage::helper('easyemail');
        }
        return $helpers['data'];
    }

    /**
     * Translate
     *
     * @return string
     */
    public static function __()
    {
        $args = func_get_args();
        return call_user_func_array(array(self::getData(), '__'), $args);
    }
}