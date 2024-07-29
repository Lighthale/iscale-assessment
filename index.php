<?php

// Call them by its defined namespace instead of require
define('ROOT', __DIR__);
require_once(ROOT . '/utils/DB.php');
require_once(ROOT . '/utils/NewsManager.php');
require_once(ROOT . '/utils/CommentManager.php');
require_once(ROOT . '/class/News.php');
require_once(ROOT . '/class/Comment.php');

// Use class by namespace
use Service\DB;
use Service\CommentManager;
use Service\NewsManager;

$commentManager = new CommentManager();
$newsManager = new NewsManager($commentManager); // Dependency injection instead of using singletons (Class::method())

// foreach (NewsManager::getInstance()->listNews() as $news) {
foreach ($newsManager->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");

    // Just get the comments by news id
    // Fetching all comments on every iteration would cause performance issues when there are huge amount of records
	// foreach (CommentManager::getInstance()->listComments() as $comment) {
	//     if ($comment->getNewsId() == $news->getId()) {
	//         echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
	//     }
	// }

    foreach ($news->getComments() as $comment) {
        echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
    }
}

// No sense to retain these lines if we are not going to display them
// $commentManager = CommentManager::getInstance();
// $c = $commentManager->listComments();
