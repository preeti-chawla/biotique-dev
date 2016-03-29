<?php

class Biotique_Gist_FeedController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		if ($this->getRequest()->isXmlHttpRequest()) {
			$type = $this->getRequest()->getParam('type');

			$resp = array();

			switch($type){
				case 'twitter':
					$resp = $this->getTwitter();
				break;
				case 'fb':
					$resp = $this->getFacebook();
				break;
				case 'yt':
					$resp = $this->getYoutube();
				break;
				case 'pin':
					$resp = $this->getPintrest();
				break;

				default: 
					$resp = array(
						'title' => '',
						'desc' => ''
					);
				break;
			}
			echo json_encode($resp);
			exit;
		}else{
			exit('invalid access');	
		}
		
	}

	// facebook
	public function getFacebook()
	{
		$pageid = '889987864414419';
		$facefeeds_json = file_get_contents('https://graph.facebook.com/'.$pageid.'/feed?access_token=642958439182418|ctty-LZdwD0Bmmyqbt-jj7LM2JQ&limit=1');
		$facefeeds_arr = json_decode($facefeeds_json);
		$fd = $facefeeds_arr->data[0];

		return array(
			'title' => 'Biotique <a href="https://www.facebook.com/pages/'. $fd->from->name .'/'. $fd->from->id .'" target="_blank">@'. $fd->from->name .'</a>',
			'desc' => $fd->message
		);
	}

	// pintrest
	public function getPintrest()
	{
		$pinfeeds_json = file_get_contents('http://api.pinterest.com/v3/pidgets/users/biotique/pins/');
		
		$pinfeeds_obj = json_decode($pinfeeds_json);
		$pins = $pinfeeds_obj->data->pins[0];
		return array(
			'title' => 'Pintrest <a href="https://www.pinterest.com/pin/'. $pins->id .'" target="_blank">@'. $pins->pinner->full_name .'</a>',
			'desc' => $pins->description
		);
	}

	// youtube
	public function getYoutube()
	{
		$ytb_arr = array();
		$yt = new Zend_Gdata_YouTube;
		$yt->setMajorProtocolVersion(2);
		$feed_url = 'https://gdata.youtube.com/feeds/api/playlists/PLqRe68z8v3vI62OtcUojyhQGuhFERLg3O';
		$playlistVideoFeed =  $yt->getPlaylistVideoFeed($feed_url);

		foreach ($playlistVideoFeed as $video_entry) {
	        $videoThumbnails = $video_entry->getVideoThumbnails();
	        $videothumbnail = $videoThumbnails[0];
	        $use_thumb = $videothumbnail['url'];

	        $ytb_arr = array(
	            'title' => $video_entry->getVideoTitle(),
	            'desc' => '<a href="https://www.youtube.com/watch?v='. $video_entry->getVideoId() .'" target="_blank"><img src="'. $use_thumb  .'" /></a>'
	        );
			break;
		}
		
		return $ytb_arr;
	}

	// Twittter
	protected function getTwitter()
	{
		$token = '2254937192-kcQ5CJ9vqUYOnXOJQPl2E0pX0PeHXbFAv4jfKsx';
		$token_secret = 'ghUZdguh1JkGqH6YAg7rQI2vlwBGPcmpMuTDWYs1hAiZs';
		$consumer_key = 'sCv3xGhcYsNSU31aUGDwtJzYq';
		$consumer_secret = 'uokPBqTycSCDhhzWXlgu8mcUkcwdFDb9dgX5jQnkq56ey3pB1A';

		$method = 'GET';

		$query = array( // query parameters
		    'screen_name' => 'joyaanshari',
		    'count' => '1'
		);

		$oauth = array(
		    'oauth_consumer_key' => $consumer_key,
		    'oauth_token' => $token,
		    'oauth_nonce' => (string)mt_rand(),
		    'oauth_timestamp' => time(),
		    'oauth_signature_method' => 'HMAC-SHA1',
		    'oauth_version' => '1.0'
		);

		$oauth = array_map("rawurlencode", $oauth);
		$query = array_map("rawurlencode", $query);

		$arr = array_merge($oauth, $query);
		asort($arr);
		ksort($arr);

		$querystring = urldecode(http_build_query($arr, '', '&'));
		$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

		
		$base_string = $method."&".rawurlencode($url)."&".rawurlencode($querystring);  // mash everything together for the text to hash
		$key = rawurlencode($consumer_secret)."&".rawurlencode($token_secret);  // same with the key


		$signature = rawurlencode(base64_encode(hash_hmac('sha1', $base_string, $key, true)));  // generate the hash

		$url .= "?".http_build_query($query);
		$url=str_replace("&amp;","&",$url);

		$oauth['oauth_signature'] = $signature;
		ksort($oauth);

		$auth = "OAuth " . urldecode(http_build_query($oauth, '', ', ')); // this is the full value of the Authorization line

		$options = array(
			CURLOPT_HTTPHEADER => array("Authorization: $auth"),
			//CURLOPT_POSTFIELDS => $postfields,
			CURLOPT_HEADER => false,
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false
		);

		// do our business
		$feed = curl_init();
		curl_setopt_array($feed, $options);
		$json = curl_exec($feed);
		curl_close($feed);

		$twitter_data = json_decode($json);

		$tweets = $twitter_data[0];
		return $response = array(
			'title' => 'Tweets by <a href="https://twitter.com/'. $tweets->user->screen_name .'" target="_blank">@'. $tweets->user->screen_name .'</a>',
			'desc' => $tweets->text
		);
	}

	protected function add_quotes($str) { 
		return '"'.$str.'"'; 
	}
}