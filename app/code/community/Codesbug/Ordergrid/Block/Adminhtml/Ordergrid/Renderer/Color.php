<?php

/** Renderer class Renderer_Color extending Renderer_Abstract
 *
 *  */
class Codesbug_Ordergrid_Block_Adminhtml_Ordergrid_Renderer_Color extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        /** Fetching the selected options from the status index
         * */
        $value = $row->getData($this->getColumn()->getIndex());

        switch ($value) {
            case 'canceled':
                return ('<div id="cancel">' . $value . '</div>');
                break;
            case 'canceled_barclaycardsmartpaycw':
                return ('<div id="canceled_barclaycardsmartpaycw">' . $value . '</div>');
                break;
            case 'closed':
                return ('<div id="closed">' . $value . '</div>');
                break;
            case 'complete':
                return ('<div id="complete">' . $value . '</div>');
                break;
            case 'holded':
                return ('<div id="holded">' . $value . '</div>');
                break;
            case 'payment_review':
                return ('<div id="payment_review">' . $value . '</div>');
                break;
            case 'pending':
                return ('<div id="pending">' . $value . '</div>');
                break;
            case 'pending_payment':
                return ('<div id="pending">' . $value . '</div>');
                break;
            case 'pending_paypal':
                return ('<div id="pending">' . $value . '</div>');
                break;
            case 'processing':
                return ('<div id="processing">' . $value . '</div>');
                break;
            case 'pending_barclaycardsmartpaycw':
                return ('<div id="pending">' . $value . '</div>');
                break;
            case 'pending_paypal':
                return ('<div id="pending">' . $value . '</div>');
                break;
            case 'pending_paypal':
                return ('<div id="pending">' . $value . '</div>');
                break;
            case 'fraud':
                return ('<div id="fraud">' . $value . '</div>');
                break;
            default:
                return ('<div id="default">' . $value . '</div>');
                break;
        }
    }

}
