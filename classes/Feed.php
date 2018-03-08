<?php

/**
* Feed Class
*/
class Feed {

	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;
	
	public function __construct($user = null) {
		$this->_db = DB::getInstance();
	}



	public function getFollowings($userID) {
		$sql = 'SELECT youtuberID FROM watchify_followings WHERE userID = ' . $userID;

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->results();
		}

		return false;
	}
	
	public function getFollowingsWithFollow($myID, $userID) {
		$sql = 'SELECT 
							y.id, 
							y.name, 
							y.profileIMG, 
							(SELECT 
								(CASE 
									WHEN COUNT(*) >= 1 THEN "1" 
									ELSE "0" 
								END) 
							FROM watchify_followings f 
							WHERE f.userID = ' . $myID . ' AND f.youtuberID = y.id) as followed 
						FROM watchify_youtubers y 
						WHERE y.id IN (SELECT youtuberID FROM watchify_followings WHERE userID = ' . $userID . ')';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->results();
		}

		return false;
	}
	
	public function getSuggestions($userID) {
		$sql = 'SELECT y.id, y.profileIMG 
				FROM watchify_followings f 
				RIGHT JOIN watchify_youtubers y 
					ON f.youtuberID = y.id AND f.userID = ' . $userID. ' 
				WHERE f.id IS NULL 
				ORDER BY RAND() 
				LIMIT 4';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->results();
		}

		return false;
	}
	
	public function search($myID, $motclef) {
  	$sql = 'SELECT 
              y.id, 
              y.name, 
              y.profileIMG, 
              (SELECT  
                (CASE 
                    WHEN COUNT(*) >= 1 THEN "1"
                    ELSE "0"
                END) 
              FROM watchify_followings f 
              WHERE f.userID = ' . $myID . ' AND f.youtuberID = y.id) as followed 
            FROM watchify_youtubers y WHERE (y.username LIKE "%' . $motclef . '%" OR y.name LIKE "%' . str_replace(' ', '', $motclef) . '%")';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data;
		}

		return false;
	}

	public function userExist($userID) {
		$sql = 'SELECT * FROM watchify_users WHERE id = ' . $userID;

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}
	
	public function youtuberExist($username) {
		$sql = 'SELECT username FROM watchify_youtubers WHERE username = "' . $username . '"';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}
	
	public function videoExist($videoID) {
		echo $sql = 'SELECT id FROM watchify_videos WHERE videoID = "' . $videoID . '"';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}

	public function userFollowNobody($userID) {
		$sql = 'SELECT * FROM watchify_followings WHERE userID = ' . $userID;

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return false;
		}

		return true;
	}

	public function countYoutubers() {
		$sql = 'SELECT * FROM watchify_youtubers';
		
		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->count();
		}

		return false;
	}

	public function countFollowings($userID) {
		$sql = 'SELECT * FROM watchify_followings WHERE userID = ' . $userID;
		
		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->count();
		}

		return false;
	}

	public function countVideos($youtubers) {
		$sql = 'SELECT * FROM watchify_videos WHERE youtuberID IN (' . $youtubers . ')';
		
		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->count();
		}
		
		return false;
	}

	public function getUsername($userID) {
		$sql = 'SELECT username FROM watchify_users WHERE id = ' . $userID;

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->first()->username;
		}

		return false;
	}

	public function getYoutuberInfos($youtuberID, $field) {
		$sql = 'SELECT ' . $field . ' FROM watchify_youtubers WHERE id = ' . $youtuberID;

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->first()->$field;
		}

		return false;
	}
	
	public function getYoutuberID($username) {
		$sql = 'SELECT id FROM watchify_youtubers WHERE username = "' . $username . '"';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->first()->id;
		}

		return false;
	}
	
	public function getNameFromUsername($username) {
		$sql = 'SELECT name FROM watchify_youtubers WHERE username = "' . $username . '"';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->first()->name;
		}

		return false;
		
	}

	public function getFeed($youtubers, $channelPage, $start, $videosPerPage) {
		
		if ($channelPage == 1) {
			$sql = 'SELECT * FROM watchify_videos WHERE youtuberID = ' . $this->getYoutuberID($youtubers) . ' ORDER BY uploaded DESC LIMIT ' . $start . ', ' . $videosPerPage;
		} else {
			$sql = 'SELECT * FROM watchify_videos ' . ($youtubers === 0 ? '' : 'WHERE youtuberID IN (' . $youtubers . ')') . ' ORDER BY uploaded DESC LIMIT ' . $start . ', ' . $videosPerPage;
		}
		
		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->results();
		}

		return false;
	}
	
	public function getBadges($userID, $youtuberID) {
		$sql = 'SELECT * FROM watchify_badges WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID;
		
		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->count();
		}

		return false;
	}
	
	public function displayBadge($userID, $youtuberID) {
		$sql = 'SELECT * FROM watchify_badges WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID;
		
		$data = $this->_db->execute($sql);

		if ($data->count() >= 1) {
			return true;
		}

		return false;
	}
	
	public function getAllBadges($userID) {
		$sql = 'SELECT * FROM watchify_badges WHERE userID = ' . $userID;
		
		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->count();
		}

		return false;
	}
	
	public function videoStatut($userID, $youtuberID, $videoID) {
		$sql = 'SELECT * FROM watchify_badges WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID . ' AND videoID = "' . $videoID . '"';
		
		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->count();
		}

		return false;
	}
	
	public function flagVideo($userID, $youtuberID, $videoID, $action) {
		$sqlCheck = 'SELECT * FROM watchify_flags WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID . ' AND videoID = "' . $videoID . '"';
		$dataCheck = $this->_db->execute($sqlCheck);
		
		if ($dataCheck) {
			
			if ($action == 1 && $dataCheck->count() === 1) {
				$sql = 'DELETE FROM watchify_flags WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID . ' AND videoID = "' . $videoID . '"';
				$data = $this->_db->execute($sql);

				if ($data) {
					return true;
				}
			} elseif ($action == 2 && $dataCheck->count() === 0) {
				$sql = 'INSERT INTO watchify_flags (id,userID,youtuberID,videoID) VALUES (NULL,"' . $userID . '","' . $youtuberID . '","' . $videoID . '")';
				$data = $this->_db->execute($sql);
	
				if ($data) {
					return true;
				}
			}

		}
		
		return false;
	}
	
	public function flagStatut($userID, $youtuberID, $videoID) {
		$sql = 'SELECT * FROM watchify_flags WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID . ' AND videoID = "' . $videoID . '"';
		
		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->count();
		}

		return false;
	}
	
	public function getVideoViews($videoID) {
		$JSON = file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=statistics&id=' . $videoID. '&key=AIzaSyCgoHF80QDHPjWN2V9uaQTJKWM2SEok0ZA');
		$json_data = json_decode($JSON, true);
		return $json_data['items'][0]['statistics']['viewCount'];
	}
	
	public function getVideoInfos($videoID, $field) {
		$sql = 'SELECT ' . $field . ' FROM watchify_videos WHERE videoID = "' . $videoID . '"';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->first()->$field;
		}

		return false;
	}

}



?>