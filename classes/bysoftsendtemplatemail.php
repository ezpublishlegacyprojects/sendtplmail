<?php

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
                
                $sender = $this->_getParam('sender', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $receivers = $this->_getParam('receivers', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $ccReceivers = $this->_getParam('cc_receivers', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $subject = $this->_getParam('subject', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                $body = $this->_getParam('body', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                
                $sender = $this->_getParam('sender', $tpl, $rootNamespace, $currentNamespace, $functionParameters, $functionPlacement);
                
                // bcc not included at all. 
                // @todo, do not have time to do.
                
                $mail = new eZMail();
                $ini = eZINI::instance();
                
                if (!$mail->validate($sender)) {
                    $sender = $ini->variable( "MailSettings", "EmailSender" );
                    if (!$mail->validate($sender)) {
                        $sender = $ini->variable("MailSettings", "AdminEmail");
                    }
                }
                $mail->setSender($sender);
                
                if (!is_array($receivers)) {
                    $receivers = array($receivers);
                }
                foreach ($receivers as $receiver) {
                    // maybe provide name as hash key, if neccessary
                    if ($mail->validate($receiver)) {
                        $mail->addReceiver($receiver);
                    }
                }
                
                $mail->setSubject($subject);
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