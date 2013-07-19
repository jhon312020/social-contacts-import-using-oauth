<?php
/*
	@author		:	Giriraj Namachivayam
	@date 		:	Mar 20, 2013
	@demourl	:	http://ngiriraj.com/socialMedia/oauthlogin/msn.php
	@document	:	http://ngiriraj.com/work/hotmail-connect-by-using-oauth/
	@license	: 	Free to use, 
	@History	:	V1.0 - Released oauth 2.0 service providers login access	
	@oauth2		:	Support following oauth2 login
					Bitly
					Wordpress
					Paypal
					Facebook
					Google
					Microsoft(MSN,Live,Hotmail)
					Foursquare
					Box
					Reddit
					Yammer
					Yandex
	
*/

class socialmedia_oauth_connect
{
	public $socialmedia_oauth_connect_version = '1.0';
	public $client_id;
	public $client_secret;
	public $scope;
	public $responseType;
	public $nonce;
	public $state;
	public $redirect_uri;
	public $code;
	public $oauth_version;
	public $provider;
	public $accessToken;  
	
	protected $requestUrl;
  	protected $accessTokenUrl;
  	protected $dialogUrl;
	protected $userProfileUrl;
	protected $header;
	
	public function Initialize(){
		$this->nonce = time() . rand();
		switch($this->provider)
		{
			case '';
				break;
			case 'Microsoft':
				$this->oauth_version="2.0";
				$this->dialogUrl = 'https://login.live.com/oauth20_authorize.srf?';
				$this->accessTokenUrl = 'https://login.live.com/oauth20_token.srf';
				$this->responseType="code";
				//$this->userProfileUrl = "https://apis.live.net/v5.0/me?access_token=";
				$this->userProfileUrl = "https://apis.live.net/v5.0/me/contacts?access_token=";
				$this->header="";
				break;

			default:
				return($this->provider.'is not yet a supported. We will release soon. Contact kayalshri@gmail.com!' );
		}
  	}
  	
  	
  
  	public function Authorize(){
  	
  		if($this->oauth_version == "2.0"){
  	    $dialog_url = $this->dialogUrl
  	    		."client_id=".$this->client_id
			."&response_type=".$this->responseType
			."&scope=".$this->scope
			/*."&nonce=".$this->nonce*/
			."&state=".$this->state
        	."&redirect_uri=".urlencode($this->redirect_uri);
     		echo("<script> top.location.href='" . $dialog_url . "'</script>");
     		}else{

			$date = new DateTime();
     			$request_url = $this->requestUrl;
     			$postvals ="oauth_consumer_key=".$this->client_id
     					."&oauth_signature_method=HMAC-SHA1"
     					."&oauth_timestamp=".$date->getTimestamp()
     					."&oauth_nonce=".$this->nonce
     					."&oauth_callback=".$this->redirect_uri
     					."&oauth_signature=".$this->client_secret
     					."&oauth_version=1.0";
     			$redirect_url = $request_url."".$postvals;
     			
   			

     			$oauth_redirect_value= $this->curl_request($redirect_url,'GET','');

  			$dialog_url = $this->dialogUrl.$oauth_redirect_value;
     			     			
     			echo("<script> top.location.href='" . $dialog_url . "'</script>");
     		}

  	}
  	

  	public function getAccessToken(){
		$postvals = "client_id=".$this->client_id
			."&client_secret=".$this->client_secret
			."&grant_type=authorization_code"
			."&redirect_uri=".urlencode($this->redirect_uri)
			."&code=".$this->code;
		return $this->curl_request($this->accessTokenUrl,'POST',$postvals);
  	}
  	
  	public function getUserProfile(){
  		$getAccessToken_value = $this->getAccessToken();
  		$getatoken = json_decode( stripslashes($getAccessToken_value) );

		if( $getatoken === NULL ){
			$atoken=$getAccessToken_value;
   		}else{
	   		$atoken = $getatoken->access_token;
   		}   
   		
   		if($this->provider=="Yammer"){
   			$atoken = $getatoken->access_token->token;
   		}
	  	
  		$profile_url = $this->userProfileUrl."".$atoken;
  			
		return $this->curl_request($profile_url,"GET",$atoken);

  	} 
  	
  	public function APIcall($url){
	  	return $this->curl_request($url,"GET",$_SESSION['atoken']);
  	}
  	
  	public function debugJson($data){
  		echo "<pre>";
  		print_r($data);
  		echo "</pre>";
  	}
  	
	public function curl_request($url,$method,$postvals){
		
		$ch = curl_init($url);
		if ($method == "POST"){
		   $options = array(
	                CURLOPT_POST => 1,
	                CURLOPT_POSTFIELDS => $postvals,
	                CURLOPT_RETURNTRANSFER => 1,
			);
		
		}else{
		
		   $options = array(
	                CURLOPT_RETURNTRANSFER => 1,
			);
		
		}
		curl_setopt_array( $ch, $options );
		if($this->header){
		
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( $this->header . $postvals) );
		}
		
		$response = curl_exec($ch);
		curl_close($ch);
	#	print_r($response);
		return $response;
	}
}
?>
