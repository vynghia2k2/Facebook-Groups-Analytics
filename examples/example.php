<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once '../FbStats.php';

if( ! session_id()) session_start();

$config = array(
	'appId' => '203197653102145',
	'secret' => '592c7f0630ce83f943c7645384d1e7f5',
	'permissionsArray' => array(
		'publish_stream',
		'read_stream',
		'offline_access',
		'user_groups'
	),
	'afterLoginUrl' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
);

// Nagpur PHP User group
$ngpPhpUserGroupId = '107329506051213';

$fb = new FbStats($config);
// will give you any feed (you must have permissions to access), just pass right id
// write 'me' in parameter and you shall get users who wrote on your wall
$feedParams = array(
    'source_id' => $ngpPhpUserGroupId,
    'limit' => 500
);
//get Group Feed
$groupFeed = $fb->getFeed($feedParams);
// totalStatusChars - counts total characters of status updates
//$users 	   = $fb->getTopUsers($groupFeed, 'totalStatusChars', 5);
//
// totalLinks - counts number of links posted by users
$users 	   = $fb->getTopUsers($groupFeed, 'didComment', 5);

?>
<pre><?php //var_dump($users);exit;?></pre>
<table cellspacing="5">
<!-- table head -->
<?php $count = 0; ?>
<?php foreach($users as $user) : ?>
<?php if ($count++ > 0) break; ?>
	<tr>
    <?php foreach ($user as $stat => $value): ?>
        <?php if ($stat == 'id' ): ?>
            <th>Image</th>
        <?php else: ?>
            <th><?php echo $stat;?></th>
        <?php endif; ?>
    <?php endforeach; ?>
	</tr>
<?php endforeach; ?>
<!-- table body -->
<?php foreach($users as $user) : ?>
	<tr>
    <?php foreach ($user as $stat => $value): ?>
        <?php if ($stat == 'id' ): ?>
            <td><img src="https://graph.facebook.com/<?php echo $value;?>/picture" /></td>
        <?php else: ?>
            <td><?php echo $value;?></td>
        <?php endif; ?>
    <?php endforeach; ?>
	</tr>
<?php endforeach; ?>
</table>