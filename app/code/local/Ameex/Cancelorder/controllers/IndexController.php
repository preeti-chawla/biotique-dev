<?php 
class Ameex_Cancelorder_IndexController extends Mage_Core_Controller_Front_Action
{
   public function cancelAction ()
   {
    $params = $this->getRequest()->getParams();
     $orderId=$params['id'];
     $order = Mage::getModel('sales/order')->load($orderId);
     $order_status=$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true)->save();
      Mage::getSingleton('core/session')->setSuccessmsg('<div class="success-msg">your order has been canceled</div>');
     $this->_redirectReferer();
    }
}