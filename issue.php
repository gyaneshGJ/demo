<?
	//personal auth token from your github.com account.  doing this will eliminate having to use oauth everytime
	$token = "zzzzzzzzYourPersonalGithubAccessTokenzzzzzzzz";
	
	//post url, https://developer.github.com/v3/issues/
	$url = "https://api.github.com/repos/octocat/some_repo/issues?access_token=" . $token;
	
	//request details, removing slashes and sanitize content
	$title = htmlspecialchars(stripslashes("Test Title''\s"), ENT_QUOTES);
	$body = htmlspecialchars(stripslashes("Test Body'\'$%'s"), ENT_QUOTES);
	
	//build json post
	$post = '{"title": "'. $title .'","body": "'. $body .'"}';

	//set file_get_contents header info
	$opts = [
		'http' => [
				'method' => 'POST',
				'header' => [
						'User-Agent: PHP',
						'Content-type: application/x-www-form-urlencoded'
				],
				'content' => $post
		]
	];

	//initiate file_get_contents
	$context = stream_context_create($opts);
	
	//make request
	$content = file_get_contents($url, false, $context);
	
	//decode response to array
	$response_array = json_decode($content, true);	
	
	//issue number
	$number = $response_array['number'];

	echo "Issue " . $number . " generated.";

?>