<?php

class Biotique_Sample_Block_Adminhtml_Products_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	public function getRowUrl($item)
	{
		return $this->getUrl('*/sample/edit', array('sample_id' => $item->getId()));
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('sample/products')->getCollection();

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('name', array(
			'type' => 'text',
			'index' => 'name',
			'header' => $this->__('Product Title')
		));


		$this->addColumn('Slider Status', array(
			'header'=> $this->__('Slider Status'),
			'index' => 'status',
			'renderer'  => 'Biotique_Sample_Block_Adminhtml_Template_Status',
			'filter' => false
		));

		$this->addColumn('image', array(
            'header' => $this->__('Image'),
            'align' => 'left',
            'index' => 'image',
            'width'     => '70',
            'renderer' => 'Biotique_Sample_Block_Adminhtml_Template_Image',
            'sortable' => false,
            'filter' => false
        ));

		return $this;
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('sample_id');
		$this->getMassactionBlock()->setformFieldName('sample_ids');

		$this->getMassactionBlock()->addItem('delete_event', array(
			'label' => Mage::helper('sample')->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('sample')->__('Are you sure you want to delete samples?')
		));

		return $this;
	}
}