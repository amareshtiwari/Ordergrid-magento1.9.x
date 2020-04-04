<?php

/** Renderer class Renderer_Image extending Renderer_Abstract
 *
 *  */
class Codesbug_Ordergrid_Block_Adminhtml_Ordergrid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
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
            $orderObj = Mage::registry('increment_id' . $row->getIncrementId());
        }
        /**  call the function getAllVisibleItems to get the Parent items
         */
        $items = $orderObj->getAllVisibleItems();
        $image = "";
        $count = 0;
        try {
            foreach ($items as $i) {
                $product = Mage::getModel("catalog/product")->load($i->getProductId());

                if ($product->getImage() != 'no_selection') {
                    $count++;
                }
            }
            if ($count == '1') {
                foreach ($items as $a) {
                    $product = Mage::getModel("catalog/product")->load($a->getProductId());
                    $image .= "<img src='" . Mage::helper('catalog/image')->init($product, 'image')->resize(120) . "' title='" . $product->getName() . "' />";
                }
            } else {
                foreach ($items as $a) {
                    $product = Mage::getModel("catalog/product")->load($a->getProductId());
                    $image .= "<img src='" . Mage::helper('catalog/image')->init($product, 'image')->resize(60) . "' title='" . $product->getName() . "' />";
                }
            }
        } catch (Exception $ex) {

        }

        return $image;
    }

}
