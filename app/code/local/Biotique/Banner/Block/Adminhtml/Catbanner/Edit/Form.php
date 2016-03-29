<?php

class Biotique_Banner_Block_Adminhtml_Catbanner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

	// gets executed after _prepareForm
	protected function _initFormValues()
	{
		if($catbannerId = Mage::registry('current_slide')){
			$data = $catbannerId->getData();
			$data['thumbnail_url'] = $data['image'];
			$this->getForm()->setValues($data);
		}

		// data preserving when failing
		if($data = Mage::getSingleton('adminhtml/session')->getData('catbanner_form_data', true)){		// get data and clear form
			$this->getForm()->setValues($data);
		}
	}


	protected function _prepareForm()
	{
		// initi value
		$inherit = array(
			array('value'=>'1','label'=>'Yes'),
			array('value'=>'2','label'=>'No')
		);

		// get categories
		// later make it sorter
		$catarr = array();
		$cat = Mage::getModel('catalog/category')->load('2');
		$subcats = $cat->getChildren();
		foreach(explode(',',$subcats) as $subCatid){
            $_category = Mage::getModel('catalog/category')->load($subCatid);
            $catarr[$_category->getId()] = array('name' => $_category->getName());
	
			foreach ($catarr as $key => $value) {
				$cat_1 = Mage::getModel('catalog/category')->load($key);
				$subcats_1 = $cat_1->getChildren();
				$subarr = array();
				foreach(explode(',',$subcats_1) as $subCatid){
		            $_scategory = Mage::getModel('catalog/category')->load($subCatid);
		            $subarr[$_scategory->getId()] = $_scategory->getName();
				}
				asort($subarr);
				$catarr[$key]['children'] = $subarr;
			}
		}
		asort($catarr);

		$selarr = array();
		foreach($catarr as $key => $value) {
			$selarr[$key] = $value['name'];
			if(isset($catarr[$key]['children']) && !empty($catarr[$key]['children'])){
				foreach ($catarr[$key]['children'] as $k2 => $v2) {
					$selarr[$k2] = '-- '.$v2;
				}
			}
		}

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
			'legend' => Mage::helper('banner')->__('Category Form'),
			'class' => 'fieldset-wide'
		));

		$fieldset->addField('title', 'text', array(
			'name' => 'title',
			'label' => Mage::helper('banner')->__('Banner Title'),
			'title' => Mage::helper('banner')->__('Banner Title'),
			'required' => true
		));

		$fieldset->addField('subtitle', 'text', array(
			'name' => 'subtitle',
			'label' => Mage::helper('banner')->__('Banner Tag'),
			'title' => Mage::helper('banner')->__('Banner Tag'),
			'required' => true
		));

		$fieldset->addField('category_id', 'select', array(
			'name' => 'category_id',
			'label' => Mage::helper('banner')->__('Category'),
			'title' => Mage::helper('banner')->__('Category'),
			'values' => $selarr,
        ));


		if($currSlide = Mage::registry('current_slide')){
			$fieldset->addType('thumbnail','Biotique_Banner_Lib_Varien_Data_Form_Element_Thumbnail');
			$fieldset->addField('thumbnail_url', 'thumbnail', array(
				'label'     => Mage::helper('banner')->__('Current Header'),
				'name'      => 'thumbnail_url',
				'style'   => "display:none;",
			));
		}

		$fieldset->addField('image', 'file', array(
			'name' => 'catbanner_image',
			'label' => Mage::helper('banner')->__('Banner Image'),
			'title' => Mage::helper('banner')->__('Banner Image'),
			'after_element_html' => '<small>1280X147 image</small>'
		));

		$fieldset->addField('inherit', 'radios', array(
			'name' => 'inherit',
			'label' => Mage::helper('banner')->__('Inherit Parent Image'),
			'title' => Mage::helper('banner')->__('Inherit Parent Image'),
			'values' => $inherit
		));

        $form->setUseContainer(true);
        $this->setForm($form);
	}
}