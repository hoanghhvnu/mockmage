<?php

class SM_Slider_Block_Adminhtml_Imageslider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
//      echo __METHOD__;
      parent::__construct();
      $this->setId('imageGrid');
      $this->setDefaultSort('image_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('slider/imageslider')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
//      $this->getListSlider();
//      die();
      $this->addColumn('image_id', array(
          'header'    => Mage::helper('slider')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'image_id',
      ));

      $this->addColumn('imagepreview', array(
          'header'    => Mage::helper('slider')->__('Image Preview'),
          'align'     =>'left',
          'index'     => 'imagepreview',
          'sortable'      => false,
          'filter'      => false,
          'renderer' => 'slider/adminhtml_imageslider_renderer_imagepreview',
//          'renderer'  =>   'salestaff/adminhtml_staff_renderer_avatar',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('slider')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $this->addColumn('imagename', array(
          'header'    => Mage::helper('slider')->__('Image name'),
          'align'     =>'left',
          'index'     => 'imagename',
      ));

      $this->addColumn('description', array(
          'header'    => Mage::helper('slider')->__('Description'),
          'align'     =>'left',
          'index'     => 'description',
      ));

      $this->addColumn('slider_id', array(
          'header'    => Mage::helper('slider')->__('Slider ID'),
          'align'   => 'left',
          'index'     => 'slider_id',

      ));

      $this->addColumn('status', array(
          'header'    => Mage::helper('slider')->__('Status'),
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
                'header'    =>  Mage::helper('slider')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('slider')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		
		$this->addExportType('*/*/exportCsv', Mage::helper('slider')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('slider')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('image_id');
        $this->getMassactionBlock()->setFormFieldName('imageslider');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('slider')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('slider')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('slider/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('slider')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('slider')->__('Status'),
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


} // end class
// end file