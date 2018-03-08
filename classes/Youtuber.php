<?php

/*
* Youtuber Class
*/

class Youtuber {

	private $_db;
	
	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function add($username, $name, $channelID, $profileIMG) {
		$sql = 'INSERT INTO watchify_youtubers (id,username,name,channelID,profileIMG) VALUES (NULL,"' . $username . '","' . $name . '","' . $channelID . '","' . $profileIMG . '")';

		$data = $this->_db->execute($sql);

		if ($data) {
			return true;
		}

		return false;
	}
	
	public function getChannelID($username) {
		$apiKey = 'AIzaSyBGdUWaDiEbLZJqWEyHByZqfSRKoWDCykY';
		$URL = 'https://www.googleapis.com/youtube/v3/channels?key=' . $apiKey . '&forUsername=' . $username . '&part=id';
		$content = file_get_contents($URL);
		
		if (!empty($content)) {
			
			$totalResults = json_decode($content, true)['pageInfo']['totalResults'];
			
			if ($totalResults >= 1) {
				return json_decode($content, true)['items'][0]['id'];
			} else {
				return 'No result found!';
			}
			
		}
		
		return false;
		
	}
	
	public function getYoutuberProfileIMG($channelID) {
		$apiKey = 'AIzaSyCQbwGVxmmzYCPqh2ScfU8lPdKu5yuHeZs';
		$URL = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&id=' . $channelID . '&fields=items%2Fsnippet%2Fthumbnails&key=' . $apiKey;
		$content = file_get_contents($URL);
		
		if (!empty($content)) {
			$items = json_decode($content, true)['items'][0];
			
			if (!empty($items)) {
				return $items['snippet']['thumbnails']['default']['url'];
			} else {
				return 'https://www.watchify.io/img/avatar.png';
			}
			
		}
		
		return false;
		
	}
	
	public function getAllVideosID($youtuberID) {
		$sql = 'SELECT videoID FROM watchify_videos WHERE youtuberID = ' . $youtuberID;

		$data = $this->_db->execute($sql);

		if ($data) {
			return $data->results();
		}

		return false;
	} 

}


?>