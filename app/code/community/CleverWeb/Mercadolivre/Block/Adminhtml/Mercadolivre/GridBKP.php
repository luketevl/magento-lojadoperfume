<?php

class CleverWeb_Mercadolivre_Block_Adminhtml_Mercadolivre_Grid extends Mage_Adminhtml_Block_Widget_Grid{
  public function __construct()
  {
      parent::__construct();
      $this->setId('mercadolivreGrid');
      $this->setDefaultSort('mercadolivre_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

protected function _getStore() {
      $storeId = (int) $this->getRequest()->getParam('store', 0);
      return Mage::app()->getStore($storeId);
}

  protected function _prepareCollection(){
  	  $store = $this->_getStore();
	  /*
      $collection = Mage::getModel('mercadolivre/mercadolivre')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
	  */
	  $collection = Mage::getModel('catalog/product')->getCollection()
                      ->addAttributeToSelect('sku')
                      ->addAttributeToSelect('name')
                      // ->addAttributeToSelect('lengow_product')
                      ->addAttributeToSelect('attribute_set_id')
                      ->addAttributeToSelect('type_id')
                      ->joinField('qty',
                          'cataloginventory/stock_item',
                          'qty',
                          'product_id=entity_id',
                          '{{table}}.stock_id=1',
                          'left');
	  if ($store->getId()) {
            $collection->setStoreId($store->getId());
            $collection->addStoreFilter($store);
            $collection->joinAttribute('custom_name', 'catalog_product/name', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('price', 'catalog_product/price', 'entity_id', null, 'left', $store->getId());
      } else {
            $collection->addAttributeToSelect('price');
            $collection->addAttributeToSelect('status');
            $collection->addAttributeToSelect('visibility');
      }
		
	  /*	
	  $collection->joinTable(
            array('mercadolivre' => 'mercadolivre/mercadolivre'), 'product_id=entity_id',
            array('ml_id','published','type'),null,'left'
      );
	  */			  
	  $this->setCollection($collection);
      parent::_prepareCollection();
      $this->getCollection()->addWebsiteNamesToResult();
      return $this;
  }

  protected function _prepareColumns(){
      $this->addColumn('mercadolivre_id', array(
          'header'    => Mage::helper('mercadolivre')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'mercadolivre_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('mercadolivre')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('mercadolivre')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));   
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('mercadolivre')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('mercadolivre')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
  
	  $this->addExportType('*/*/exportCsv', Mage::helper('mercadolivre')->__('CSV'));
	  $this->addExportType('*/*/exportXml', Mage::helper('mercadolivre')->__('XML'));
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction(){
        $this->setMassactionIdField('mercadolivre_id');
        $this->getMassactionBlock()->setFormFieldName('mercadolivre');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('mercadolivre')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('mercadolivre')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('mercadolivre/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('mercadolivre')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('mercadolivre')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}