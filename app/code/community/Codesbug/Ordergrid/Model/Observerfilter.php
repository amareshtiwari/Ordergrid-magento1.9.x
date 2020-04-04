<?php

class Codesbug_Ordergrid_Model_Observerfilter
{

    /**
     * call the filter functions to filter the order products by their name,sku,address,shipping method,status etc.
     */
    public function filterName($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()->joinLeft(array('name' => $collection->getTable('sales/order_item')), 'name.order_id=main_table.entity_id', array('name' => 'name'))->where("name.name like ?", "%$value%")->group('main_table.entity_id');
        return $this;
    }

    public function filterSku($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()->joinLeft(array('sku' => $collection->getTable('sales/order_item')), 'sku.order_id=main_table.entity_id', array('skus' => 'sku'))->where("sku.sku like ?", "%$value%")->group('main_table.entity_id');
        return $this;
    }

    public function filterImages($collection, $column)
    {
        if ($value = $column->getFilter()->getValue()) {
            echo "<script>alert('sorry..! you can not search orders by image names.')</script>";
        }
    }

    public function filterShip_Method($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        // Mage::log($value);
        if ($value == 'flatrate') {
            $value = 'Flat Rate - Fixed';
            $collection->getSelect()->reset(Zend_Db_Select::GROUP); /** call the function reset() to reset the groupby condetion   */
            $collection->getSelect()->joinLeft(array('shipping_desc' => $collection->getTable('sales/order')), 'shipping_desc.entity_id=main_table.entity_id', array('shipping_desc.shipping_description'))
                ->where("shipping_desc.shipping_description like ?", "%$value%")->group('main_table.entity_id');
        } else if ($value == 'dhl') {
            $value = 'DHL (Deprecated) - ';
            $collection->getSelect()->reset(Zend_Db_Select::GROUP);
            $collection->getSelect()->joinLeft(array('shipping_desc' => $collection->getTable('sales/order')), 'shipping_desc.entity_id=main_table.entity_id', array('shipping_desc.shipping_description'))
                ->where("shipping_desc.shipping_description like ?", "%$value%")->group('main_table.entity_id');
        } else if ($value == 'fedex') {
            $value = 'Federal Express - ';
            $collection->getSelect()->reset(Zend_Db_Select::GROUP);
            $collection->getSelect()->joinLeft(array('shipping_desc' => $collection->getTable('sales/order')), 'shipping_desc.entity_id=main_table.entity_id', array('shipping_desc.shipping_description'))
                ->where("shipping_desc.shipping_description like ?", "%$value%")->group('main_table.entity_id');
        } else {
            Mage::log('called');
            $collection->getSelect()->reset(Zend_Db_Select::GROUP);
            $collection->getSelect()->joinLeft(array('shipping_descr' => $collection->getTable('sales/order')), 'shipping_descr.entity_id=main_table.entity_id', array('shipping_descr.shipping_description'))
                ->where("shipping_descr.shipping_method like ?", "%$value%")->group('main_table.entity_id');
        }

        return $this;
    }

    public function filterStatus($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->joinLeft(array('status_filter' => $collection->getTable('sales/order')), 'status_filter.entity_id=main_table.entity_id', array('status_filter.status'))
            ->where("status_filter.status like ?", "%$value%")->group('main_table.entity_id');
    }

    public function filterPayment($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->joinLeft(array('pay' => $collection->getTable('sales/order_payment')), 'pay.parent_id=main_table.entity_id', array('pay.method'))->where("pay.method like ?", "%$value%")->group('main_table.entity_id');

        return $this;
    }

    public function filterMail($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->joinLeft(array('mailto' => $collection->getTable('sales/order_address')), 'mailto.entity_id=main_table.entity_id', array('mailto.email'))->where("mailto.email like ?", "%$value%")->group('main_table.entity_id');
        return $this;
    }

    public function filterQuantity($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->joinLeft(array('quant' => $collection->getTable('sales/order')), 'quant.entity_id=main_table.entity_id', array('quant.total_qty_ordered'))->where("quant.total_qty_ordered like ?", "%$value%")->group('main_table.entity_id');
        return $this;
    }

    public function filterOrder($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.increment_id like ?", "%$value%")->group('main_table.entity_id');
        return $this;
    }

    public function filterPurchase($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }

        $from = $value['from'];
        $to = $value['to'];
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.base_grand_total between '$from' and '$to'")->group('main_table.entity_id');
    }

    public function filterPurchasedate($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }
        $from = DateTime::createFromFormat('m/d/Y', $value['orig_from']);
        $from = $from->format('Y-m-d');
        $to = DateTime::createFromFormat('m/d/Y', $value['orig_to']);
        $to = $to->format('Y-m-d');
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.created_at between '$from' and '$to'")->group('main_table.entity_id');
    }

    public function filterStorename($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.store_id = ?", "$value")->group('main_table.entity_id');
    }

    public function filterTotal($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {

            return $this;
        }
        $from = $value['from'];
        $to = $value['to'];
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->where("main_table.base_grand_total between '$from' and '$to'")->group('main_table.entity_id');
    }

    public function filterTrack_no($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        $collection->getSelect()->joinLeft(array('tracking_no' => $collection->getTable('sales/shipment_track')), 'tracking_no.entity_id=main_table.entity_id', array('tracking_no.track_number'))->where("tracking_no.track_number like ?", "%$value%")->group('main_table.entity_id');
        return $this;
    }

    public function filterAddress($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }
        $collection->getSelect()
            ->joinLeft(array('add' => 'sales_flat_order'), 'add.entity_id = main_table.entity_id', array('add.billing_address_id'));
        $collection->getSelect()
            ->joinLeft(
                array('customer_add' => 'sales_flat_order_address'), 'customer_add.entity_id = add.billing_address_id', array('customer_add.city'))
            ->where("customer_add.city like '%$value%' "
                . "OR customer_add.region like '%$value%' "
                . "OR customer_add.firstname like '%$value%' "
                . "OR customer_add.lastname like '%$value%' "
                . "OR customer_add.street like '%$value%' "
                . "OR customer_add.postcode like?", "%$value%");
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        return $this;
    }

    public function filterAddress_ship($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $collection->getSelect()
            ->joinLeft(array('address' => 'sales_flat_order'), 'address.entity_id = main_table.entity_id', array('address.billing_address_id'));
        $collection->getSelect()
            ->joinLeft(
                array('ship_add' => 'sales_flat_order_address'), 'ship_add.entity_id = address.billing_address_id', array('ship_add.city'))
            ->where("ship_add.city like '%$value%' "
                . "OR ship_add.region like '%$value%' "
                . "OR ship_add.firstname like '%$value%' "
                . "OR ship_add.lastname like '%$value%' "
                . "OR ship_add.street like '%$value%' "
                . "OR ship_add.postcode like?", "%$value%");
        $collection->getSelect()->reset(Zend_Db_Select::GROUP);
        return $this;
    }

}
