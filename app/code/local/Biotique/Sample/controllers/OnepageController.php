<?php
/**
*/

require_once 'Mage/Checkout/controllers/OnepageController.php';

class Biotique_Sample_OnepageController extends Mage_Checkout_OnepageController
{
    public function saveSampleAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $quote = $this->getOnepage()->getQuote();
            $sample_arr = $this->getRequest()->getPost('sample');

            if(empty($sample_arr))
                $sample_arr = array();

            $sample_arr = serialize($sample_arr);
            Mage::getSingleton('core/session')->setSampleOrders($sample_arr);

            $result = array();
            $result['goto_section'] = 'billing';

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
}
