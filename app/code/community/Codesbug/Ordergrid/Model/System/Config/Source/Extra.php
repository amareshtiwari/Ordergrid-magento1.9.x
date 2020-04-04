<?php

class Codesbug_Ordergrid_Model_System_Config_Source_extra
{

    public function toOptionArray()
    {
        return array(
            array('value' => '', 'label' => Mage::helper('adminhtml')->__('None')),
            array('value' => 'status_color', 'label' => Mage::helper('adminhtml')->__('Status')),
            array('value' => 'images', 'label' => Mage::helper('adminhtml')->__('Product Images')),
            array('value' => 'sku', 'label' => Mage::helper('adminhtml')->__('Product SKU')),
            array('value' => 'name', 'label' => Mage::helper('adminhtml')->__('Product Name')),
            array('value' => 'payment', 'label' => Mage::helper('adminhtml')->__('Payment Method ')),
            array('value' => 'shipping', 'label' => Mage::helper('adminhtml')->__('Shipping Method')),
            array('value' => 'billing', 'label' => Mage::helper('adminhtml')->__('Billing Address')),
            array('value' => 'ship_ad', 'label' => Mage::helper('adminhtml')->__('Shipping Address')),
            array('value' => 'customer', 'label' => Mage::helper('adminhtml')->__('Customer Email')),
            array('value' => 'product', 'label' => Mage::helper('adminhtml')->__('Product Quantity')),
            array('value' => 'shipment', 'label' => Mage::helper('adminhtml')->__('Shipment Tracking Number')),
        );
    }

}
