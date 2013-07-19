<?php
function _xml_to_array($xml)
{
	$array = json_decode(json_encode($xml), TRUE);
	foreach ( array_slice($array, 0) as $key => $value ) 
	{
		if ( empty($value) ) $array[$key] = NULL;
		elseif ( is_array($value) ) $array[$key] = _xml_to_array($value);
	}
	return $array;
}
include_once 'config.php';
require_once ('social_library/yahoo/Yahoo.inc');
$session = YahooSession::requireSession($yahoo_consumer_key, $yahoo_consumer_secret, $app_id);
if (is_object($session))
{
	$user = $session->getSessionedUser();
	$profile_contacts = _xml_to_array($user->getContactSync());
	$contacts = array();
	$user_contacts = array();
	foreach($profile_contacts['contactsync'] ['contacts'] as $key=>$profileContact)
	{
		foreach($profileContact['fields'] as $contact)
		{
			$contacts[$key][$contact['type']] = $contact['value'];
		}
	}
	foreach ($contacts as $contact)
	{
		if (array_key_exists('email', $contact))
		{
			$name = array_key_exists('name', $contact) ? (string)$contact['name']['givenName'].' '.(string)$contact['name']['familyName']: '';
			$user_contacts[] = array('title'=>$name, 'email'=>(string)$contact['email']);
		}
	}
	?>
	<script type='text/javascript'>
		var emails = '<?php echo json_encode($user_contacts, JSON_FORCE_OBJECT); ?>';
		window.opener.GetValueFromChild(emails);
		window.close();
	</script>
<?php 
}
else
{
	header("Location :".$yahoo_redirect_url);
}
