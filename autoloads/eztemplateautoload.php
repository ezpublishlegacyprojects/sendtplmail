<?php

// Operator autoloading

$eZTemplateOperatorArray = array();

//$eZTemplateOperatorArray[] = array( 
//    'script' => 'extension/template_mailer/autoloads/mytemplatemailer.php',
//    'class' => 'MyTemplateMailer',
//    'operator_names' => array( 'template_mail' ) 
//);

$eZTemplateFunctionArray[] = array(
    'script' => 'extension/sendtplmail/classes/bysoftsendtemplatemail.php',
    'class' => 'bysoftSendTemplateMail',
    'function_names' => array( 'send_tpl_mail' )
);

?>