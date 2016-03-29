<?php

class Biotique_Banner_Adminhtml_CatbannerController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('biotique/banner');

        $this->_addContent(
            $this->getLayout()->createBlock('banner/adminhtml_catbanner')
        );

        return $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        if($catbannerId = $this->getRequest()->getParam('catbanner_id')){
            Mage::register('current_slide', Mage::getModel('banner/catbanner')->load($catbannerId));
        }

        $this->loadLayout();
        $this->_setActiveMenu('biotique/banner');

        $this->_addContent(
            $this->getLayout()->createBlock('banner/adminhtml_catbanner_edit')
        );

        return $this->renderLayout();
    }

    public function saveAction()
    {
        $eventId = $this->getRequest()->getParam('catbanner_id');
        $eventModel = Mage::getModel('banner/catbanner')->load($eventId);

        if ( $data = $this->getRequest()->getPost() ) {
            if(isset($_FILES['catbanner_image']['name']) and (file_exists($_FILES['catbanner_image']['tmp_name']))) {
                try {
                    $path = Mage::getBaseDir('media') . DS .'banners'. DS;
                    $ext = pathinfo($_FILES['catbanner_image']['name'], PATHINFO_EXTENSION);
                    $file_name = 'cat-'. time().'.'.$ext;

                    $uploader = new Varien_File_Uploader('catbanner_image');
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
        $catbannerId = $this->getRequest()->getParam('catbanner_id');
        $catbannerModel = Mage::getModel('banner/catbanner')->load($catbannerId);

        try{
            $catbannerModel->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('your slide has been deleted'));            
        } catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('_current' => true));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        if($catbanner_ids = $this->getRequest()->getParam('catbanner_ids')){
            try{
                foreach($catbanner_ids as $catbanner_id){
                    $slideModel = Mage::getModel('banner/catbanner')->load($catbanner_id);
                    $slideModel->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('%d slides have been deleted', count($catbanner_ids)));
            } catch( Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        } 
        return $this->_redirect('*/*/index');
    }
}