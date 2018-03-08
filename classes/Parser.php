<?php

/**
* Parser Class
* 
* 10 clés :
* 35 Youtubers = 55% du quota
* 63 Youtubers = 100% du quota
* 
* 10 clés = 63 Youtubers
* 31 clés = 200 Youtubers
* 
*/

class Parser {

	//watchify-key1
	private $key1 = 'AIzaSyDh_umIHkhkNSljfAuoC5tCMFYi03iMgQ4';
	
	private $key13 = 'AIzaSyBWFGumFcxXibR1Rn61ls4naR5oROOtg7k';
	private $key14 = 'AIzaSyBlPFgFcKzRorjrHGtuat3r-Os9lwIXAog';
	private $key15 = 'AIzaSyCc2eRQrN18IZkkq_t9DaqgBb-R9AK8qwY';
	private $key16 = 'AIzaSyC-sxNVEKQs-HxF91ccRuOJFvSOAetKWG4';
	private $key17 = 'AIzaSyBSn6YICJ9qfducCqWnd3IET9VcI7hBPxs';
	private $key18 = 'AIzaSyC5X3edFI5GdexWdTX-rkrfAgPQ4Lvavek';
	private $key19 = 'AIzaSyCrjB2l-88BvV8fmwuT7g6fE_V32rYNgSI';
	private $key20 = 'AIzaSyCxp6CQFbg0ftOwIBOb1kvcWNiQj7vCRh4';
	private $key21 = 'AIzaSyDfMAeZBPXQ8LhIYmcvzNmAoO8p0KRRUfU';
	private $key22 = 'AIzaSyDNE8hMYbRY7Q5gO2-WpPiKcoM24Y9stYs';
	private $key23 = 'AIzaSyB17ZWFkqyw58lrRl0TsGbjZ9BAL4Rt83I';
	private $key24 = 'AIzaSyCqA_-0D-x_G9h1Q82NH7bIpmeVe5_90-U';
	private $key25 = 'AIzaSyC_Ish1CovsP3AlZ8wW_YRn-sJNdA-NtWI';
	private $key26 = 'AIzaSyBF-PKvkGUk6GLYezavC_D_uf9xGVylHE4';
	private $key27 = 'AIzaSyDNwPAfjaFC7oWmTvM2KY6D0g-9ngYE4-k';
	private $key28 = 'AIzaSyDB4LGhSHWKxihTgf9sq22-Zcm_CpoVvmE';
	private $key29 = 'AIzaSyB8QdAmk-G9xW-CYMTmXG39umZEhk8oePk';
	private $key30 = 'AIzaSyAivH_yj4G_QWCrQOo5Zsd8PudUoz5tpAc';

	//watchify-key2
	private $key2 = 'AIzaSyAxf4oFrAQg-iZ3q1R3fBWcUTbTJcc97tM';
	
	private $key31 = 'AIzaSyBwCvAyqnabc36RS420W1egcVj3P4ECRo8';
	private $key32 = 'AIzaSyDtunkqrNKCEDku_9jRX3FZH5hvUJzVl2I';
	private $key33 = 'AIzaSyAcvxKU6YTae17UhyqNuYe4bOPcNS-ggkM';
	private $key34 = 'AIzaSyB2dvvG8GRol7buIsghXwsHw8AIkIJGXgI';
	private $key35 = 'AIzaSyCy5P1WnB_Z0JX-Ixxl-YKgOooMCGZ9fHc';
	private $key36 = 'AIzaSyDzmQpRCeXQq8tL7oP12D82FvFasEOsN9U';
	private $key37 = 'AIzaSyCe8JFadQbrG1MYZmHueVB1kTW_SI-8grc';
	private $key38 = 'AIzaSyAler4p1T6ZBueJe9HJE-YubW67XSHJl4c';
	private $key39 = 'AIzaSyCEbNTdFjSxTtiGPvbWnDDNyIfrzw-dhs0';
	private $key40 = 'AIzaSyCzXeVmpgJuTDiFqvERi3nyiIcYt85fZ1I';
	
	//watchify-key3
	private $key3 = 'AIzaSyCwCwG4uWUPxNLIf-6HfL8yPgcCSp_49ao';
	
	//watchify-key4
	private $key4 = 'AIzaSyAlEdXYjuMHf-ptcEC2MuchqCabwNc_NZM';
	
	//watchify-key5
	private $key5 = 'AIzaSyCQbwGVxmmzYCPqh2ScfU8lPdKu5yuHeZs';
	
	//watchify-key6
	private $key6 = 'AIzaSyD_kRPDrhdfw2nemPEGGEPlSxym51x_5B0';
	
	//watchify-key7
	private $key7 = 'AIzaSyCgoHF80QDHPjWN2V9uaQTJKWM2SEok0ZA';
	
	//watchify-key8
	private $key8 = 'AIzaSyAMDQ0vYsQf6oElTk4q4KA3n9yqqakDicg';
	
	//watchify-key9
	private $key9 = 'AIzaSyCeRxtIb93bjd0y5YyyEqsBP099HF1QzQ8';
	
	//watchify-key10
	private $key10 = 'AIzaSyBGdUWaDiEbLZJqWEyHByZqfSRKoWDCykY';
	
	//watchify-key11
	private $key11 = 'AIzaSyCSWzNNTO5Q0FOospXcZ8xkmpmUgDco9Yc';
	
	//watchify-key12
	private $key12 = 'AIzaSyC1h6MScQiRQ8oqYIz5a_dWr5VArE0qnuk';
	
	
	private $maxResults = 1;
	private $orderBy = 'date';
	
	private $_db;
	
	public function __construct() {
		$this->_db = DB::getInstance();
	}
	
	public function youtubersCount() {
		$sql = 'SELECT * FROM watchify_youtubers WHERE channelID LIKE "UC%"';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->count();
		}

		return false;
	}
	
	public function getJSON($channelID, $modulo) {
		
		switch ($modulo) {
			case 0:
				$usedKey = $this->key1;
				break;
			case 1:
				$usedKey = $this->key2;
				break;
			case 2:
				$usedKey = $this->key3;
				break;
			case 3:
				$usedKey = $this->key4;
				break;
			case 4:
				$usedKey = $this->key5;
				break;
			case 5:
				$usedKey = $this->key6;
				break;
			case 6:
				$usedKey = $this->key7;
				break;
			case 7:
				$usedKey = $this->key8;
				break;
			case 8:
				$usedKey = $this->key9;
				break;
			case 9:
				$usedKey = $this->key10;
				break;
			case 10:
				$usedKey = $this->key11;
				break;
			case 11:
				$usedKey = $this->key12;
				break;
				
			case 12:
				$usedKey = $this->key13;
				break;
			case 13:
				$usedKey = $this->key14;
				break;
			case 14:
				$usedKey = $this->key15;
				break;
			case 15:
				$usedKey = $this->key16;
				break;
			case 16:
				$usedKey = $this->key17;
				break;
			case 17:
				$usedKey = $this->key18;
				break;
			case 18:
				$usedKey = $this->key19;
				break;
			case 19:
				$usedKey = $this->key20;
				break;
			case 20:
				$usedKey = $this->key21;
				break;
			case 21:
				$usedKey = $this->key22;
				break;
			case 22:
				$usedKey = $this->key23;
				break;
			case 23:
				$usedKey = $this->key24;
				break;
			case 24:
				$usedKey = $this->key25;
				break;
			case 25:
				$usedKey = $this->key26;
				break;
			case 26:
				$usedKey = $this->key27;
				break;
			case 27:
				$usedKey = $this->key28;
				break;
			case 28:
				$usedKey = $this->key29;
				break;
			case 29:
				$usedKey = $this->key30;
				break;
				
			case 30:
				$usedKey = $this->key31;
				break;
			case 31:
				$usedKey = $this->key32;
				break;
			case 32:
				$usedKey = $this->key33;
				break;
			case 33:
				$usedKey = $this->key34;
				break;
			case 34:
				$usedKey = $this->key35;
				break;
			case 35:
				$usedKey = $this->key36;
				break;
			case 36:
				$usedKey = $this->key37;
				break;
			case 37:
				$usedKey = $this->key38;
				break;
			case 38:
				$usedKey = $this->key39;
				break;
			case 39:
				$usedKey = $this->key40;
				break;
		}
		
		$URL = 'https://www.googleapis.com/youtube/v3/search?key=' . $usedKey . '&channelId=' . $channelID . '&part=snippet,id&order=' . $this->orderBy . '&maxResults=' . $this->maxResults;
		$content = file_get_contents($URL);
		return (!empty($content)) ? $content : false ;
	}
	
	
	
	public function getYoutuberInfos($youtuberID, $field) {
		$sql = 'SELECT ' . $field . ' FROM watchify_youtubers WHERE id = ' . $youtuberID;

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->first()->$field;
		}

		return false;
	}
	
	public function getVideoInfos($youtuberID, $field) {
		$sql = 'SELECT ' . $field . ' FROM watchify_videos WHERE youtuberID = ' . $youtuberID . ' ORDER BY uploaded DESC';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return $data->first()->$field;
		}

		return false;
	}

	public function addVideo($youtuberID, $URL, $videoID, $title, $date) {
		$sql = 'INSERT INTO watchify_videos (id,youtuberID,URL,videoID,title,uploaded,added) VALUES (NULL,"' . $youtuberID . '","' . $URL . '","' . $videoID . '","' . $title . '","' . $date . '","' . date('Y-m-d H:i:s') . '")';

		$data = $this->_db->execute($sql);

		if ($data) {
			return true;
		}

		return false;
	}
	
	
	
	/*
	************************************
		PARSER.PHP
	************************************
	*/
	
	public function removeVideosWithoutVideoID() {
		$sql = 'DELETE FROM watchify_videos WHERE videoID = ""';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}

	public function removeDuplicatesByVideoID() {
		$sql = 'DELETE FROM watchify_videos WHERE id NOT IN (SELECT id FROM (SELECT max(id) id FROM watchify_videos GROUP BY videoID) as temp)';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}
	
	public function removeDuplicatesByTitle() {
		$sql = 'DELETE FROM watchify_videos WHERE id NOT IN (SELECT id FROM (SELECT max(id) id FROM watchify_videos GROUP BY title) as temp)';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}
	
	public function removeDuplicatesBadges() {
		$sql = 'DELETE FROM watchify_badges WHERE id NOT IN (SELECT id FROM (SELECT max(id) id FROM watchify_badges GROUP BY videoID) as temp)';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}

	
	/*
	************************************
		RESET.PHP
	************************************
	*/
	
	public function dropColumn() {
		$sql = 'ALTER TABLE watchify_videos DROP id';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}

	public function setAutoIncrement() {
		$sql = 'ALTER TABLE watchify_videos AUTO_INCREMENT = 1';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}

	public function reInsertVideos() {
		$sql = 'ALTER TABLE watchify_videos ADD id int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST';

		$data = $this->_db->execute($sql);

		if ($data->count()) {
			return true;
		}

		return false;
	}
	

}


?>