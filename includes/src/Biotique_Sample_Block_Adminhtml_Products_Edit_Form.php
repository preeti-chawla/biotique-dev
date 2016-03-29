<?php

class Biotique_Sample_Block_Adminhtml_Products_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

	// gets executed after _prepareForm
	protected function _initFormValues()
	{
		if($productId = Mage::registry('current_sample')){
			$data = $productId->getData();
			$data['thumbnail_url'] = $data['image'];
			$this->getForm()->setValues($data);
		}

		// data preserving when failing
		if($data = Mage::getSingleton('adminhtml/session')->getData('product_form_data', true)){		// get data and clear form
			$this->getForm()->setValues($data);
		}
	}


	protected function _prepareForm()
	{
		$inherit = array(
			array('value'=>'1','label'=>'Active'),
			array('value'=>'2','label'=>'Inactive')
		);

		// form
		$form = new Varien_Data_Form(
			array(
				'id' => 'edit_form',
				'action' => $this->getData('action'),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
			)
		);

		// varien data form element
		$fieldset = $form->addFieldset('base_fieldset', array(
			'legend' => Mage::helper('sample')->__('Category Form'),
			'class' => 'fieldset-wide'
		));

		$fieldset->addField('name', 'text', array(
			'name' => 'name',
			'label' => Mage::helper('sample')->__('Sample Title'),
			'title' => Mage::helper('sample')->__('Sample Title'),
			'required' => true
		));
		
		$fieldset->addField('description', 'textarea', array(
			'name' => 'description',
			'label' => Mage::helper('sample')->__('Sample Description'),
			'title' => Mage::helper('sample')->__('Sample Description'),
			'required' => true
		));
		
		$fieldset->addField('image', 'file', array(
			'name' => 'sample_image',
			'label' => Mage::helper('sample')->__('Sample Image'),
			'title' => Mage::helper('sample')->__('Sample Image'),
			'after_element_html' => '<small>500*500 image</small>'
		));

		if($currSlide = Mage::registry('current_sample')){
			$fieldset->addType('thumbnail','Biotique_Sample_Lib_Varien_Data_Form_Element_Thumbnail');
			$fieldset->addField('thumbnail_url', 'thumbnail', array(
				'label'     => Mage::helper('sample')->__('Current Sample'),
				'name'      => 'thumbnail_url',
				'style'   => "display:none;",
			));
		}

		$fieldset->addField('status', 'radios', array(
			'name' => 'status',
			'label' => Mage::helper('sample')->__('Sample Status'),
			'title' => Mage::helper('sample')->__('Sample Status'),
			'values' => $inherit
		));
        $form->setUseContainer(true);
        $this->setForm($form);
	}
}