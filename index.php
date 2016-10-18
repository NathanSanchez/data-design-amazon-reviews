<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title>data design for amazon reviews</title>
	</head>
	<body>
		<header>Nathan is one cool dude - nathan sanchez</header>
		<h1>Tom Crops</h1>
		<img src="img/wild-man-looking-confused-banana-28747201.jpg" alt="Tom Crops"/>
		<p> My persona is gonna be named Tom Crops Tom is a a young man who wants to buy things on amazon,Tom is 22 5'8 avreage looks ,single, Tom manily uses his home pc his internet provieder is comcast :c he sometime uses his phone to shop around on amamazon. Tom works hard and has bought so many things on amazon and left so many reviews that amazon made him a prproduct tester and offical reviewer </p>

		<h1>use case</h1>

		<p>Tom Crops uses amazon to shop he loves shopping he can find anything on amazon he often looks for good deals on toys and such so he can send them to his sisters kids her kids dont have alot of toys and tom likes giving them toys because he likes to see them happy. sometimes Tom looks for new clothes for himself on amazon he always trys to find good deals on some sick new clothes which hes pretty good at.</p>

		<h1>action flow</h1>

		<p>Tom looking for some shoes, goes to amazon.com goes to search bar types in cool shoes 876 results are found. Tom starts scrolling down the web page looking at all the cool shoes finds a pair of shoes he likes double clicks on them decied that the shoes are right for him adds them to cart clicks on payment all the credit card info boxes pop up he enters his card info then he adds his address with toms amazon prime account he gets 2 day free shipping. fast forword 2 days and tom gets his new kicks hes pretty hype about them puts them on instantly he feels like a new man tom feels so good he goes back to the page for his cool shoes and scrolls down to the review section begains typing out one of toms hella good reviews leaves a 5 star rating</p>

		<h1>identify entities</h1>
		<!--if it looks like i dont know what im doing well your right cause i dont 6-->
		<p>comment section 1-5 star button user profile name </p>

		<h1>entities</h1>
		<ul>

			<li>productID (primary)</li>
			<li>profileID(primary)</li>
			<li>reviewID(weak)</li>

		</ul>


		<h1>attributes</h1>
		<ul>

			<li>productName</li>
			<li>productPrice</li>
			<li>productQuantity</li>
			<li>profileName</li>
			<li>profilePicture</li>
			<li>reviewStars</li>
			<li>reviewContent</li>
			<li>reviewDateTime</li>

		</ul>
		<h1>relationships</h1>
		<ul>

			<li>product has a many to many relationship</li>
			<li>review has a many to many relationships</li>
			<li>profile has a one to one</li>

		</ul>



	</body>









</html>

<?php
/**
 * Created by PhpStorm.
 * User: nathansanchez
 * Date: 10/12/16
 * Time: 11:27 AM
 */