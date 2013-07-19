<?php
function contactlist()
{
	CONSUMER_KEY
	$oauth_access_token	= 'dj0yJmk9cXVXYUFXZnQxclNlJmQ9WVdrOVkwMVJVMUZVTlRBbWNHbzlNVFUxTmpnMk5UWTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD02Mg--';
	$oauth_token_secret	= '0e6abdb6a6c135e9e9fe49b80388547816f6a0df' ;
	$session_id     = ' ' ;
	//prepare url
	$url = 'http://developer.messenger.yahooapis.com/v1/contacts';
	$url .= '?oauth_consumer_key='. CONSUMER_KEY;	
	$url .= '&oauth_nonce='. uniqid(rand());
	$url .= '&oauth_signature='. CONSUMER_SECRET_KEY. '%26'. $oauth_token_secret;
	$url .= '&oauth_signature_method=PLAINTEXT';
	$url .= '&oauth_timestamp='. time();
	$url .= '&oauth_token='. urlencode($oauth_access_token);
	$url .= '&oauth_version=1.0';    
	$url .= '&sid='. $session_id;
	$url .= '&fields=%2Bpresence';
	$url .= '&fields=%2Bgroups';
	$url .= '&fields=%2Baddressbook';
	//additional header
	$header[] = 'Content-type: application/json; charset=utf-8';	
	$rs = curl($url, 'get', $header);
	if (stripos($rs, 'contact') === false) return false;

	$js = json_decode($rs, true);
	print_r(json_encode($js['contacts']));

}

function curl($url, $method = 'get', $header = null, $postdata = null, $includeheader=FALSE, $timeout = 60)
{
	$s = curl_init();
	curl_setopt($s,CURLOPT_URL, $url);
	if ($header) 
	curl_setopt($s,CURLOPT_HTTPHEADER, $header);
	/*if ($this->debug)*/
	curl_setopt($s,CURLOPT_VERBOSE, FALSE);
	curl_setopt($s,CURLOPT_TIMEOUT, $timeout);
	curl_setopt($s,CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($s,CURLOPT_MAXREDIRS, 3);
	curl_setopt($s,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($s,CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($s,CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($s,CURLOPT_COOKIEFILE, 'cookie.txt'); 
	if(strtolower($method) == 'post')
	{
		curl_setopt($s,CURLOPT_POST, true);
		curl_setopt($s,CURLOPT_POSTFIELDS, $postdata);
	}
	else if(strtolower($method) == 'delete')
	{
		curl_setopt($s,CURLOPT_CUSTOMREQUEST, 'DELETE');
	}
	else if(strtolower($method) == 'put')
	{
		curl_setopt($s,CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($s,CURLOPT_POSTFIELDS, $postdata);
	}
	curl_setopt($s,CURLOPT_HEADER, $includeheader);	 
	//curl_setopt($s,CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1');
	curl_setopt($s, CURLOPT_SSL_VERIFYPEER, false);
	$html    = curl_exec($s);
	$status = curl_getinfo($s, CURLINFO_HTTP_CODE);
	curl_close($s);
	return $html;
}
