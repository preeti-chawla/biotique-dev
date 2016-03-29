<?php
class Form_SimpleContact_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        //Get current layout state
        $this->loadLayout();   
        $block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'form.simple_contact',
            array(
                'template' => 'form/simple_contact.phtml'
            )
        );
        $this->getLayout()->getBlock('content')->append($block);
        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
    }
 
    public function sendemailAction()
    {
        //Fetch submited params
        $params = $this->getRequest()->getParams();
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write'); 
		$name=$_POST['name'];
		$hotels_no=$_POST['hotels_no'];
		$guests_no=$_POST['guests_no'];
		$brand_amenties=$_POST['brand_amenties'];
		$room_occupany=$_POST['room_occupany'];
		$query=$_POST['query'];
		$contact_name=$_POST['contact_name'];
		$designation=$_POST['designation'];
		$contact_no=$_POST['contact_no'];
		$website=$_POST['website'];
		$address=$_POST['address'];
		$email=$_POST['email'];
		echo "INSERT INTO `query_hotel` (`email`, `hotel_name`, `hotels_no`, `guests_no`, `brand_amenties`, `room_occupany`, `query`, `contact_name`, `designation`, `contact_no`, `website`, `address`) 
		VALUES ('$email','$name',  '$hotels_no','$guests_no','$brand_amenties','$room_occupany','$query','$contact_name','$designation','$contact_no','$website','$address')";
		$sql = "INSERT INTO `query_hotel` (`email`, `hotel_name`, `hotels_no`, `guests_no`, `brand_amenties`, `room_occupany`, `query`, `contact_name`, `designation`, `contact_no`, `website`, `address`) 
		VALUES ('$email','$name',  '$hotels_no','$guests_no','$brand_amenties','$room_occupany','$query','$contact_name','$designation','$contact_no','$website','$address')";
		$connection->query($sql);
	echo "1";
	EXIT();
        $mail = new Zend_Mail();
        $mail->setBodyText($params['comment']);
        $mail->setFrom($params['email'], $params['name']);
        $mail->addTo('somebody_else@example.com', 'Some Recipient');
        $mail->setSubject('Test Inchoo_SimpleContact Module for Magento');
        try {
            $mail->send();
        }        
        catch(Exception $ex) {
            Mage::getSingleton('core/session')->addError('Unable to send email. Sample of a custom notification error from Inchoo_SimpleContact.');
 
        }
        //Redirect back to index action of (this) inchoo-simplecontact controller
        $this->_redirect('form-simplecontact/');
    }
	
	public function inTouchAction()
    {
        //Fetch submited params
        $params = $this->getRequest()->getParams();
		$email_id=$_POST['email_id'];
		$mobile_no=$_POST['mobile_no'];
		$address=$_POST['address'];
		$mail = new Zend_Mail();
        $mail->setBodyText($params['comment']);
        $mail->setFrom($params['email_id'], $params['mobile_no']);
        $mail->addTo('somebody_else@example.com', 'Some Recipient');
        $mail->setSubject('Be in touch');
        try {
            $mail->send();
			return 1;
        }        
        catch(Exception $ex) {
            Mage::getSingleton('core/session')->addError('Unable to send email. Sample of a custom notification error from Inchoo_SimpleContact.');
			return 0;
        }
    }
	
	
	
}
?>