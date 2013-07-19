<?php
	include_once 'config.php';
	require_once ('social_library/msn/socialmedia_oauth_connect.php');
	$oauth = new socialmedia_oauth_connect();
	$oauth->provider = 'Microsoft';
	$oauth->client_id = $msn_client_id;
	$oauth->client_secret = $msn_client_secret;
	$oauth->scope = 'wl.basic, wl.contacts_emails';
	$oauth->redirect_uri  = $msn_redirect_url;
	$oauth->Initialize();
	$user_contacts = array();
	$code = (isset($_REQUEST['code'])) ?  ($_REQUEST['code']) : '';
	if (empty($code))
	{
		$oauth->Authorize();
	}
	else
	{
		$oauth->code = $code;
		$contacts  = json_decode($oauth->getUserProfile());
		foreach($contacts->data as $contact)
		{
			if (array_key_exists('emails', $contact))
			{
				$name = array_key_exists('name', $contact) ? (string)$contact->first_name.' '.(string)$contact->last_name: '';
				$user_contacts[] = array('title'=>$name, 'email'=>(string)$contact->emails->preferred);
			}
		}
	?>
	<script type='text/javascript'>
		var emails = '<?php echo json_encode($user_contacts, JSON_FORCE_OBJECT); ?>';
		window.opener.GetValueFromChild(emails);
		window.close();
	</script>
<?php	} ?>
