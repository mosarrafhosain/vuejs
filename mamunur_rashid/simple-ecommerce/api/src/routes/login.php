<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Login
$app->post('/login', function(Request $request, Response $response){
	$out = array('error' => false);

	$username = $request->getParam('username');
	$password = $request->getParam('password');

	if ($username=='') {
		$out['error'] = true;
		$out['message'] = "Username is required";
	} else if ($password=='') {
		$out['error'] = true;
		$out['message'] = "Password is required";
	} else {
		$sql = "select * from users where username='$username' and password='$password'";

		try{
			// Get DB Object
			$db = new db();
			// Connect
			$db = $db->connect();

			$stmt = $db->query($sql);
			if ($stmt->rowCount() > 0) {
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				$db = null;
				$out['message'] = "Login Successful";
				$out['token'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUuY29tIiwiaWF0IjoxMzU2OTk5NTI0LCJuYmYiOjEzNTcwMDAwMDAsImRhdGEiOnsiaWQiOiI5IiwiZmlyc3RuYW1lIjoiTWlrZSIsImxhc3RuYW1lIjoiRGFsaXNheSIsImVtYWlsIjoibWlrZUBjb2Rlb2ZhbmluamEuY29tIn19.h_Q4gJ3epcpwdwNCNCYxtiKdXsN34W9MEjxZ7sx21Vs'; // JWT token format: header.payload.signature
			}	else {
				$out['error'] = true;
				$out['message'] = "Login Failed. User not Found";
			}
		} catch (PDOException $e){
			$out['error'] = true;
			$out['message'] = $e->getMessage();
		}
	}
	echo json_encode($out);
});
