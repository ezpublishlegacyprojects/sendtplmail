**************************************************

Send Email In Template

**************************************************

Author : Cavin Deng
Date : Septemeber 2010

1/ Unzip file in your extension directory

2/ Activate the extension in the admin interface

3/ To use it in a template :

{send_tpl_mail sender=$sender receivers=$receivers body=$body subject=$subject}

Eg:
{send_tpl_mail sender='admin@gmail.com' receivers='cavin.deng@bysoft.fr' subject='hello' body='tests'}


4/ complete parameters for this operator
  
  Parameter       DataType      Description
  -------------   ---------     -----------------------------------------------------------------------------------
  sender          string|null   The sender of this mail, if not present, we will use 'EmailSender' or 'AdminEmail'.
  receivers       string|array  The recipients 
  cc_receivers    string|array  The cc recipients
  bcc_receivers   string|array  The bcc recipients
  content_type    string|null   The content type, can only be 'text/html', default is 'text/plain'.
  subject         string        The subject of email
  body            string        The content
  
  
  



@todo, think about a way to implement attament, maybe can use ezcMail component