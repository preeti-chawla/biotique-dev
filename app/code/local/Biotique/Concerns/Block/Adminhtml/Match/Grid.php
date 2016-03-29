<?php

class Biotique_Concerns_Block_Adminhtml_Match_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	public function getRowUrl($item)
	{
		return $this->getUrl('*/concerns_match/edit', array('concern_id' => $item->getId()));
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('biotique_concerns/match')->getCollection();

		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('category_id', array(
			'type' => 'text',
			'index' => 'category_id',
			'header' => $this->__('Category'),
            'sortable' => false,
            'filter' => false,
			'renderer'  => 'Biotique_Concerns_Block_Adminhtml_Template_Category',
		));

		$this->addColumn('concern_ids', array(
			'type' => 'text',
			'index' => 'concern_ids',
			'header' => $this->__('Concerns'),
            'sortable' => false,
            'filter' => false,
			'renderer'  => 'Biotique_Concerns_Block_Adminhtml_Template_Concerns',
		));

		return $this;
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('concern_id');
		$this->getMassactionBlock()->setformFieldName('concern_ids');

		$this->getMassactionBlock()->addItem('delete_event', array(
			'label' => Mage::helper('biotique_concerns')->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('biotique_concerns')->__('Are you sure you want to delete concerns?')
		));

		return $this;
	}
}