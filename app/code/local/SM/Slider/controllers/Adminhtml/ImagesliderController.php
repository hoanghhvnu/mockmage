<?php

class SM_Slider_Adminhtml_ImagesliderController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('slider/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
//        $isRequireFile = $this->getRequest()->getParam('require-file');
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('slider/imageslider')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('imageslider_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('slider/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('slider/adminhtml_imageslider_edit'))
				->_addLeft($this->getLayout()->createBlock('slider/adminhtml_imageslider_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('slider')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
        $ImageInfo = $_FILES['imagename'];
//        echo "<pre>";
//        var_dump($ImageInfo);
//        die();
		if ($data = $this->getRequest()->getPost()) {

			if(isset($_FILES['imagename']['name']) && $_FILES['imagename']['name'] != '') {

				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('imagename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
                    $NewName = time() . $_FILES['imagename']['name'];
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . 'images' . DS . 'slider';
//					$uploader->save($path, $_FILES['imagename']['name'] );
                    $uploader->save($path, $NewName );
                    $data['imagename'] = $uploader->getUploadedFileName();
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
//	  			$data['imagename'] = $_FILES['imagename']['name'];
//                $data['imagename'] = $NewName;

			} // end if valid file
	  			
//	  		echo "<pre>";
//            var_dump($data);
//            die();
			$model = Mage::getModel('slider/imageslider');
//            echo $data['imagename'];
//            die();
//            $model->setImagename($data['imagename']);
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'))

            ;

			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('slider')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('slider')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('slider/imageslider');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $sliderIds = $this->getRequest()->getParam('imageslider');
        if(!is_array($sliderIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getModel('slider/imageslider')->load($sliderId);
                    $slider->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($sliderIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $sliderIds = $this->getRequest()->getParam('imageslider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getSingleton('slider/imageslider')
                        ->load($sliderId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($sliderIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    } // end massStatusAction

    // Hoang HH
    public function massSetsliderAction()
    {
        $sliderIds = $this->getRequest()->getParam('imageslider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getSingleton('slider/imageslider')
                        ->load($sliderId)
                        ->setSliderId($this->getRequest()->getParam('setslider'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($sliderIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    } // end massStatusAction

    public function massChangesortorderAction()
    {
        $sliderIds = $this->getRequest()->getParam('imageslider');
        if(!is_array($sliderIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($sliderIds as $sliderId) {
                    $slider = Mage::getSingleton('slider/imageslider')
                        ->load($sliderId)
                        ->setSortorder($this->getRequest()->getParam('changesortorder'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($sliderIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    } // end massStatusAction
}