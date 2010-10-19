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