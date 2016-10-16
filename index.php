
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Secret Of The Day</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<?php
	        //starting session here
		session_start();
		// require the autoload file
		require_once __DIR__.'/vendor/autoload.php';

		$fb = new Facebook\Facebook([

				'app_id' => '939588279519035',
				'app_secret' => 'a8d78a6108b9303f0af40c9ffb3f3429',
				'default_graph_version' => 'v2.8'
			]);
		$redirect = "http://promahbub.com/fblogin/";
		$helper = $fb->getRedirectLoginHelper();

		try{
			$access_token = $helper->getAccessToken();
		}catch(Facebook\Exceptions\FacebookResponseException $e){
			// When graph returns and error
			echo "Graph Returns an Error". $e->getMessage();
			exit;
		}
		catch(Facebook\Exceptions\FacebookSDKException $e){
			// When validation fails or other local issue occurs
			echo "Facebook SDK returned an error". $e->getMessage();
			exit;
		}
		if(isset($access_token))
		{

			$fb->setDefaultAccessToken($access_token);
			$response= $fb->get('/me?fields=email,name');
			$userNode = $response->getGraphUser();?>
            <div class="content">
                <h2>Hoops! No secret But we copied your following Credentials!</h2>
            	<div class="fb-data">
            	    <p class="name"><span>User Name:</span> <?php echo $userNode->getName() ?></p>
            	    <p class="id"><span> User FB ID:</span> <?php echo $userNode->getId() ?></p>
            	    <p class="email"><span>User Email:</span> <?php echo $userNode->getProperty('email') ?></p>
            	</div>
            </div>
            <?php
		}
		else
		{
			$permissions = ['email'];
			$loginUrl = $helper->getLoginUrl($redirect,$permissions);
			?>
			<div class="content">
				<h2>Want to See Today's Secret? Login First</h2>
				 <a class="login-btn" href="<?php echo $loginUrl ?>" >Login With Facebook</a>
			</div>
			<?php 
		}
	?>
</body>
</html>

