<?php

/**
* User Class
*/
class User {

	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;
	
	public function __construct($user = null) {
		$this->_db = DB::getInstance();

		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');


		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);

				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					//process logout
				}
			}
		} else {
			$this->find($user);
		}

	}
	
	public function update($fields = array(), $id = null) {

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if (!$this->_db->update('watchify_users', $id, $fields)) {
			throw new Exception('Problem updating an account');
		}
	}

	public function create($fields = array()) {
		if (!$this->_db->insert('watchify_users', $fields)) {
			throw new Exception('Problem creating an account');
		}
	}

	public function find($user = null) {
		if ($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('watchify_users', array($field, '=', $user));

			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false) {
		
		
		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->find($username);
			
			if ($user) {
				if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->id);
					
					if ($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('watchify_sessions', array('user_id', '=', $this->data()->id));

						if (!$hashCheck->count()) {
							$this->_db->insert('watchify_sessions', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}

						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));

					}

					return true;
				}
			}
		}

		return false;
	}
	
	public function updateLastConnection($userID) {
		$sql = 'UPDATE watchify_users SET last_seen = "' . date('Y-m-d H:i:s') . '" WHERE id = ' . $userID;

		$data = $this->_db->execute($sql);

		if ($data) {
			return true;
		}

		return false;
	}

	public function hasPermission($key) {
		$group = $this->_db->get('watchify_groups', array('id', '=', $this->data()->group_id));
		
		if ($group->count()) {
			$permissions = json_decode($group->first()->permissions, true);

			if ($permissions[$key] === 1) {
				return true;
			}

		}
		return false;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	public function logout() {

		$this->_db->delete('watchify_sessions', array('user_id', '=', $this->data()->id));

		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	
	public function delete($id) {
		$this->_db->delete('watchify_users', array('id', '=', $id));
	}
	
	public function getUsers($start, $usersPerPage) {
		$sql = 'SELECT * FROM watchify_users ORDER BY last_seen DESC LIMIT ' . $start . ', ' . $usersPerPage;

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->results();
		}

		return false;
	}
	
	public function followAction($userID, $youtuberID, $action) {
		$sqlCheck = 'SELECT * FROM watchify_followings WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID;
		$dataCheck = $this->_db->execute($sqlCheck);

		if ($dataCheck) {

			if ($action === '1' && $dataCheck->count() === 0) {		
				$sql = 'INSERT INTO watchify_followings (id,userID,youtuberID,date) VALUES (NULL,"' . $userID . '","' . $youtuberID . '","' . date('Y-m-d H:i:s') . '")';
				$data = $this->_db->execute($sql);

				if ($data) {
					return true;
				}
			} elseif ($action === '2' && $dataCheck->count() === 1) {
				$sql = 'DELETE FROM watchify_followings WHERE userID = "' . $userID . '" AND youtuberID = "' . $youtuberID . '";
								DELETE FROM watchify_badges WHERE userID = "' . $userID . '" AND youtuberID = "' . $youtuberID . '"';
				$data = $this->_db->execute($sql);

				if ($data) {
					return true;
				}
			}
			
		}

		return false;
	}
	
	public function markVideo($userID, $youtuberID, $videoID, $action) {
		$sqlCheck = 'SELECT * FROM watchify_badges WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID . ' AND videoID = "' . $videoID . '"';
		$dataCheck = $this->_db->execute($sqlCheck);
		
		if ($dataCheck) {
			
			if ($action == 1 && $dataCheck->count() === 1) {
				$sql = 'DELETE FROM watchify_badges WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID . ' AND videoID = "' . $videoID . '"';
				$data = $this->_db->execute($sql);

				if ($data) {
					return true;
				}
			} elseif ($action == 2 && $dataCheck->count() === 0) {
				$sql = 'INSERT INTO watchify_badges (id,userID,youtuberID,videoID) VALUES (NULL,"' . $userID . '","' . $youtuberID . '","' . $videoID . '")';
				$data = $this->_db->execute($sql);
	
				if ($data) {
					return true;
				}
			}

		}
		
		return false;
	}
	
	public function getUserIDwhoFollowYoutuberID($youtuberID) {
		$sql = 'SELECT userID FROM watchify_followings WHERE youtuberID = ' . $youtuberID;

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->results();
		}

		return false;
	}
	
	public function addBadge($userID, $youtuberID, $videoID) {
		$sql = 'INSERT INTO watchify_badges (id,userID,youtuberID,videoID) VALUES (NULL,"' . $userID . '","' . $youtuberID . '","' . $videoID . '")';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}
	
	public function removeBadge($userID, $youtuberID, $videoID) {
		$sql = 'DELETE FROM watchify_badges WHERE userID = ' . $userID . ' AND youtuberID = ' . $youtuberID . ' AND videoID = "' . $videoID . '"';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}

	public function data() {
		return $this->_data;
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

}
