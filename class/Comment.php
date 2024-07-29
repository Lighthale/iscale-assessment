<?php

// Defined namespace so that this class can be use in other classes
namespace Entity;

use Service\NewsManager;

class Comment
{
    // Set these properties as private so that it can only be access by its own class.
    // Also assign a type on these properties so make sure what type of values should expect
	// protected $id, $body, $createdAt, $newsId;

    private int $id;

    private string $body;

    private \DateTimeInterface $createdAt;

    // This can also be set as `News` Class/Entity type. I just make this int for this case.
    private int $newsId;


    // Added return type to getters and setters to ensure it returns the right type
    // Added type to setters' type on parameters
	// public function setId($id)
	public function setId(int $id): Comment // <- return type is an instance of Comment
	{
		$this->id = $id;

		return $this;
	}

	// public function getId()
	public function getId(): int
	{
		return $this->id;
	}


	// public function setBody($body)
	public function setBody(string $body): Comment
	{
		$this->body = $body;

		return $this;
	}

	// public function getBody()
	public function getBody(): string
	{
		return $this->body;
	}

    // ?\DateTimeInterface it's either type of the value is \DateTimeInterface or null
	// public function setCreatedAt($createdAt)
	public function setCreatedAt(?\DateTimeInterface $createdAt): Comment
	{
		$this->createdAt = $createdAt;

		return $this;
	}

    // ?\DateTimeInterface it's either type of the value is \DateTimeInterface or null
	// public function getCreatedAt()
	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->createdAt;
	}

	// public function getNewsId()
	public function getNewsId(): int
	{
		return $this->newsId;
	}

	// public function setNewsId($newsId)
	public function setNewsId(int $newsId): Comment
	{
		$this->newsId = $newsId;

		return $this;
	}

    // Added setter to accept News Object
    public function setNews(News $news): Comment
    {
        return $this->setNewsId($news->getId());
    }

    // Added getter to fetch comment's related news object
    public function getNews(): News
    {
        $newsManager = new NewsManager();

        return $newsManager->findOne($this->getNewsId());
    }
}