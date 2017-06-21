<?php

class CleverWeb_Mercadolivre_Block_Adminhtml_Anuncios_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('mercadolivre_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }


    protected function _prepareCollection()
    {
        //$collection = Mage::getResourceModel('smsnotification/smsnotification_collection');
        //$this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
          $this->addColumn('id', array(
              'header'    => 'Id',
              'align'     =>'right',
              'width'     => '50px',
              'index'     => 'id',
          ));

          $this->addColumn('Nome', array(
              'header'    => 'Nome',
              'align'     =>'left',
              'index'     => 'Receiver',
          ));

        $this->addColumn('Preço', array(
            'header'    => 'Preço',
            'align'     =>'left',
            'index'     => 'Phone',
        ));

        $this->addColumn('Date', array(
            'header'    => Mage::helper('smsnotification')->__('Date'),
            'align'     =>'left',
            'index'     => 'Date',

        ));


        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}