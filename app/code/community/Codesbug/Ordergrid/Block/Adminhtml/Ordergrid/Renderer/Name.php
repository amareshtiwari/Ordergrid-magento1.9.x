<?php

/** Renderer class Renderer_Red extending Renderer_Abstract
 *
 *  */
class Codesbug_Ordergrid_Block_Adminhtml_Ordergrid_Renderer_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {

        if (!Mage::registry('increment_id' . $row->getIncrementId())) {
            $orderObj = Mage::getModel('sales/order')->load($row->getIncrementId(), "increment_id");
            /** registring the variable
             */
            Mage::register('increment_id' . $row->getIncrementId(), $orderObj);
            /**  fetching the  registry variable value by Mage::registry()
             */
            $sales = Mage::registry('increment_id' . $row->getIncrementId());
        } else {
            ($orderObj = Mage::registry('increment_id' . $row->getIncrementId()));
        }
        /**  call the function getAllVisibleItems to get the Parent items
         */
        $items = $orderObj->getAllVisibleItems();
        $str = "";

        foreach ($items as $i) {
            $str .= "<b>Product Name:</b>" . $i->getProduct()->getName() . "<br>";
            $_product = Mage::getModel("catalog/product")->load($i->getProductId());
            $superAttribute = $i->getProductOptions();
            foreach ($superAttribute as $k => $key) {
                if ($k == "attributes_info") {
                    if ($_product->isConfigurable()) {
                        foreach ($key as $attribute) {
                            if (strcasecmp($attribute['label'], 'color') == 0) {
                                $str .= "<b>Product Color:</b><br>" . $attribute['value'] . "<br>";
                            }
                            if ($attribute['label'] == 'size') {
                                $str .= "<b>Product Size:</b><br>" . $attribute['value'] . "<br>";
                            }
                        }
                    }
                }
            }

        }
        return $str;
    }

}
