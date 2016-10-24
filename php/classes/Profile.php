<?php
/**
 * this is going to be the cross section for Amazon reviews
 *
 *this Review can be considered a small example of what servies like Amazon use
 * @author Nathan A Sanchez
 * @v   ;yv;   ersion 1.0.0
 **/

		class Review {

			/**
			 * id for for this Review; this is the primary key
			 * @var int $reviewId
			 */
			private $reviewId;
			/**
			 * id of the Profile that sent this Review; this is a foreign key
			 * @var int $reviewProfileId
			 **/
			private $reviewProfileId;
			/**
			 * actual textual content of this Review
			 * @var string $reviewContent
			 **/
			private $reviewContent;
			/**
			 * date time this Review was sent, in PHP DateTime object
			 * @var \DateTime $reviewDate
			 */
			private $reviewDate;

			/**
			 * constructor
			 *
			 * @param int|null $newReviewId of this Review or null if a new Reveiw
			 * @param int $newReviewPeofileId id of the Profile that sent this Review
			 * @param string $newReviewContent string containing actual review data
			 * @param \DateTime|string|null $newReviewDate date and time Review was sent or null if set to current date and time
			 * @throws \InvalidArgumentException if data types are not valid
			 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
			 * @throws \TypeError if data types violate type hints
			 * @throws \Exception if other exception occurs
			 **/
			public function __construct(int $newReviewId = null, int $newReviewProfileId, string $newReviewContent, $newReveiwDate = null) {
				try {
					$this->setReviewId($newReviewId);
					$this->setReviewProfileId($newReviewProfileId);
					$this->setReviewContent($newReviewContent);
					$this->setReviewDate($newReveiwDate);
				} catch(\InvalidArgumentException $invalidArgument) {
					// rethrow the exception to the caller
					throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
				} catch(\RangeException $range) {
					//rethrow the exception to the caller
					throw(new \RangeException($range->getMessage(), 0, $range));
				} catch(\TypeError $typeError) {
					// rethrow the exception to the caller
					throw(new \TypeError($typeError->getMessage(), 0, $typeError));
				} catch(\Exception $exception) {
					// rethrow the exception to the caller
					throw(new \Exception($exception->getMessage(), 0, $exception));
				}


			}


			/**
			 * accessor method for review id
			 *
			 * @return int|null value of review id
			 **/
			public function getReviewId() {
				return ($this->reviewId);
			}

			/**
			 * mutator method for review id
			 *
			 * @param int|null $newReviewId new value of review id
			 * @throws \RangeException if $newReviewId is not positive
			 * @throws \TypeError if $newReviewId is not an integer
			 **/
			public function setReviewId(int $newReviewId = null) {
				if($newReviewId === null) {
					$this->reviewId = null;
					return;
				}

				// verify the review id is positive
				if($newReviewId <= 0) {
					throw(new \RangeException("review id is not positive"));
				}

				// convert and store the review id
				$this->reviewId = $newReviewId;

			}

			/**
			 *  accessor method for review profile id
			 *
			 * @return int value of review profile id
			 **/
			public function getReviewProfileId() {
				return ($this->reviewProfileId);
			}

			/**
			 * mutator method for Review profile id
			 *
			 * @param int $newReviewProfileId new value of Review profile id
			 * @throws \InvalidArgumentException if $newReviewContent is not a string or insecure
			 * @throws \RangeException if $newProfileId is not positive
			 * @throws \TypeError if $newProfileId is not an integer
			 **/
			public function setReviewContent(string $newReviewContent) {
				// verify the tweet content is secure
				$newReviewContent = trim($newReviewContent);
				$newReviewContent = filter_var($newReviewContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
				if(empty($newReviewContent) === true) {
					throw(new \InvalidArgumentException("review content is empty or insecure"));

				}

				// verify the tweet content will fit in the database
				if(strlen($newReviewContent) > 1000) {
					throw(new \RangeException("review content too large"));
				}
				// store the review content
				$this->reviewContent = $newReviewContent;
			}

			/**
			 * accessor method for review date
			 *
			 * @return \DateTime value of review date
			 **/
			public function getReviewDate() {
				return ($this->reviewDate);
			}

			/**
			 * mutator method for tweet date
			 *
			 * @param \DateTime|string|null $newReviewDate reveiw date as a DateTime object or string (or null to load the current time)
			 * @throws \InvalidArgumentException if $newReveiwDate is not a vaild object or string
			 * @throws \RangeException if $newReveiwDate is a date that does not exist
			 **/
			public function setReviewDate($newReviewDate = null) {
				// base case: if the date is null, use the current date and time
				if($newReviewDate = null) {
					$this->reviewDate = new \DateTime();
					return;
				}
				// store the review date
				try {
					$newReviewDate = self::validateDateTime($newReviewDate);
				} catch(\InvalidArgumentException $invalidArgument) {
//						throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $range));
					throw(new \InvalidArgumentException ("No date specified", 405));
				} catch(\RangeException  $range) {
					throw(new \RangeException($range->getMessage(), 0, $range));
				}
				$this->reviewDate = $newReviewDate;
			}

			/**
			 * inserts this Review into mySQL
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError if $pdo is not a PDO connection object
			 **/
			public function insert(\PDO $pdo) {
				// enforce the reviewId is null (i.e, don't insert a review that already exists)
				if($this->reviewId !== null) {
					throw(new \PDOException("not a new reveiw"));
				}

				// create query template
				$query = "INSERT INTO review(reviewProfileId, reviewContent, reviewDate) VALUES(:reviewProfile, :reveiwContent, :reveiwDate)";
				$statement = $pdo->prepare($query);

				// bind the member variables to the place holders in the template
				$formattedDate = $this->reviewDate->format("Y-m-d H:i:s");
				$parameters = ["reveiwProfileId" => $this->reviewProfileId, "reveiwContent" => $this->reviewContent, "tweetDate" => $formattedDate];
				$statement->execute($parameters);

				// update the null reviewId with what mySQL just gave us
				$this->reviewId = intval($pdo->lastInsertId());
			}


			/**
			 *  deletes this Review from mySQL
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when my SQL related errors occur
			 * @throws \TypeError if $pdo is not PDO connection object
			 **/
			public function delete(\PDO $pdo) {
				// enforce the reviewId is not null (i.e., don't delete review that hasn't been inserted)
				if($this->reviewId === null) {

					throw(new \PDOException("unable to delete a review that does not exist"));
				}
				// create query template
				$query = "DELETE FROM review WHERE reviewProfileId = :reviewId";
				$statement = $pdo->prepare($query);

				// bind the member variables to the place holder in the template
				$parameters = ["reviewId" => $this->reviewId];
				$statement->execute($parameters);
			}

			/**
			 * update this Reviw in mySQL
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when mySQL related errors eccur
			 * @throws \TypeError if $pdo is not PDO connection object
			 **/
			public function update(\PDO $pdo) {
				// enforce the reviewId is not null (i.e., don't update reveiw that hasn't been inserted)
				if($this->reviewId === null) {
					throw(new \PDOException("unable to update a review that does not exist"));
				}
				// create query template
				$query = "UPDATE review SET reviewProfileId = :reveiwProfileId, reviewContent = :reviewContent,
reviewDate = :reviewDate WHERE reviewId = :reviewId";
				// bind the member variables to the place holders in the template
				$formattedDate = $this->reviewDate->format("Y-m-d H:i:s");
				$parametes = ["reveiwProfileId" => $this->reviewId, "reviewContent" => $this->reviewContent, "
				reviewDate" => $formattedDate, "reveiwId" => $this->$this->reviewId];
			}

			/**
			 *gets the Reveiw by content
			 *
			 * @param \PDO $pdo PDO conncection object
			 * @param string $reviewContent review content to search for
			 * @return \SplFixedArray SplFixedArray of Reviews found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when variables are not the correct data type
			 **/
			public static function getReveiwByReveiwContent(\PDO $pdo, string $reviewContent) {
				// sanitize the description before searching
				$reviewContent = trim($reviewContent);
				$reviewContent = filter_var($reviewContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
				if(empty($reveiwContent) === true) {
					throw(new \PDOException("reveiw content is invalid"));

				}
				// create query template
				$query = "SELECT reviewId, reviewProfileId, reviewContent, reviewDate FROM review WHERE reviewContent LIKE :reviewContent";
				$statement = $pdo->prepare($query);

				// bind the review content to the place holder in the template
				$reviewContent = "%reviewContent%";
				$parameters = ["reviewContent" => $reviewContent];
				$statement->execute($parameters);

				// build an array of reviews
				$reviews = new \SplFixedArray($statement->rowCount());
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				while(($row = $statement->fetch()) !== false) {
					try {
						$reviews = new Review($row["reviewId"], $row["reveiwProfileId"], $row["reviewContent"], $row["reviewDate"]);
						$reviews[$reviews->key()] = $reviews;
						$reviews->next();
					} catch(\Exception $exception) {
						// if the row couldn't be converted, rethrow it
						throw(new \PDOException($exception->getMessage(), 0, $exception));
					}
				}
				return ($reviews);
			}

			/**
			 * gets the Review by reviewId
			 *
			 * @param \PDO $pdo PDO connection object
			 * @param int $reviewId review id to search for
			 * @return Review|null Review found or null if not found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when variables are not the correct data type
			 **/
			public static function getReviewbyReviewId(\PDO $pdo, int $review) {
				// sanitize the reviewId before searching
				if($review <= 0) {
					throw(new \PDOException("review id is not positve"));
				}

				//create query template
				$query = "SELECT reviewId, reviewProfileId, reviewContent, ReviewDate FROM review WHERE reviewId =reviewId";
				$statement = $pdo->prepare($query);

				// bind the review id to the place holder in the template
				$parameters = ["reviewId" => $review];
				$statement->execute($parameters);

				// grab the review from mySQL
				try {
					$review = null;
					$statement->setFetchMode(\PDO::FETCH_ASSOC);
					$row = $statement - fetch();
					if($row !== false) {
						$tweet = new Review($row["reviewId"], $row["reviewProfileId"], $row["reveiewContent"], $row["reviewDate"]);
					}
				} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
				return ($review);
			}

			/**
			 * gets the Review by profile id
			 *
			 * @param \PDO $pdo PDO connection object
			 * @param int $reviewProfileId profile id to search by
			 * @return \SplFixedArray SplFixedArray of Review found
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError when variables are not correct data type
			 **/
			public static function getReviewbyReviewProfileId(\PDO $pdo, int $reviewProfileId) {
				// sanitize the profile id before searching
				if($reviewProfileId <= 0) {
					throw(new \RangeException("review profile id must be positive"));
				}

				// create query template
				$query = "SELECT reviewId, reviewProfileId, reviewContent, reviewDate FROM review WHERE  :reviewProfile";
				$statement = $pdo->prepare($query);

				// bind the review profile id to the place holder in the template
				$parameters = ["reviewProfileId" => $reviewProfileId];
				$statement->execute($parameters);

				// build an array of reviews
				$review = new \SplFixedArray($statement->rowCount());
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				while(($row = $statement->fetch()) !== false) {
					try {
						$review = new Review($row ["reviewId"], $row ["reviewProfileId"], $row["reviewContent"], $row["reviewDate"]);
						$reviews[$reviews->key()] = $review;
						$reviews->next();
					} catch(\Exception $exception) {
						// if the row couldn't be converted, rethrow it
						throw(new\PDOException($exception->getMessage(), 0, $exception));
					}
				}
				return ($review);
			}
		}


		$testreview = new Review(null, 39, "@nathan sanchez", new\DateTime());
