<?php

class Biotique_Banner_Adminhtml_ProdbannerController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('biotique/banner');

        $this->_addContent(
            $this->getLayout()->createBlock('banner/adminhtml_prodbanner')
        );

        return $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        if($prodbannerId = $this->getRequest()->getParam('prodbanner_id')){
            Mage::register('current_slide', Mage::getModel('banner/prodbanner')->load($prodbannerId));
        }

        $this->loadLayout();
        $this->_setActiveMenu('biotique/banner');

        $this->_addContent(
            $this->getLayout()->createBlock('banner/adminhtml_prodbanner_edit')
        );

        return $this->renderLayout();
    }

    public function saveAction()
    {
        $eventId = $this->getRequest()->getParam('prodbanner_id');
        $eventModel = Mage::getModel('banner/prodbanner')->load($eventId);

        if ( $data = $this->getRequest()->getPost() ) {
            if(isset($_FILES['prodbanner_image']['name']) and (file_exists($_FILES['prodbanner_image']['tmp_name']))) {
                try {
                    $path = Mage::getBaseDir('media') . DS .'banners'. DS;
                    $ext = pathinfo($_FILES['prodbanner_image']['name'], PATHINFO_EXTENSION);
                    $file_name = 'prod-'. time().'.'.$ext;

                    $uploader = new Varien_File_Uploader('prodbanner_image');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','png')); // or pdf or anything
                  
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);                   
                    $uploader->save($path, $file_name);
                    
                    $data['image'] = $file_name;

                    if(!empty($eventModel)){
                        $im_path = $path.$eventModel->getImage();
                        @unlink($im_path);
                    }
                  }catch(Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                  }
            }

            try {
                $eventModel->addData($data)->save();
                Mage::getSingleton('adminhtml/session')->addSuccess( $this->__("Slider saved") );
            }catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        $prodbannerId = $this->getRequest()->getParam('prodbanner_id');
        $prodbannerModel = Mage::getModel('banner/prodbanner')->load($prodbannerId);

        try{
            $prodbannerModel->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('your slide has been deleted'));            
        } catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('_current' => true));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        if($prodbanner_ids = $this->getRequest()->getParam('prodbanner_ids')){
            try{
                foreach($prodbanner_ids as $prodbanner_id){
                    $slideModel = Mage::getModel('banner/prodbanner')->load($prodbanner_id);
                    $slideModel->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('%d slides have been deleted', count($prodbanner_ids)));
            } catch( Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        } 
        return $this->_redirect('*/*/index');
    }
}