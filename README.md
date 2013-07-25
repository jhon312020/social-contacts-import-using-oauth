social-contacts-import-using-oauth
==================================

Socail contacts import from google, msn and yahoo using oauth authentication<br/>
<ul>
<li>Create the applications on the portals of yahoo, msn and google<br/>
	<ul><li>(MSN https://account.live.com/developers/applications)</li>
	<li>(google https://code.google.com/apis/console)</li>
	<li>(yahoo http://developer.yahoo.com/yap/create/)</li></ul>
</li>
<li>After creating application, replace all the client key and secret in the config file with your application key and secret which you would have created before.</li>
<li>The msn will not work using the localhost.  So create a entry in your host file with  127.0.0.1  host name whichever you need.</li>
<li> when trying for msn try with the following "http://hostname/Filepath"</li>
