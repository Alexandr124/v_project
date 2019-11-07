<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Item;

use Magento\Framework\App\Filesystem\DirectoryList;
use Vaimo\Carousel\Controller\Adminhtml\Item;

class Save extends Item
{
    /**
     * @return $this|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPostValue()) {
            $model = $this->itemFactory->create();
            $storeViewId = $this->getRequest()->getParam('store');

            if ($id = $this->getRequest()->getParam(static::PARAM_CODE)) {
                $model->load($id);
            }
            $data = $this->saveImage(array('image', 'image_small', 'image_medium'), $data);

            $model->setData($data)
                ->setStoreViewId($storeViewId);

            try {
                $model->save();

                $this->messageManager->addSuccess(__('The item has been saved.'));
                $this->_getSession()->setFormData(false);

                return $this->getBackResultRedirect($resultRedirect, $model->getId());
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the item.'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath('*/*/edit',
                [static::PARAM_CRUD_ID => $this->getRequest()->getParam(static::PARAM_CRUD_ID)]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Processes the images and saves them. Returns the post request data after modifications to image fields
     * @param array $imageField
     * @param $data
     * @return mixed
     */
    protected function saveImage($imageField = array(), $data)
    {
        for ($i = 0; $i < sizeof($imageField); $i++) {
            $imageRequest = $this->getRequest()->getFiles($imageField[$i]);
            if ($imageRequest) {
                if (isset($imageRequest['name'])) {
                    $fileName = $imageRequest['name'];
                } else {
                    $fileName = '';
                }
            } else {
                $fileName = '';
            }

            if ($imageRequest && strlen($fileName)) {
                try {
                    $uploader = $this->_objectManager->create(
                        'Magento\MediaStorage\Model\File\Uploader',
                        ['fileId' => $imageField[$i]]
                    );
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

                    /** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
                    $imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();

                    $uploader->addValidateCallback('item_image', $imageAdapter, 'validateUploadFile');
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);

                    /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
                    $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                        ->getDirectoryRead(DirectoryList::MEDIA);
                    $result = $uploader->save(
                        $mediaDirectory->getAbsolutePath(\Vaimo\Carousel\Model\Item::BASE_MEDIA_PATH)
                    );
                    $data[$imageField[$i]] = \Vaimo\Carousel\Model\Item::BASE_MEDIA_PATH . $result['file'];
                } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
            } else {
                if (isset($data[$imageField[$i]]) && isset($data[$imageField[$i]]['value'])) {
                    if (isset($data[$imageField[$i]]['delete'])) {
                        $data[$imageField[$i]] = null;
                        $data['delete_image'] = true;
                    } elseif (isset($data[$imageField[$i]]['value'])) {
                        $data[$imageField[$i]] = $data[$imageField[$i]]['value'];
                    } else {
                        $data[$imageField[$i]] = null;
                    }
                }
            }
        }
        return $data;
    }

}