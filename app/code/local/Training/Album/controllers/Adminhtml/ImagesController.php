<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:04
 */

class Training_Album_Adminhtml_ImagesController extends Mage_Adminhtml_Controller_action
{

    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('album/images')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Image Manager'), Mage::helper('adminhtml')->__('Image Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
            ->renderLayout();
    }
    public function editAction() {
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('album/images')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('images_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('album/images');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Images Manager'), Mage::helper('adminhtml')->__('Images Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Images News'), Mage::helper('adminhtml')->__('Images News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('album/adminhtml_images_edit'))
                ->_addLeft($this->getLayout()->createBlock('album/adminhtml_images_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('album')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            if(isset($_FILES['imagesname']['name']) && $_FILES['imagesname']['name'] != '') {
                try {
                    /* Starting upload */
                    $uploader = new Varien_File_Uploader('imagesname');

                    // Any extention would work
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                    $uploader->setAllowRenameFiles(false);

                    // Set the file upload mode
                    // false -> get the file directly in the specified folder
                    // true -> get the file in the product like folders
                    //	(file.jpg will go in something like /media/f/i/file.jpg)
                    $uploader->setFilesDispersion(false);

                    // We set media as the upload dir
                    $path = Mage::getBaseDir('media') . DS . 'images' . DS;
                    $uploader->save($path, $_FILES['imagesname']['name'] );

                } catch (Exception $e) {

                }

                //this way the name is saved in DB
                $data['imagesname'] = $_FILES['imagesname']['name'];
            }


            $model = Mage::getModel('album/images');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('album')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('album')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('album/images');

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
        $imagesIds = $this->getRequest()->getParam('images');
        if(!is_array($imagesIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($imagesIds as $imagesId) {
                    $images= Mage::getModel('album/images')->load($imagesId);
                    $images->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($imagesId)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

}