social-contacts-import-using-oauth
==================================

Socail contacts import from google, msn and yahoo using oauth authentication

1) Create the applications on the portals of yahoo, msn and google 
	(MSN https://account.live.com/developers/applications)
	(google https://code.google.com/apis/console)
	(yahoo http://developer.yahoo.com/yap/create/)
2) After creating application, replace all the client key and secret in the config file with your application key and secret which you would have created before.
2) The msn will not work using the localhost.  So create a entry in your host file with  127.0.0.1  host name whichever you need.
3)when trying for msn try with the following "http://hostname/Filepath";
