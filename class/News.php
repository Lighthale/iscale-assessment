<?php

// Defined namespace so that this class can be use in other classes
namespace Entity;

use Service\CommentManager;

class News
{
    // Set these properties as private so that it can only be access by its own class.
    // Also assign a type on the properties just to make sure what type of values should expect
	// protected $id, $title, $body, $createdAt;

    private int $id;

    private ?string $title; // Can be null or string type

    private string $body;

    private ?\DateTimeInterface $createdAt; // Can be null or \DateTimeInterface type

    // Added return type to getters and setters to ensure it returns the right type
    // Added type to setters' type on parameters
	// public function setId($id)
	public function setId(int $id): News // <- return type is an instance of News
	{
		$this->id = $id;

		return $this;
	}

	// public function getId()
	public function getId(): int
	{
		return $this->id;
	}

	// public function setTitle($title)
	public function setTitle(?string $title): News
	{
		$this->title = $title;

		return $this;
	}

	// public function getTitle()
	public function getTitle(): ?string
	{
		return $this->title;
	}

	// public function setBody($body)
	public function setBody(string $body): News
	{
		$this->body = $body;

		return $this;
	}

	// public function getBody()
	public function getBody(): string
	{
		return $this->body;
	}

	// public function setCreatedAt($createdAt)
	public function setCreatedAt(?\DateTimeInterface $createdAt): News
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	// public function getCreatedAt()
	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->createdAt;
	}

    // Refactor: Get News' Comments
    public function getComments()
    {
        $commentManager = new CommentManager();

        return $commentManager->getNewsComments($this);
    }
}