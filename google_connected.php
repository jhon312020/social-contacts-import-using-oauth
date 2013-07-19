<?php
	session_start();
	require_once ('social_library/google/Google_Client.php');
	$client = new Google_Client();
	$client->setApplicationName('Google Contacts PHP Sample');
	$client->setScopes('http://www.google.com/m8/feeds/');
	$client->setClientId($google_client_id);
	$client->setClientSecret($google_client_secret);
	$client->setRedirectUri($google_redirect_url);
	if (isset($_GET['code']))
	{
		$client->authenticate();
		$_SESSION['token'] = $client->getAccessToken();
		$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}
	if (isset($_SESSION['token']))
	{
		$client->setAccessToken($_SESSION['token']);
	}
	if (isset($_REQUEST['logout'])) 
	{
		unset($_SESSION['token']);
		$client->revokeToken();
	}
	if ($client->getAccessToken()) 
	{
		$req = new Google_HttpRequest('https://www.google.com/m8/feeds/contacts/default/thin?q=email&max-results=500');
		$val = $client->getIo()->authenticatedRequest($req);
		$response = json_encode(simplexml_load_string($val->getResponseBody()));
		$_SESSION['token'] = $client->getAccessToken();
		$xml = simplexml_load_string($val->getResponseBody());
		$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
		$user_contacts = array();
		foreach ($xml->entry as $entry) 
		{
			foreach ($entry->xpath('gd:email') as $email) 
			{
				$user_contacts[] = array('title'=>(string)$entry->title, 'email'=>(string)$email->attributes()->address);
			}
		}
	?>
		<script type='text/javascript'>
			var emails = '<?php echo json_encode($user_contacts, JSON_FORCE_OBJECT); ?>';
			window.opener.GetValueFromChild(emails);
			window.close();
		</script>
<?php	}
	else
	{
		//$auth = $client->createAuthUrl();
		header('Location: '.$client->createAuthUrl());
		exit;
	}
