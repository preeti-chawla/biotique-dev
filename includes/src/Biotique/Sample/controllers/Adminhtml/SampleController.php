<?php

class Biotique_Sample_Adminhtml_SampleController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('biotique/sample');

        $this->_addContent(
            $this->getLayout()->createBlock('sample/adminhtml_products')
        );

        return $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        if($productsId = $this->getRequest()->getParam('sample_id')){
            Mage::register('current_sample', Mage::getModel('sample/products')->load($productsId));
        }

        $this->loadLayout();
        $this->_setActiveMenu('sample/products');

        $this->_addContent(
            $this->getLayout()->createBlock('sample/adminhtml_products_edit')
        );

        return $this->renderLayout();
    }

    public function saveAction()
    {
        $eventId = $this->getRequest()->getParam('sample_id');
        $eventModel = Mage::getModel('sample/products')->load($eventId);

        if ( $data = $this->getRequest()->getPost() ) {
            if(isset($_FILES['sample_image']['name']) and (file_exists($_FILES['sample_image']['tmp_name']))) {
                try {
                    $path = Mage::getBaseDir('media') . DS .'sample'. DS;
                    $ext = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);
                    $file_name = 'cat-'. time().'.'.$ext;

                    $uploader = new Varien_File_Uploader('sample_image');
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
                Mage::getSingleton('adminhtml/session')->addSuccess( $this->__("Sample saved") );
            }catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        $sampleId = $this->getRequest()->getParam('sample_id');
        $sampleModel = Mage::getModel('sample/products')->load($sampleId);

        try{
            $sampleModel->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('your slide has been deleted'));            
        } catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('_current' => true));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        if($sample_ids = $this->getRequest()->getParam('sample_ids')){
            try{
                foreach($sample_ids as $sample_id){
                    $slideModel = Mage::getModel('sample/products')->load($sample_id);
                    $slideModel->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('%d slides have been deleted', count($sample_ids)));
            } catch( Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        } 
        return $this->_redirect('*/*/index');
    }
}