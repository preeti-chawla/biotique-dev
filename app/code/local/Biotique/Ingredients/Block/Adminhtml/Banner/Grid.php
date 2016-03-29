<?php

class Biotique_Ingredients_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	public function getRowUrl($item)
	{
		return $this->getUrl('*/ingredients_banner/edit', array('banner_id' => $item->getId()));
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('biotique_ingredients/banner')->getCollection();

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('alias', array(
			'type' => 'text',
			'index' => 'alias',
			'header' => $this->__('Name')
		));


		$this->addColumn('small_image', array(
            'header' => $this->__('Icon Image'),
            'align' => 'left',
            'index' => 'small_image',
            'width'     => '70',
            'renderer' => 'Biotique_Ingredients_Block_Adminhtml_Template_Image',
            'sortable' => false,
            'filter' => false
        ));

		$this->addColumn('large_image', array(
            'header' => $this->__('Large Image'),
            'align' => 'left',
            'index' => 'large_image',
            'width'     => '70',
            'renderer' => 'Biotique_Ingredients_Block_Adminhtml_Template_Image',
            'sortable' => false,
            'filter' => false
        ));

		return $this;
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('banner_id');
		$this->getMassactionBlock()->setformFieldName('banner_ids');

		$this->getMassactionBlock()->addItem('delete_event', array(
			'label' => Mage::helper('biotique_ingredients')->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('biotique_ingredients')->__('Are you sure you want to delete banners?')
		));

		return $this;
	}
}