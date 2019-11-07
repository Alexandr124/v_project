<?php

namespace Vaimo\Quote\Controller\Adminhtml\Index;
use Vaimo\Quote\Controller\Adminhtml\Base as BaseLink;
class Delete extends Baselink
{

    /** {@inheritdoc} */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);
        if (!empty($id)) {
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('Link has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(_('Link can\'t delete'));
                return $this->doRefererRedirect();
            }
        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", static::QUERY_PARAM_ID)
            );
        }
        return $this->redirectToGrid();
    }
}