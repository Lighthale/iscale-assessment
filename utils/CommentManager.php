<?php

// Defined namespace so that this class can be use in other classes
namespace Service;

// Use class by namespace
use DateTime;
use Entity\Comment;
use Entity\News;

class CommentManager extends DB
{
	// private static $instance = null;

	// private function __construct()
	// {
	// 	    require_once(ROOT . '/utils/DB.php');
	// 	    require_once(ROOT . '/class/Comment.php');
	// }

	// public static function getInstance()
	// {
	// 	    if (null === self::$instance) {
	// 	    	$c = __CLASS__;
	// 	    	self::$instance = new $c;
	// 	    }
	// 	    return self::$instance;
	// }

    public function __construct() {
        parent::__construct();
    }

    // Method not used anymore. See News::getComments() and CommentManager::getNewsComments()
	// public function listComments()
	// {
	// 	$db = DB::getInstance();
	// 	$rows = $db->select('SELECT * FROM `comment`');

	// 	$comments = [];
	// 	foreach($rows as $row) {
	// 		$n = new Comment();
	// 		$comments[] = $n->setId($row['id'])
	// 		    ->setBody($row['body'])
    //             // $createdAt property now requires DateTime type (See Comment.php)
	// 		    //->setCreatedAt($row['created_at'])
	// 		    ->setCreatedAt(new DateTime($row['created_at']))
	// 		    ->setNewsId($row['news_id'])
    //         ;
	// 	}

	// 	return $comments;
	// }

	public function addCommentForNews(string $body, News $news): Comment
	{
		// $db = DB::getInstance();
		// $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES('". $body . "','" . date('Y-m-d') . "','" . $newsId . "')";
		// $db->exec($sql);
		// return $db->lastInsertId($sql);

        // $this->db->exec($sql);
        // return $this->db->lastInsertId($sql);

        // Put the values in News object
        $comment = new Comment();
        $comment->setBody($body)
            ->setCreatedAt(new DateTime())
            ->setNews($news)
        ;

        // Made parameterized SQL statements to avoid SQL injection
        $sql = "INSERT INTO `comment` (`body`, `news_id`, `created_at`) VALUES(:body, :newsId, :createdAt)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'body' => $comment->getBody(),
            'newsId' => $comment->getNews()->getId(),
            'createdAt' => $comment->getCreatedAt()->format('Y-m-d'),
        ]);

        $comment->setId($this->pdo->lastInsertId());

        return $comment;
	}

	public function deleteComment(Comment $comment): void
	{
		// $db = DB::getInstance();
		//$sql = "DELETE FROM `comment` WHERE `id`=" . $id;
		// return $db->exec($sql);
		//return $this->db->exec($sql);

        $statement = $this->pdo->prepare("DELETE FROM `comment` WHERE `id` = :id");
        $statement->execute(['id' => $comment->getId()]);
	}

    // Added get all comments by news ID
    public function getNewsComments(News $news): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM `comment` WHERE `news_id` = :newsId');
        $statement->execute(['newsId' => $news->getId()]);
        $results = $statement->fetchAll();
        $comments = [];

        foreach ($results as $result) {
            $comment = new Comment();
            $comment->setId($result['id']);
            $comment->setBody($result['body']);
            $comment->setNewsId($result['news_id']);
            $comments[] = $comment;
        }

        return $comments;
    }
}