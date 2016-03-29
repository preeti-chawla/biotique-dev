<?php

class Biotique_Concerns_Block_Adminhtml_Match_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

	// gets executed after _prepareForm
	protected function _initFormValues()
	{
		if($concernId = Mage::registry('current_concern')){
			$data = $concernId->getData();
			
			$concern_id_arr = unserialize($data['concern_ids']);
			$data['concern_ids'] = is_array($concern_id_arr) ? $concern_id_arr : array();

			$this->getForm()->setValues($data);
		}

		// data preserving when failing
		if($data = Mage::getSingleton('adminhtml/session')->getData('edit_form', true)){		// get data and clear form
			$this->getForm()->setValues($data);
		}
	}


	protected function _prepareForm()
	{
		$cat_arr = Mage::helper('biotique_concerns')->getConcernCategories($this->getRequest()->getParam('concern_id', 0));
		$concern_arr = Mage::helper('biotique_concerns')->getAttribFormat('item_concern');

		$form = new Varien_Data_Form(
			array(
				'id' => 'edit_form',
				'action' => $this->getData('action'),
				'method' => 'post'
			)
		);

		// varien data form element
		$fieldset = $form->addFieldset('base_fieldset', array(
			'legend' => Mage::helper('biotique_ingredients')->__('Assign Concern'),
			'class' => 'fieldset-wide'
		));

		$fieldset->addField('category_id', 'select', array(
			'name' => 'category_id',
			'label' => Mage::helper('banner')->__('Category'),
			'title' => Mage::helper('banner')->__('Category'),
			'values' => $cat_arr
        ));

		$fieldset->addField('concern_ids', 'multiselect', array(
			'name' => 'concern_ids',
			'label' => Mage::helper('banner')->__('Concerns'),
			'title' => Mage::helper('banner')->__('Concerns'),
			'values' => $concern_arr,
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
	}
}