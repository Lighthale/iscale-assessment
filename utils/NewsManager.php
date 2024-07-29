<?php

// Defined namespace so that this class can be use in other classes
namespace Service;

// Use class by namespace
use DateTime;
use Entity\News;

// Extends DB class to inherit the codes on construct and PDO service
class NewsManager extends DB
{
    //	private static $instance = null;

    // Use Dependency Injection instead of singletons
    // private function __construct() {
    //     require_once(ROOT . '/utils/DB.php');
    //     require_once(ROOT . '/utils/CommentManager.php');
    //     require_once(ROOT . '/class/News.php');
    // }
    //
    //	public static function getInstance()
    //	{
    //		if (null === self::$instance) {
    //			$c = __CLASS__;
    //			self::$instance = new $c;
    //		}
    //		return self::$instance;
    //	}

	public function __construct() {
        parent::__construct();
	}

	/**
	* list all news
	*/
	public function listNews()
	{
        // Uses PDO of the parent class (DB)

		// $db = DB::getInstance();
		// $rows = $db->select('SELECT * FROM `news`');

        $rows = $this->pdo->query('SELECT * FROM `news`')->fetchAll();
		$news = [];

		foreach($rows as $row) {
			$n = new News();
			$news[] = $n->setId($row['id'])
			    ->setTitle($row['title'])
			    ->setBody($row['body'])
                // $createdAt property now requires DateTime type (See News.php)
			    // ->setCreatedAt($row['created_at']);
                ->setCreatedAt(new DateTime($row['created_at']))
            ;
		}

		return $news;
	}

	/**
	* add a record in news table
	*/
	// public function addNews($title, $body)
	public function addNews(string $title, string $body): News
	{
        // $db = DB::getInstance();
		// $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('". $title . "','" . $body . "','" . date('Y-m-d') . "')";
		// $db->exec($sql);
        // $this->db->exec($sql);

        // return $db->lastInsertId($sql);

        // Put the values in News object
        $news = new News();
        $news->setTitle($title)
            ->setBody($body)
            ->setCreatedAt(new DateTime())
        ;

        // Made parameterized SQL statements to avoid SQL injection
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES(:title, :body, :createdAt)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'title' => $news->getTitle(),
            'body' => $news->getBody(),
            'createdAt' => $news->getCreatedAt()->format('Y-m-d'),
        ]);

        $news->setId($this->pdo->lastInsertId());

		return $news;
	}

	/**
	* deletes a news, and also linked comments
	*/
//	public function deleteNews($id)
	public function deleteNews(News $news): void
	{
		// $comments = CommentManager::getInstance()->listComments();
		// $idsToDelete = [];

        // No need to delete comments manually since comment.news_id in the database are now defined to delete cascade (See dbdump.sql)
		// foreach ($comments as $comment) {
		// 	if ($comment->getNewsId() == $id) {
		// 		$idsToDelete[] = $comment->getId();
		// 	}
		// }

		// foreach($idsToDelete as $id) {
		//     CommentManager::getInstance()->deleteComment($id);
		// }

        // $db = DB::getInstance();
		// $sql = "DELETE FROM `news` WHERE `id`=" . $id;
		// return $db->exec($sql);
		// return $this->db->exec($sql);

        $statement = $this->pdo->prepare("DELETE FROM `news` WHERE `id` = :id");
        $statement->execute(['id' => $news->getId()]);
	}

    // Added method to fetch News by id
    public function findOne(int $id): News
    {
        $results = $this->pdo->query('SELECT * FROM `news` WHERE `id` = ' . $id)->fetch();
        $news = new News();
        $news->setId($results['id'])
            ->setTitle($results['title'])
            ->setBody($results['body'])
            ->setCreatedAt(new DateTime($results['created_at']))
        ;

        return $news;
    }
}
