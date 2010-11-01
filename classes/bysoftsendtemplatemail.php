<?php
/**
 * Send Email by using template arguments
 * 
 * @author cavin.deng
 * @since 2010-10-30
 * 
 */
class bysoftSendTemplateMail
{
    const SEND_TPL_MAIL = 'send_tpl_mail';
    
    function functionList()
    {
        return array(
            'send_tpl_mail'
        );
    }
    
    function attributeList()
    {
        return array();   
    }
    
    function functionTemplateHints()
    {
        
        return array(
            self::SEND_TPL_MAIL => array(
                'parameters' => true,
                'static' => false,
                'transform-parameters' => true,
                'tree-transformation' => true
            )
        );
    }
    
    function process( &$tpl, &$textElements, $functionName, $functionChildren, $functionParameters, $functionPlacement, $rootNamespace, $currentNamespace )
    {
        
        switch ($functionName) {
            case self::SEND_TPL_MAIL:
                
                // 1.1 fetch arguments from template
                $sender = $this->_getParam('sender', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $receivers = $this->_getParam('receivers', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $ccReceivers = $this->_getParam('cc_receivers', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $bccReceivers = $this->_getParam('bcc_receivers', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $subject = $this->_getParam('subject', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $body = $this->_getParam('body', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
				$contentType = $this->_getParam('content_type', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                
                $mail = new eZMail();
                $ini = eZINI::instance();
				
                // 2.1 check email sender, because email sender must be specified for each mail.
                if (!$mail->validate($sender)) {
                    $sender = $ini->variable( "MailSettings", "EmailSender" );
                    if (!$mail->validate($sender)) {
                        $sender = $ini->variable("MailSettings", "AdminEmail");
                    }
                }
                $mail->setSender($sender);
                
                // 2.2 setup email attributes
                
                // 2.2.1 email receivers
                if (!is_array($receivers)) {
                    $receivers = array($receivers);
                }
                foreach ($receivers as $receiver) {
                    // maybe provide name as hash key, if neccessary
                    if ($mail->validate($receiver)) {
                        $mail->addReceiver($receiver);
                    }
                }
                
                // 2.2.2 email cc receivers
                if (isset($ccReceivers)) {
                    if (!is_array($ccReceivers)) {
                        $ccReceivers = array($ccReceivers);
                    }
                    foreach ($ccReceivers as $c) {
                        if ($mail->validate($c)) {
                            $mail->addCc($c);
                        }
                    }
                }
                
                // 2.2.3 email bcc receivers
                if (isset($bccReceivers)) {
                    if (!is_array($bccReceivers)) {
                        $bccReceivers = array($bccReceivers);
                    }
                    foreach ($bccReceivers as $bc) {
                        if ($mail->validate($bc)) {
                            $mail->addBcc($bc);
                        }
                    }
                }
                
                // 2.2.4 email subject
                $mail->setSubject($subject);
                
                // 2.2.5 email content type and content
                // default content type is text/plain
				if (isset($contentType) && $contentType == 'text/html') {
					$mail->setContentType($contentType);
				}
                $mail->setBody($body);
                
                eZMailTransport::send($mail);
                break;
        }
    }
    
    /**
     * Get Parameter from template, if not defined, null will be returned
     *
     * @param string $varName
     * @param ezTemplate $tpl
     * @param string $rootNamespace
     * @param string $currentNamespace
     * @param array $functionParameters
     * @param array $functionPlacement
     * @return mixed|null null if parameter is not define in template function parameters
     */
    function _getParam($varName, &$tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement)
    {
        
        if (!isset($functionParameters[$varName])) {
            return null;
        }
        $varInfo = $functionParameters[$varName];
        return $tpl->elementValue($varInfo, $rootNamespace, $currentNamespace, $functionPlacement);
    }
    
    function hasChildren()
    {
        return false;
    }
    
}

?>