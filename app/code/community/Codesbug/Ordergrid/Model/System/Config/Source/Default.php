<?php

class Codesbug_Ordergrid_Model_System_Config_Source_default
{

    public function toOptionArray()
    {
        $default_cols = array(
            array('value' => '', 'label' => Mage::helper('adminhtml')->__('None')),
            array('value' => 'order_no', 'label' => Mage::helper('adminhtml')->__('Order #')),
            array('value' => 'order_date', 'label' => Mage::helper('adminhtml')->__('Purchased On')),
            array('value' => 'base', 'label' => Mage::helper('adminhtml')->__('G.T(base)')),
            array('value' => 'purchased', 'label' => Mage::helper('adminhtml')->__('G.T(purchased)')),
            array('value' => 'billname', 'label' => Mage::helper('adminhtml')->__('Bill to Name')),
            array('value' => 'shpiname', 'label' => Mage::helper('adminhtml')->__('Ship to Name')),
        );
        if (!empty(Mage::app()->isSingleStoreMode())) {
            array_push($default_cols, array('value' => 'store_id', 'label' => Mage::helper('adminhtml')->__('Purchased From (Store)')));
        }
        return $default_cols;
    }

}
