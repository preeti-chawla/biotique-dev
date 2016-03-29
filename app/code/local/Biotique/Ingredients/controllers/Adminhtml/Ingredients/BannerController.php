<?php

class Biotique_Ingredients_Adminhtml_Ingredients_BannerController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {

        $this->loadLayout();
        $this->_setActiveMenu('biotique_ingredients');

        $this->_addContent(
            $this->getLayout()->createBlock('biotique_ingredients/adminhtml_banner')
        );

        return $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        if($bannerId = $this->getRequest()->getParam('banner_id')){
            Mage::register('current_banner', Mage::getModel('biotique_ingredients/banner')->load($bannerId));
        }

        $this->loadLayout();
        $this->_setActiveMenu('biotique_ingredients');

        $this->_addContent(
            $this->getLayout()->createBlock('biotique_ingredients/adminhtml_banner_edit')
        );

        return $this->renderLayout();
    }

    public function saveAction()
    {
        $eventId = $this->getRequest()->getParam('banner_id');
        $eventModel = Mage::getModel('biotique_ingredients/banner')->load($eventId);

        if ( $data = $this->getRequest()->getPost() ) {
            if(isset($_FILES['small_image']['name']) and (file_exists($_FILES['small_image']['tmp_name']))) {
                try {
                    $path = Mage::getBaseDir('media') . DS .'ingredients'. DS;
                    $ext = pathinfo($_FILES['small_image']['name'], PATHINFO_EXTENSION);
                    $file_name = 'ingredient-small-'. time().'.'.$ext;

                    $uploader = new Varien_File_Uploader('small_image');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','png')); // or pdf or anything
                  
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);                   
                    $uploader->save($path, $file_name);
                    
                    $data['small_image'] = $file_name;

                    if(!empty($eventModel)){
                        $im_path = $path.$eventModel->getImage();
                        @unlink($im_path);
                    }
                  }catch(Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                  }
            }

            if(isset($_FILES['large_image']['name']) and (file_exists($_FILES['large_image']['tmp_name']))) {
                try {
                    $path = Mage::getBaseDir('media') . DS .'ingredients'. DS;
                    $ext = pathinfo($_FILES['large_image']['name'], PATHINFO_EXTENSION);
                    $file_name = 'ingredient-large-'. time().'.'.$ext;

                    $uploader = new Varien_File_Uploader('large_image');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','png')); // or pdf or anything
                  
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);                   
                    $uploader->save($path, $file_name);
                    
                    $data['large_image'] = $file_name;

                    if(!empty($eventModel)){
                        $im_path = $path.$eventModel->getImage();
                        @unlink($im_path);
                    }
                  }catch(Exception $e) {
                        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                  }
            }
            
            $data['alias'] = Mage::helper('biotique_ingredients')->getOptionText($data['ingredient_id']);

            try {
                $eventModel->addData($data)->save();
                Mage::getSingleton('adminhtml/session')->addSuccess( $this->__("Banner saved") );
            }catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        $bannerId = $this->getRequest()->getParam('banner_id');
        $bannerModel = Mage::getModel('biotique_ingredients/banner')->load($bannerId);

        try{
            $bannerModel->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('your banner has been deleted'));            
        } catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('_current' => true));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        if($banner_ids = $this->getRequest()->getParam('banner_ids')){
            try{
                foreach($banner_ids as $banner_id){
                    $slideModel = Mage::getModel('biotique_ingredients/banner')->load($banner_id);
                    $slideModel->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('%d banners have been deleted', count($banner_ids)));
            } catch( Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        } 
        return $this->_redirect('*/*/index');
    }
}