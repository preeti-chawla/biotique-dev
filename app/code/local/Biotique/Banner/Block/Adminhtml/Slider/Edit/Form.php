<?php

class Biotique_Banner_Block_Adminhtml_Slider_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

	// gets executed after _prepareForm
	protected function _initFormValues()
	{
		if($sliderId = Mage::registry('current_slide')){
			$data = $sliderId->getData();
			$data['thumbnail_url'] = $data['image'];
			$this->getForm()->setValues($data);
		}

		// data preserving when failing
		if($data = Mage::getSingleton('adminhtml/session')->getData('slider_form_data', true)){		// get data and clear form
			$this->getForm()->setValues($data);
		}
	}


	protected function _prepareForm()
	{

		/*$scollection = Mage::getModel('banner/slider')
			->getCollection()
			->setOrder('slider_order', 'ASC');;

		$order_arr = array();
		foreach($scollection as $item){
			$order_arr[$item->getSliderOrder()] = $item->getSliderOrder().'. '.$item->getName();
		}
		$order_arr[$total_order = (count($order_arr)+1)] = $total_order.'. Bottom most';*/

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
			'legend' => Mage::helper('banner')->__('Banner Form'),
			'class' => 'fieldset-wide'
		));

		$fieldset->addField('name', 'text', array(
			'name' => 'name',
			'label' => Mage::helper('banner')->__('Slider Title'),
			'title' => Mage::helper('banner')->__('Slider Title'),
			'required' => true
		));

		$fieldset->addField('slider_link', 'text', array(
			'name' => 'slider_link',
			'label' => Mage::helper('banner')->__('Slider Link'),
			'title' => Mage::helper('banner')->__('Slider Link'),
			'required' => true
		));

		$fieldset->addField('slider_order', 'text', array(
			'name' => 'slider_order',
			'label' => Mage::helper('banner')->__('Slider Order'),
			'title' => Mage::helper('banner')->__('Slider Order'),
			'maxlength' => 2,
			'class' => 'validate-digits'
		));


		if($sliderId = Mage::registry('current_slide')){
			$fieldset->addType('thumbnail','Biotique_Banner_Lib_Varien_Data_Form_Element_Thumbnail');
			$fieldset->addField('thumbnail_url', 'thumbnail', array(
				'label'     => Mage::helper('banner')->__('Current Slider'),
				'name'      => 'thumbnail_url',
				'style'   => "display:none;",
			));
		}

		$fieldset->addField('image', 'file', array(
			'name' => 'slider_image',
			'label' => Mage::helper('banner')->__('Slider Image'),
			'title' => Mage::helper('banner')->__('Slider Image'),
			'after_element_html' => '<small>1280X480 image</small>'
		));

        $form->setUseContainer(true);
        $this->setForm($form);
	}
}