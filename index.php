<style>
#discord-window { height: 300px; overflow: hidden; width: 250px; }
#discord-scrollable { height: 260px;overflow: auto; }
#discord-scrollable ul { list-style: none; padding: 0; margin: 0; font-size: 13px; line-height:22px; }
#discord-scrollable ul img{ border-radius: 50%; }
#discord-onlinecount{ text-align: left; font-size: 14px; margin-bottom: 10px; }
#discord-scrollable::-webkit-scrollbar { width: 0px; }
#discord-footer { height: 35px; margin-top: 5px; text-align: center; border-color: #1a1a1a; border-width: 2px; border-style: solid; }
#discord-footer a{ line-height:32px; text-align: center; text-decoration: none; }
</style>


<?php

$data = file_get_contents('https://discordapp.com/api/guilds/252132679212990465/widget.json');
$data = json_decode($data, true);

$discord['name'] = $data['name'];
$discord['invite'] = $data['instant_invite'];

$staff = ['LuckyBowers','MFN','LamboCreeper','Turb0Bacon','Maeyrl','DrunkRussianBear'];

foreach ($data['channels'] as $channel){
  $discord['channels'][$channel['position']] = $channel['name'];
}

foreach ($data['members'] as $index=>$member){
  if (!$member['bot']){
    if (in_array($member['username'], $staff)){
      $discord['admins'][$index]['username'] = $member['username'];
      $discord['admins'][$index]['disc'] = $member['discriminator'];
      $discord['admins'][$index]['avatar'] = $member['avatar_url'];
      $discord['admins'][$index]['status'] = $member['status'];
    }else{
      $discord['members'][$index]['username'] = $member['username'];
      $discord['members'][$index]['disc'] = $member['discriminator'];
      $discord['members'][$index]['avatar'] = $member['avatar_url'];
      $discord['members'][$index]['status'] = $member['status'];
    }
  }
}

$discord['online'] = count($discord['members']);

?>


<div class="widget">
  <div id="discord-window">

    <div id="discord-scrollable">
      <p id="discord-onlinecount"><?php echo $discord['online']; ?> Members Online..</p>
      <ul>
        <?php
        foreach ($discord['members'] as $member){
          $username = $member['username'];
          $avatar = $member['avatar'];
          echo "<li><img src='$avatar' height='22px'> $username</li>";
        }
        foreach ($discord['admins'] as $member) {
          $username = $member['username'];
          $avatar = $member['avatar'];
          echo "<li><img src='$avatar' height='22px'> <span class='lb-text-red'>ADMIN</span> $username</li>";
        }
        ?>
      </ul>
    </div>

    <div id="discord-footer">
      <a href="<?php echo $discord['invite']; ?>">Connect</a>
    </div>

  </div>
</div>
