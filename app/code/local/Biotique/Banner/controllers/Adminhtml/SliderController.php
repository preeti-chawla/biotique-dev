<?php

class Biotique_Banner_Adminhtml_SliderController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('biotique/banner');

        $this->_addContent(
            $this->getLayout()->createBlock('banner/adminhtml_slider')
        );

        return $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        if($sliderId = $this->getRequest()->getParam('slider_id')){
            Mage::register('current_slide', Mage::getModel('banner/slider')->load($sliderId));
        }

        $this->loadLayout();
        $this->_setActiveMenu('biotique/banner');

        $this->_addContent(
            $this->getLayout()->createBlock('banner/adminhtml_slider_edit')
        );

        return $this->renderLayout();
    }

    public function saveAction()
    {
        $eventId = $this->getRequest()->getParam('slider_id');
        $eventModel = Mage::getModel('banner/slider')->load($eventId);

        if ( $data = $this->getRequest()->getPost() ) {
            if(isset($_FILES['slider_image']['name']) and (file_exists($_FILES['slider_image']['tmp_name']))) {
                try {
                    $path = Mage::getBaseDir('media') . DS .'banners'. DS;
                    $ext = pathinfo($_FILES['slider_image']['name'], PATHINFO_EXTENSION);
                    $file_name = 'home-'. time().'.'.$ext;

                    $uploader = new Varien_File_Uploader('slider_image');
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
        $sliderId = $this->getRequest()->getParam('slider_id');
        $sliderModel = Mage::getModel('banner/slider')->load($sliderId);

        try{
            $sliderModel->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('your slide has been deleted'));            
        } catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('_current' => true));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        if($slider_ids = $this->getRequest()->getParam('slider_ids')){
            try{
                foreach($slider_ids as $slider_id){
                    $slideModel = Mage::getModel('banner/slider')->load($slider_id);
                    $slideModel->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('%d slides have been deleted', count($slider_ids)));
            } catch( Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        } 
        return $this->_redirect('*/*/index');
    }
}