<?php

class Biotique_Banner_Block_Adminhtml_Prodbanner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	public function getRowUrl($item)
	{
		return $this->getUrl('*/prodbanner/edit', array('prodbanner_id' => $item->getId()));
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('banner/prodbanner')->getCollection();

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('title', array(
			'type' => 'text',
			'index' => 'title',
			'header' => $this->__('Slider Title')
		));

		$this->addColumn('subtitle', array(
			'type' => 'text',
			'index' => 'subtitle',
			'header' => $this->__('Slider Link')
		));

		$this->addColumn('category_id', array(
			'type' => 'text',
			'index' => 'category_id',
			'header' => $this->__('Category'),
			'renderer'  => 'Biotique_Banner_Block_Adminhtml_Template_Category',
		));

		/* $this->addColumn('Parent Inherit', array(
			'header'=> $this->__('Parent Inherit'),
			'index' => 'inherit',
			'renderer'  => 'Biotique_Banner_Block_Adminhtml_Template_Parent',
			'filter' => false
		)); */

		$this->addColumn('image', array(
            'header' => $this->__('Image'),
            'align' => 'left',
            'index' => 'image',
            'width'     => '70',
            'renderer' => 'Biotique_Banner_Block_Adminhtml_Template_Image',
            'sortable' => false,
            'filter' => false
        ));

		return $this;
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('prodbanner_id');
		$this->getMassactionBlock()->setformFieldName('prodbanner_ids');

		$this->getMassactionBlock()->addItem('delete_event', array(
			'label' => Mage::helper('banner')->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('banner')->__('Are you sure you want to delete banners?')
		));

		return $this;
	}
}