<?php

class Biotique_Banner_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	public function getRowUrl($item)
	{
		return $this->getUrl('*/slider/edit', array('slider_id' => $item->getId()));
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('banner/slider')->getCollection();

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('name', array(
			'type' => 'text',
			'index' => 'name',
			'header' => $this->__('Name')
		));

		$this->addColumn('slider_link', array(
			'type' => 'text',
			'index' => 'slider_link',
			'header' => $this->__('Slider Link')
		));

		$this->addColumn('slider_order', array(
			'type' => 'text',
			'index' => 'slider_order',
			'header' => $this->__('Slider Order')
		));

		$this->addColumn('slider_order', array(
			'type' => 'text',
			'index' => 'slider_order',
			'header' => $this->__('Slider Order'),
			'filter' => false
		));

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
		$this->setMassactionIdField('slider_id');
		$this->getMassactionBlock()->setformFieldName('slider_ids');

		$this->getMassactionBlock()->addItem('delete_event', array(
			'label' => Mage::helper('banner')->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('banner')->__('Are you sure you want to delete slides?')
		));

		return $this;
	}
}