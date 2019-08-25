<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

// Get All Categories
$app->get('/get-categories', function (Request $request, Response $response) {
    $out = array('error' => false);

    $token = $request->getHeader('Authorization');
    $token = explode(" ", $token[0]);
    $token = $token[1];

    if (empty($token)) {
        $out['error'] = true;
        $out['message'] = "Invalid Token. Please login again.";
    } else {

        $sql = "SELECT * FROM categories";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->query($sql);
            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            $out['categories'] = $categories;
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});

// Get Single Category
$app->post('/get-category', function (Request $request, Response $response) {
    $out = array('error' => false);

    $token = $request->getHeader('Authorization');
    $token = explode(" ", $token[0]);
    $token = $token[1];

    $id = $request->getParam('id');

    if (empty($token)) {
        $out['error'] = true;
        $out['message'] = "Invalid Token. Please login again.";
    } else {
        $sql = "SELECT * FROM categories WHERE id = $id";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->query($sql);
            $category = $stmt->fetch(PDO::FETCH_OBJ);
            $db = null;
            $out['category'] = $category;
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});

// Add Category
$app->post('/add-category', function (Request $request, Response $response) {
    $out = array('error' => false);

    $token = $request->getHeader('Authorization');
    $token = explode(" ", $token[0]);
    $token = $token[1];

    $name = $request->getParam('name');
    $description = $request->getParam('description');

    if (empty($token)) {
        $out['error'] = true;
        $out['message'] = "Invalid Token. Please login again.";
    } else if ($name == '') {
        $out['error'] = true;
        $out['message'] = "Category name is required";
    } else {
        $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->query("SELECT * FROM users WHERE token='$token'");
            if ($stmt->rowCount() > 0) {

                $stmt = $db->prepare($sql);

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);

                $stmt->execute();

                $out['message'] = "Category added Successfully";
            } else {
                $out['error'] = true;
                $out['message'] = "Invalid Token. Please login again.";
            }
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});

// Update Category
$app->post('/update-category', function (Request $request, Response $response) {
    $out = array('error' => false);

    $token = $request->getHeader('Authorization');
    $token = explode(" ", $token[0]);
    $token = $token[1];

    $id = $request->getParam('id');
    $name = $request->getParam('name');
    $description = $request->getParam('description');

    if (empty($token)) {
        $out['error'] = true;
        $out['message'] = "Invalid Token. Please login again.";
    } else if ($name == '') {
        $out['error'] = true;
        $out['message'] = "Category name is required";
    } else {
        $sql = "UPDATE categories SET name = :name, description = :description WHERE id = $id";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);

            $stmt->execute();

            $out['message'] = "Category updated Successfully";
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});

// Delete Category
$app->post('/delete-category', function (Request $request, Response $response) {
    $out = array('error' => false);

    $token = $request->getHeader('Authorization');
    $token = explode(" ", $token[0]);
    $token = $token[1];

    $id = $request->getParam('id');

    if (empty($token)) {
        $out['error'] = true;
        $out['message'] = "Invalid Token. Please login again.";
    } else {
        $sql = "DELETE FROM categories WHERE id = $id";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
            $out['message'] = "Category deleted Successfully";
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});
