<?php

class Biotique_Ingredients_Block_Adminhtml_Banner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

	// gets executed after _prepareForm
	protected function _initFormValues()
	{
		if($bannerId = Mage::registry('current_banner')){
			$data = $bannerId->getData();
			$data['small_im'] = $data['small_image'];
			$data['large_im'] = $data['large_image'];
			$this->getForm()->setValues($data);
		}

		// data preserving when failing
		if($data = Mage::getSingleton('adminhtml/session')->getData('banner_form_data', true)){		// get data and clear form
			$this->getForm()->setValues($data);
		}
	}


	protected function _prepareForm()
	{

		$ingred_arr = Mage::helper('biotique_ingredients')->item_ingredients();

		$curr_ing = array();
		$collection = Mage::getModel("biotique_ingredients/banner")->getCollection();
 		$collection->getSelect()
     		->reset(Zend_Db_Select::COLUMNS)
     		->columns('ingredient_id');
     	foreach ($collection as $ingr) {
     		$curr_ing[] = $ingr->getIngredientId();
     	}

		if($bannerId = Mage::registry('current_banner')){
			$data = $bannerId->getData();
			if(($key = array_search($data['ingredient_id'], $curr_ing)) !== false) {
			    unset($curr_ing[$key]);
			}
		}

		foreach($curr_ing as $curr_key) {
			if(array_key_exists($curr_key, $ingred_arr)){
				unset($ingred_arr[$curr_key]);
			}
		}

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
			'legend' => Mage::helper('biotique_ingredients')->__('Banner Form'),
			'class' => 'fieldset-wide'
		));


		$fieldset->addField('ingredient_id', 'select', array(
			'name' => 'ingredient_id',
			'label' => Mage::helper('banner')->__('Ingredient'),
			'title' => Mage::helper('banner')->__('Ingredient'),
			'values' => $ingred_arr,
        ));

		$fieldset->addField('description', 'textarea', array(
			'name' => 'description',
			'label' => Mage::helper('biotique_ingredients')->__('Description'),
			'title' => Mage::helper('biotique_ingredients')->__('Description'),
			'required' => false
		));

		$fieldset->addField('small_image', 'file', array(
			'name' => 'small_image',
			'label' => Mage::helper('biotique_ingredients')->__('Banner Icon Image'),
			'title' => Mage::helper('biotique_ingredients')->__('Banner Icon Image'),
			'after_element_html' => '<small>298X174 image</small>'
		));
		if($bannerId = Mage::registry('current_banner')){
			$fieldset->addType('thumbnail','Biotique_Ingredients_Lib_Varien_Data_Form_Element_Thumbnail');
			$fieldset->addField('small_im', 'thumbnail', array(
				'label'     => Mage::helper('biotique_ingredients')->__('Current Image'),
				'name'      => 'small_im',
				'style'   => "display:none;",
			));
		}

		$fieldset->addField('large_image', 'file', array(
			'name' => 'large_image',
			'label' => Mage::helper('biotique_ingredients')->__('Banner Large Image'),
			'title' => Mage::helper('biotique_ingredients')->__('Banner Large Image'),
			'after_element_html' => '<small>1024X240 image</small>'
		));
		if($bannerId = Mage::registry('current_banner')){
			$fieldset->addType('thumbnail','Biotique_Ingredients_Lib_Varien_Data_Form_Element_Thumbnail');
			$fieldset->addField('large_im', 'thumbnail', array(
				'label'     => Mage::helper('biotique_ingredients')->__('Current Image'),
				'name'      => 'large_im',
				'style'   => "display:none;",
			));
		}

        $form->setUseContainer(true);
        $this->setForm($form);
	}
}