<?php

class Biotique_Concerns_Adminhtml_Concerns_MatchController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('biotique_concerns');

        $this->_addContent(
            $this->getLayout()->createBlock('biotique_concerns/adminhtml_match')
        );

        return $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        if($concernId = $this->getRequest()->getParam('concern_id')){
            Mage::register('current_concern', Mage::getModel('biotique_concerns/match')->load($concernId));
        }

        $this->loadLayout();
        $this->_setActiveMenu('biotique_concerns');

        $this->_addContent(
            $this->getLayout()->createBlock('biotique_concerns/adminhtml_match_edit')
        );

        return $this->renderLayout();
    }

    public function saveAction()
    {
        $eventId = $this->getRequest()->getParam('concern_id');         // different from concern_ids
        $eventModel = Mage::getModel('biotique_concerns/match')->load($eventId);

        if($data = $this->getRequest()->getPost() ) {

            $data['concern_ids'] = @serialize($data['concern_ids']);

            try {
                $eventModel->addData($data)->save();
                Mage::getSingleton('adminhtml/session')->addSuccess( $this->__("concern saved") );
            }catch(Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        $concernId = $this->getRequest()->getParam('concern_id');
        $concernModel = Mage::getModel('biotique_concerns/match')->load($concernId);

        try{
            $concernModel->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('your concern has been deleted'));            
        } catch(Exception $e){
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('_current' => true));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        if($concern_ids = $this->getRequest()->getParam('concern_ids')){
            try{
                foreach($concern_ids as $concern_id){
                    $slideModel = Mage::getModel('biotique_concerns/match')->load($concern_id);
                    $slideModel->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('%d concerns have been deleted', count($concern_ids)));
            } catch( Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        } 
        return $this->_redirect('*/*/index');
    }
}