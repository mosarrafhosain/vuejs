<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

// Get All Products
$app->get('/get-products', function (Request $request, Response $response) {
  $out = array('error' => false);

  $token = $request->getHeader('Authorization');
  $token = explode(" ", $token[0]);
  $token = $token[1];

  if (empty($token)) {
    $out['error'] = true;
    $out['message'] = "Invalid Token. Please login again.";
  } else {

    $sql = "SELECT * FROM products";

    try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->query($sql);
      $products = $stmt->fetchAll(PDO::FETCH_OBJ);
      $db = null;
      $out['products'] = $products;
    } catch (PDOException $e) {
      $out['error'] = true;
      $out['message'] = $e->getMessage();
    }
  }
  echo json_encode($out);
});

// Get Single Product
$app->post('/get-product', function (Request $request, Response $response) {
  $out = array('error' => false);

  $token = $request->getHeader('Authorization');
  $token = explode(" ", $token[0]);
  $token = $token[1];

  $id = $request->getParam('id');

  if (empty($token)) {
    $out['error'] = true;
    $out['message'] = "Invalid Token. Please login again.";
  } else {
    $sql = "SELECT * FROM products WHERE id = $id";

    try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->query($sql);
      $product = $stmt->fetch(PDO::FETCH_OBJ);
      $db = null;
      $out['product'] = $product;
    } catch (PDOException $e) {
      $out['error'] = true;
      $out['message'] = $e->getMessage();
    }
  }
  echo json_encode($out);
});

// Upload Image
$app->post('/upload-image', function (Request $request, Response $response) {
  $out = array('error' => false);

  $token = $request->getHeader('Authorization');
  $token = explode(" ", $token[0]);
  $token = $token[1];

  if (empty($token)) {
    $out['error'] = true;
    $out['message'] = "Invalid Token. Please login again.";
  } else {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $out["message"] =  "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
      $out["uploadedUrl"] = $target_file;
    } else {
      $out['error'] = true;
      $out["message"] =  "Sorry, there was an error uploading your file.";
    }
  }
  echo json_encode($out);
});

// Add Product
$app->post('/add-product', function (Request $request, Response $response) {
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
    $out['message'] = "Product name is required";
  } else {
    $sql = "INSERT INTO products (name, description) VALUES (:name, :description)";

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

        $out['message'] = "Product added Successfully";
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

// Update Product
$app->post('/update-product', function (Request $request, Response $response) {
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
    $out['message'] = "Product name is required";
  } else {
    $sql = "UPDATE products SET name = :name, description = :description WHERE id = $id";

    try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':description', $description);

      $stmt->execute();

      $out['message'] = "Product updated Successfully";
    } catch (PDOException $e) {
      $out['error'] = true;
      $out['message'] = $e->getMessage();
    }
  }
  echo json_encode($out);
});

// Delete Product
$app->post('/delete-product', function (Request $request, Response $response) {
  $out = array('error' => false);

  $token = $request->getHeader('Authorization');
  $token = explode(" ", $token[0]);
  $token = $token[1];

  $id = $request->getParam('id');

  if (empty($token)) {
    $out['error'] = true;
    $out['message'] = "Invalid Token. Please login again.";
  } else {
    $sql = "DELETE FROM products WHERE id = $id";

    try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);
      $stmt->execute();
      $db = null;
      $out['message'] = "Product deleted Successfully";
    } catch (PDOException $e) {
      $out['error'] = true;
      $out['message'] = $e->getMessage();
    }
  }
  echo json_encode($out);
});
