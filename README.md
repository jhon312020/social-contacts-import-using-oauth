social-contacts-import-using-oauth
==================================

Socail contacts import from google, msn and yahoo using oauth authentication

1) Create the applications on the portals of yahoo, msn and google<br/>
	(MSN https://account.live.com/developers/applications)<br/>
	(google https://code.google.com/apis/console)<br/>
	(yahoo http://developer.yahoo.com/yap/create/)<br/>
2) After creating application, replace all the client key and secret in the config file with your application key and secret which you would have created before.<br/>
2) The msn will not work using the localhost.  So create a entry in your host file with  127.0.0.1  host name whichever you need.<br/>
3)when trying for msn try with the following "http://hostname/Filepath"</br>
