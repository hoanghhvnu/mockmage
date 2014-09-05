<?php

class Training_Album_Block_Adminhtml_Images_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('imagesGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('album/images')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('images_id', array(
            'header'    => Mage::helper('album')->__('images_id'),
            'align'     =>'left',
            'index'     => 'images_id',
        ));

        $this->addColumn('imagesname', array(
            'header'    => Mage::helper('album')->__('Image'),
            'align'     =>'left',
            'index'     => 'imagesname',
            'sortable'      => false,
            'filter'      => false,
            'renderer'  =>   'album/adminhtml_images_renderer_images'
        ));

        $this->addColumn('album_id', array(
            'header'    => Mage::helper('album')->__('album_id'),
            'align'     =>'left',
            'index'     => 'album_id',

        ));


        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('album')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('album')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));

        $this->addExportType('*/*/exportCsv', Mage::helper('album')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('album')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('images_id');
        $this->getMassactionBlock()->setFormFieldName('images');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('album')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('album')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }


}