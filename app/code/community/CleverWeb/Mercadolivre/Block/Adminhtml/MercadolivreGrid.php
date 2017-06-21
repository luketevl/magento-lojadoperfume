<?php
/*
 * Desenvolvido por: Mauro Lacerda
 * http://www.cleverweb.com.br
 */
class CleverWeb_Mercadolivre_Block_Adminhtml_Mercadolivre_Grid extends Mage_Adminhtml_Block_Widget_Grid{
  public function __construct(){
      parent::__construct();
      $this->setId('mercadolivreGrid');
      $this->setDefaultSort('mercadolivre_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection(){
      $collection = Mage::getModel('mercadolivre/mercadolivre')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
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

   /*
      $this->addColumn('content', array(
   'header'    => Mage::helper('mercadolivre')->__('Item Content'),
   'width'     => '150px',
   'index'     => 'content',
      ));
   */

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

  public function getRowUrl($row){
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}