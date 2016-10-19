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

			// CONSTUCTOR GOES HERE LATES



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
			 *@param int|null $newReviewId new value of review id
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
				return($this->reviewProfileId);
			}
			/**
			 * mutator method for Review profile id
			 *
			 *@param int $newReviewProfileId new value of Review profile id
			 *@throws \RangeException if $newProfileId is not positive
			 *@throws \TypeError if $newProfileId is not an integer
			 **/



		}
