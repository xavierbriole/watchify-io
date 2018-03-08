<?php

include_once 'cnx.php';

if (isset($_GET['motclef']) && isset($_GET['myID']) && !empty($_GET['motclef']) && !empty($_GET['myID'])) {
  
  $myID = $_GET['myID'];
  $motclef = $_GET['motclef'];
  
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
              WHERE f.userID = ' . $myID . ' AND f.youtuberID = y.id) as followed, 
              (SELECT COUNT(*) FROM watchify_followings WHERE youtuberID = y.id) as pop 
            FROM watchify_youtubers y 
            WHERE (y.username LIKE "%' . str_replace(' ', '', $motclef) . '%" OR y.name LIKE "%' . $motclef . '%") 
            ORDER BY pop DESC';

  $req = $cnx->prepare($sql);
  $req->execute();
  $count = $req->rowCount($sql);
  ?>
  
  
  
  <ul class="collection">
  <?php if ($count >= 1) { ?>

    <?php while ($result = $req->fetch(PDO::FETCH_OBJ)) { ?>    
      <li class="collection-item avatar search">
      <img src="<?php echo $result->profileIMG; ?>" alt="" class="circle">
      <span class="title"><?php echo $result->name; ?></span>
      <span class="subtitle"><?php echo $result->pop; ?> followers</span>

        <button type="submit" class="tooltipped add-button-<?php echo $result->id; ?>" data-position="left" data-delay="10" data-tooltip="Follow" onclick="followAction(<?php echo $myID; ?>, <?php echo $result->id; ?>, '<?php echo addslashes($result->name); ?>', 1, event)" <?php echo ($result->followed == 0 ? '' : 'style="display: none;"'); ?>>
          <i class="material-icons">add</i>
        </button>
        <span class="del-button-<?php echo $result->id; ?>" style="margin-right: 5px; <?php echo ($result->followed == 0 ? 'display: none;' : ''); ?>">
          <i class="material-icons">done</i>
        </span>
      
      </li>
    <?php } ?>

  <?php } else { ?>
      <li class="collection-item avatar search-no-result">
      <i class="material-icons">close</i>
      <span class="search-title">No result found !</span>
      </li>
  <?php } ?>
    </ul>



<?php } ?>