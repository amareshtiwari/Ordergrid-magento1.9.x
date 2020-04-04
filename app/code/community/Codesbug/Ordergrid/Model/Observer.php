<?php

class Codesbug_Ordergrid_Model_Observer
{

    /**
     *  Varien_Event_Observer $observer
     * call the function coreBlockAbstractToHtmlBefore handles our event to the observer
     */
    public function coreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {

        /** $block Mage_Core_Block_Abstract */
        $block = $observer->getEvent()->getBlock();

        if ($block->getId() == 'sales_order_grid') {
            /** add new colomn payment method */
            $paymentArray = Mage::getSingleton('payment/config')->getActiveMethods();
            $paymentMethods = array();
            foreach ($paymentArray as $code => $payment) {

                $paymentTitle = Mage::getStoreConfig('payment/' . $code . '/title');
                $paymentMethods[$code] = $paymentTitle;
            }
            /** add new colomn shipping method */
            $shippingArray = Mage::getSingleton('shipping/config')->getActiveCarriers();
            $shippingMethods = array();
            foreach ($shippingArray as $code1 => $shipping) {

                $shippingTitle = Mage::getStoreConfig('carriers/' . $code1 . '/title');
                $methodname = Mage::getStoreConfig('carriers/' . $code1 . '/name');
                $shippingMethods[$code1] = $shippingTitle . " - " . $methodname;
            }
            /** Getting the value from system.xml by the method Mage::getStoreConfig() */
            $extra = Mage::getStoreConfig('ordergridsection/ordergrid/view_style');
            $value = explode(",", $extra); /** converting string into array by expload function */
            if (in_array("payment", $value)) {
                $block->addColumnAfter(
                    'payment_method', array(
                        'header' => Mage::helper('sales')->__('Payment Method'),
                        'align' => 'left',
                        'type' => 'options',
                        'options' => $paymentMethods,
                        'index' => 'payment_method',
                        'filter_index' => 'payment.method',
                        'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterPayment'), /** add  filter_condition_callback to call the filter function */
                    ), 'shipping_name'/** add the colomn name after which you want to add your new colomn */
                );
            }
            if (in_array("shipping", $value)) {
                $block->addColumnAfter(
                    'shipping_description', array(
                        'header' => Mage::helper('sales')->__('Shipping Method'),
                        'align' => 'left',
                        'type' => 'options',
                        'options' => $shippingMethods,
                        'index' => 'shipping_description',
                        'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterShip_Method'),
                    ), 'payment_method');
            }
            if (in_array("name", $value)) {
                $block->addColumn('product_name', array(
                    'header' => Mage::helper('Sales')->__('Name'),
                    'width' => '150px',
                    'index' => 'increment_id',
                    'type' => 'text',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterName'),
                    'renderer' => 'ordergrid/Adminhtml_Ordergrid_Renderer_Name', /** call the renderer class Adminhtml_Test_Renderer_Red */
                ));
            }
            if (in_array("images", $value)) {
                $block->addColumn('image', array(
                    'header' => Mage::helper('ordergrid')->__('Image'),
                    'align' => 'left',
                    'index' => 'increment_id',
                    'width' => '107',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterImages'),
                    'renderer' => 'ordergrid/adminhtml_ordergrid_renderer_image', /** call the renderer class Adminhtml_Test_Renderer_image */
                ));
            }
            if (in_array("sku", $value)) {
                $block->addColumn('skus', array(
                    'header' => Mage::helper('ordergrid')->__('SKU(s)'),
                    'width' => '100px',
                    'index' => 'increment_id',
                    'type' => 'text',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterSku'),
                    'renderer' => 'ordergrid/adminhtml_ordergrid_renderer_red', /** call the renderer class Adminhtml_Test_Renderer_Red */
                ));
            }
            if (in_array("billing", $value)) {
                $block->addColumnAfter('full_address', array(
                    'header' => Mage::helper('sales')->__('Billing Address'),
                    'width' => '80px',
                    'type' => 'text',
                    'index' => 'full_address',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterAddress'),
                ), 'created_at');
            }
            if (in_array("ship_ad", $value)) {
                $block->addColumnAfter('full_address_ship', array(
                    'header' => Mage::helper('sales')->__('Shipping Address'),
                    'width' => '80px',
                    'type' => 'text',
                    'index' => 'full_address_ship',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterAddress_ship'),
                ), 'full_address');
            }
            if (in_array("customer", $value)) {
                $block->addColumnAfter('email', array(
                    'header' => Mage::helper('Sales')->__('Email'),
                    'width' => '110px',
                    'index' => 'email',
                    'type' => 'text',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterMail'),
                ), 'full_address');
            }
            if (in_array("product", $value)) {
                $block->addColumnAfter('total_qty_ordered', array(
                    'header' => Mage::helper('Sales')->__('Product Quantity'),
                    'width' => '110px',
                    'index' => 'total_qty_ordered',
                    'type' => 'text',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterQuantity'),
                ), 'full_address');
            }
            if (in_array("shipment", $value)) {
                $block->addColumnAfter('track_number', array(
                    'header' => Mage::helper('sales')->__('Track Number'),
                    'width' => '80px',
                    'type' => 'text',
                    'index' => 'track_number',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterTrack_no'),
                ), 'full_address');
            }
            if (in_array("status_color", $value)) {
                $block->addColumnAfter('status_color', array(
                    'header' => Mage::helper('sales')->__('Status'),
                    'index' => 'status',
                    'type' => 'options',
                    'width' => '100px',
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterStatus'),
                    'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
                    'renderer' => 'ordergrid/adminhtml_ordergrid_renderer_color', /** call the renderer class Adminhtml_Test_Renderer_status */
                ), 'grand_total');
            }

            $block->addColumnAfter('real_order', array(
                'header' => Mage::helper('sales')->__('Order #'),
                'width' => '80px',
                'type' => 'text',
                'index' => 'increment_id',
                'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterOrder'),
            ), 'skus');

            $block->addColumnAfter('base_total', array(
                'header' => Mage::helper('sales')->__('G.T. (Base)'),
                'index' => 'base_grand_total',
                'type' => 'currency',
                'currency' => 'base_currency_code',
                'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterTotal'),
            ), 'grand_total');

            $block->addColumnAfter('Purchased_total', array(
                'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
                'index' => 'grand_total',
                'type' => 'currency',
                'currency' => 'order_currency_code',
                'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterPurchase'),
            ), 'base_grand_total');

            $block->addColumnAfter('purchase_date', array(
                'header' => Mage::helper('sales')->__('Purchased On'),
                'index' => 'created_at',
                'type' => 'datetime',
                'width' => '100px',
                'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterPurchasedate'),
            ), 'increment_id');

            if (!empty(Mage::app()->isSingleStoreMode())) {
                $block->addColumnAfter('store_name', array(
                    'header' => Mage::helper('sales')->__('Purchased From (Store)'),
                    'index' => 'store_id',
                    'type' => 'store',
                    'store_view' => true,
                    'display_deleted' => true,
                    'filter_condition_callback' => array(Mage::getSingleton('ordergrid/observerfilter'), 'filterStorename'),
                ), 'created_at');
            }

        }
    }

    /**
     * fetching the data from database and retriving into sales order grid with the function salesOrderGridCollectionLoadBefore
     * this function will  handles our event to the observer
     */
    public function salesOrderGridCollectionLoadBefore(Varien_Event_Observer $observer)
    {
        $collection = $observer->getEvent()->getOrderGridCollection();
        $select = $collection->getSelect();
        $select->joinLeft(array('soas' => 'sales_flat_order_address'), 'soas.parent_id=main_table.entity_id and soas.address_type = "shipping"', array('full_address_ship' => 'CONCAT(soas.firstname, " " , soas.lastname, ",<br/>", soas.street, ",<br/>", soas.city, ",<br/>", soas.region, ",<br/>", soas.postcode)',
            'full_address' => 'CONCAT(soas.firstname, " " , soas.lastname, ",<br/>", soas.street, ",<br/>", soas.city, ",<br/>", soas.region, ",<br/>", soas.postcode)'), null);
        $select->joinLeft(array('payment' => $collection->getTable('sales/order_payment')), 'payment.parent_id=main_table.entity_id', array('payment_method' => 'method'));
        $select->joinLeft(array('shipping' => $collection->getTable('sales/order')), 'shipping.entity_id=main_table.entity_id', array('shipping_description' => 'shipping_description', 'total_qty_ordered' => 'total_qty_ordered'));
        $select->joinLeft(array('mail' => $collection->getTable('sales/order_address')), 'mail.entity_id=main_table.entity_id', array('email' => 'email'));
        $select->joinLeft(array('track_no' => $collection->getTable('sales/shipment_track')), 'track_no.order_id=main_table.entity_id', array('track_number' => 'track_number'));
    }

    /**
     * call the function coreBlockAbstractToHtmlAfter handles our event to the observer
     */
    public function coreBlockAbstractToHtmlAfter(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if ($block->getId() == 'sales_order_grid') {
            $default = Mage::getStoreConfig('ordergridsection/ordergrid/grid_style');

            $default_value = explode(",", $default);
            /**
             * Call the function removeColumn() with the event 'coreBlockAbstractToHtmlAfter' to remove the default column
            colomn from grid.php.
             */
            $block->removeColumn('status');
            $block->removeColumn('real_order_id');
            $block->removeColumn('base_grand_total');
            $block->removeColumn('grand_total');
            $block->removeColumn('created_at');
            $block->removeColumn('store_id');
            /**
             * applying the condetions on the fallowing default columns of grid to show and hide according to the selected options
            from the system->configuration
             */
            if (in_array("status_color", $default_value)) {
                $block->removeColumn('status_color');
            }
            if (in_array("order_date", $default_value)) {
                $block->removeColumn('purchase_date');
            }
            if (in_array("order_date", $default_value)) {
                $block->removeColumn('purchase_date');
            }
            if (in_array("order_no", $default_value)) {
                $block->removeColumn('real_order');
            }
            if (in_array("base", $default_value)) {
                $block->removeColumn('base_total');
            }
            if (in_array("purchased", $default_value)) {
                $block->removeColumn('Purchased_total');
            }
            if (in_array("billname", $default_value)) {
                $block->removeColumn('billing_name');
            }
            if (in_array("shpiname", $default_value)) {
                $block->removeColumn('shipping_name');
            }
            if (in_array("shpiname", $default_value)) {
                $block->removeColumn('shipping_name');
            }
            if (in_array("store_id", $default_value)) {
                $block->removeColumn('store_name');
            }
        }
    }

}
