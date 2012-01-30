<?php

/**
 * Část modelu starající se o práci s komentáři
 *
 * @author   Jan Tvrdík
 */
class CommentsService extends Nette\Object
{

	/** @var     DibiConnection */
	private $db;

	/**
	 * Class constructor
	 *
	 * @param    DibiConnection
	 */
	public function __construct(DibiConnection $db)
	{
		$this->db = $db;
	}

	/**
	 * Adds a new comment.
	 *
	 * @param    int
	 * @param    string            author's name
	 * @param    string            comment text
	 * @return   void
	 */
	public function addComment($articleId, $author, $text)
	{
		$this->db->query('INSERT INTO [comments]', array(
			'articleId' => $articleId,
			'date' => new DateTime('now'),
			'author' => $author,
			'text' => $text
		));
	}

	/**
	 * Removes a comment.
	 *
	 * @param    int
	 * @return   void
	 */
	public function removeComment($id)
	{
		$this->db->query('
			DELETE FROM [comments]
			WHERE [id] = %i', $id
		);
	}

	/**
	 * Returns an array of comments for given article.
	 *
	 * @param    int
	 * @return   array (# => DibiRow)
	 */
	public function getComments($articleId)
	{
		return $this->db->fetchAll('
			SELECT * FROM [comments]
			WHERE [articleId] = %i', $articleId
		);
	}

}