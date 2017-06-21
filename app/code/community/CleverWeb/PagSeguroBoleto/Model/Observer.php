<?php
class CleverWeb_PagSeguroBoleto_Model_Observer 
{
    public function saveCustomData($event)
    {
        $quote = $event->getSession()->getQuote();
        $quote->setData('meuhash', $event->getRequestModel()->getPost('meuhash'));
		$quote->setData('tokenpagamento', $event->getRequestModel()->getPost('tokenpagamento'));
        return $this;
    }
}
