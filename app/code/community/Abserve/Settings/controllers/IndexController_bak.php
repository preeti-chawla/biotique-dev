<?php
class Abserve_Settings_IndexController extends Mage_Core_Controller_Front_Action{

	public function IndexAction(){
		$this->loadLayout();
		$this->renderLayout();
	}

    public function IngreAction(){
        $this->loadLayout();
        $this->renderLayout();
    }

    public function IngredientsAction(){
        $this->loadLayout();
        $this->renderLayout();
    }

    public function HotelspaAction(){
         // *********** Insert Data ***************** //
        $connection_insert = Mage::getSingleton('core/resource')->getConnection('core_write'); 
        $connection_insert->beginTransaction(); 
        $__fields = array(
                        'hotel_name' => $_POST['hotel_name'], 
                        'no_hotel' => $_POST['no_hotels'], 
                        'no_rooms' => $_POST['no_rooms'], 
                        'brand'  => $_POST['brand'],
                        'occupancy' => $_POST['occupancy'],        
                        'query' => $_POST['query'],       
                        'person_name' => $_POST['person_name'],     
                        'designation' => $_POST['designation'],     
                        'contact_no' => $_POST['contact_no'],    
                        'email'   => $_POST['email'],     
                        'website' => $_POST['website'],     
                        'address' => $_POST['address']
                    );
        $connection_insert->insert('hotel_spa', $__fields); 
        $connection_insert->commit();
        Mage::getSingleton('core/session')->addSuccess('Thank you for filling the form,Our team will response soon.');
         $this->_redirect('hotel-spa');
        /*$this->loadLayout();
        $this->renderLayout();*/
    }
    public function CorporategiftAction(){
         // *********** Insert Data ***************** //
        $connection_insert = Mage::getSingleton('core/resource')->getConnection('core_write'); 
        $connection_insert->beginTransaction(); 
     
        $__fields = array(
                        'name' => $_POST['name'], 
                        'organization' => $_POST['organization'], 
                        'contact_no' => $_POST['contact_no'], 
                        'email'  => $_POST['email'],
                        'number_gift' => $_POST['number_gift'],        
                        'p_range' => $_POST['p_range'],       
                        'occasion' => $_POST['occasion'],     
                        'address' => $_POST['address'],     
                    );
        $connection_insert->insert('corporate_gift', $__fields); 
        $connection_insert->commit();
         Mage::getSingleton('core/session')->addSuccess('Thank you for filling the form,Our team will response soon.');
         $this->_redirect('corporate-gifting');
        /*$this->loadLayout();
        $this->renderLayout();*/
    }

    public function FormsubmitAction(){
        echo "working";
        print_r($_POST);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $comment = $_POST['comment'];

        $connection_insert = Mage::getSingleton('core/resource')->getConnection('core_write'); 
        $connection_insert->beginTransaction(); 
        $__fields = array(
                        'name_block' => $_POST['name'], 
                        'email_block' => $_POST['email'],     
                        'telephone_block' => $_POST['telephone'],    
                        'comment_block'   => $_POST['comment'],     
                    );
        $connection_insert->insert('contact_form', $__fields); 
        $connection_insert->commit();
        Mage::getSingleton('core/session')->addSuccess('Thank you to contact us,Our team will respons soon.');
        $this->_redirect('contact-us');


    }


    public function CformAction(){

         // *********** Insert Data ***************** //
        $connection_insert = Mage::getSingleton('core/resource')->getConnection('core_write'); 
        $connection_insert->beginTransaction(); 
        
        $__fields = array(
                        'name_block' => $_POST['name_block'], 
                        'email_block' => $_POST['email_block'], 
                        'telephone_block' => $_POST['telephone_block'], 
                        'comment_block' => $_POST['comment_block'],        
                        'type' => $_POST['type'],       
                        'created' => date("Y-m-d h:i:s"),
   
                    );
        $connection_insert->insert('contact_form', $__fields); 
        $connection_insert->commit();
         $this->_redirect('settings/');
        /*$this->loadLayout();
        $this->renderLayout();*/
    }
    public function GetproductAction(){
        $attribute_name = $_POST['name'];
        $attribute_id = $_POST['id'];

        /*$attribute_name = 'Almond';
        $attribute_id = 98;*/

        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->addAttributeToSelect('name','item_ingregident');
        $collection->addAttributeToFilter('item_ingregident', array('eq' => $attribute_id));
        $count = 0;
        $output = '';
        $output .='<div class="customPopup">
        <a class="closeCtn" onclick="closepopup()" href="#"><i class="fa fa-times"></i></a>      
        <div class="">
           <div class="popupTop">
              <h5>Ingredients</h5>
           </div>
           <div class="popupMiddleContent">';
        $output .= '<div class="layout">
    <div class="filtercontent-wrap">
        <div id="filter1" class="filterTabContent" style="display: block;">         
            <div class="filterlistRow">
            <ul class="filterList">';
        foreach ($collection as $_product) {
            $count++;
            $product_id = $_product->getId();
            $product_name = $_product->getName();



            $obj = Mage::getModel('catalog/product');
            $_product1 = $obj->load($product_id);
            $stocklevel = (int)Mage::getModel('cataloginventory/stock_item')
                ->loadByProduct($_product1)->getQty();
            $product_price =  $_product1->getPrice();
            $product_imgurl =  $_product1->getImageUrl();

            /*$stock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($_product);
            $product_quanity = round($stock->getQty());
            $formattedPrice = Mage::helper('core')->currency($product_finalprice, true, false);
            if($_product->getShortDescription()){
                $product_description = $_product->getShortDescription();
            }else{
                $product_description = $_product->getDescription();
            }
            $product_carturl = $_product->getProductUrl().'?options=cart';
            $category_ids = $_product->getCategoryIds();
            $_imgSize = 100;
            $img = Mage::helper('catalog/image')->init($_product, 'small_image')->keepFrame(false)->resize($_imgSize,$_imgSize);*/
            if($_product1->isSaleable()){
                $output .= '<li>
                    <div class="filterbox popup">
                      <h4>'.$product_name.'</h4>
                      <img src="'. $product_imgurl.'" />
                      <h2>'. $product_price.'</h2>                  
                    </div>
                  </li>';
            }
            
        }
        $output .='</ul>
            </div>
        </div>
    </div>
</div>';
$output.='</div>
        </div>      
     </div>';
echo $output;
    }


    public function sendemailoneAction(){
        $params = $this->getRequest()->getParams();
        $username = $params['name_block1'];
        $email = $params['email_block1'];
        $telephone = $params['telephone_block1'];
        $comment = $params['comment_block1'];
        $processedTemplate = '<table> 
        <tr> <td> Username </td> <td> '.$username.' </td> </tr>
        <tr> <td> Email </td> <td> '.$email.' </td> </tr>
        <tr> <td> Telephone </td> <td> '.$telephone.' </td> </tr>
        <tr> <td> Comment </td> <td> '.$comment.' </td> </tr>
        </table>';
        print_r($processedTemplate);
        $this->_redirect('settings/');
        /*$from_email = Mage::getStoreConfig('trans_email/ident_general/email');  
        $to_mail = 'jkpvino92@gmail.com';
        $subject = 'Contact Information'; 
        mail($to_mail, $subject, $processedTemplate, $from_email);

        $mail = new Zend_Mail();
        $mail->setBodyText($processedTemplate);
        $mail->setFrom($email, $username);
        $mail->addTo('jkpvino92@gmail.com', 'Contact Information');
        $mail->setSubject('Contact Form Submit');
        try {
            $mail->send();
        }        
        catch(Exception $ex) {
            Mage::getSingleton('core/session')->addError('Unable to send email. Sample of a custom notification error from Inchoo_SimpleContact.');
 
        } */

        
        /*$mail = Mage::getModel('core/email')
            ->setToName($username)
            ->setToEmail($to_mail)
            ->setBody($processedTemplate)
            ->setSubject('Subject : Contact Information')
            ->setFromEmail($email)
            ->setFromName('Contact Form Submit')
            ->setType('html');
        $mail->send();*/
        //$this->_redirect('settings/');
    }


    public function sendemailtwoAction(){
        $params = $this->getRequest()->getParams();
        $username = $params['name_block2'];
        $email = $params['email_block2'];
        $telephone = $params['telephone_block2'];
        $comment = $params['comment_block2'];
        $processedTemplate = '<table> 
        <tr> <td> Username </td> <td> '.$username.' </td> </tr>
        <tr> <td> Email </td> <td> '.$email.' </td> </tr>
        <tr> <td> Telephone </td> <td> '.$telephone.' </td> </tr>
        <tr> <td> Comment </td> <td> '.$comment.' </td> </tr>
        </table>';
        print_r($processedTemplate);
        //$this->_redirect('settings/');
    }

    public function sendemailthreeAction(){
        $params = $this->getRequest()->getParams();
        $username = $params['name_block3'];
        $email = $params['email_block3'];
        $telephone = $params['telephone_block3'];
        $comment = $params['comment_block3'];
        $processedTemplate = '<table> 
        <tr> <td> Username </td> <td> '.$username.' </td> </tr>
        <tr> <td> Email </td> <td> '.$email.' </td> </tr>
        <tr> <td> Telephone </td> <td> '.$telephone.' </td> </tr>
        <tr> <td> Comment </td> <td> '.$comment.' </td> </tr>
        </table>';
        print_r($processedTemplate);
        //$this->_redirect('settings/');

        /*$emailTemplate  = Mage::getModel('core/email_template')
                        ->loadDefault('custom_email_template1');  
        $emailTemplateVariables = array();
        $emailTemplateVariables['myvar1'] = 'Branko';
        $emailTemplateVariables['myvar2'] = 'Ajzele';
        $emailTemplateVariables['myvar3'] = 'ActiveCodeline';
        $processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
        print_r($processedTemplate);
        $emailTemplate->send('vinothkumarjeyaraman@gmail.com','Vinoth Kumar', $emailTemplateVariables);*/
    }

	public function sendemailAction()
    {
        //Fetch submited params
        $params = $this->getRequest()->getParams();
        print_r($params);
        echo $tomail_third = Mage::getStoreConfig('settings/helpline/contactmailthird'); 
        exit();


        /*
        $from_email = Mage::getStoreConfig('trans_email/ident_general/email');		
        $__fields = array();
		$mail = Mage::getModel('core/email')
			->setToName($customername)
			->setToEmail($customer_email)
			->setBody($processedTemplate)
			->setSubject('Subject : Order two step Verification')
			->setFromEmail($from_email)
			->setFromName('Oss Two Step verification')
			->setType('html');
		$mail->send();
        */
 
        $mail = new Zend_Mail();
        $mail->setBodyText($params['comment']);
        $mail->setFrom($params['email'], $params['name']);
        $mail->addTo('vinothabserve@gmail.com', 'Some Recipient');
        $mail->setSubject('Test Inchoo_SimpleContact Module for Magento');
        try {
            $mail->send();
        }        
        catch(Exception $ex) {
            Mage::getSingleton('core/session')->addError('Unable to send email. Sample of a custom notification error from Inchoo_SimpleContact.');
 
        } 
        //Redirect back to index action of (this) inchoo-simplecontact controller
        $this->_redirect('settings/');
    }
}