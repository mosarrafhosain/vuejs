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

    $sql = "SELECT products.*, categories.name AS category, suppliers.name AS supplier FROM products LEFT JOIN categories ON categories.id = products.category_id LEFT JOIN suppliers ON suppliers.id = products.supplier_id";

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
  $category_id = $request->getParam('category_id');
  $supplier_id = $request->getParam('supplier_id');
  $price = $request->getParam('price');
  $image = $request->getParam('image');
  $description = $request->getParam('description');

  if (empty($token)) {
    $out['error'] = true;
    $out['message'] = "Invalid Token. Please login again.";
  } else {
    $sql = "INSERT INTO products (name, category_id, supplier_id, price, image, description) VALUES (:name, :category_id, :supplier_id, :price, :image, :description)";

    try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':category_id', $category_id);
      $stmt->bindParam(':supplier_id', $supplier_id);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':image', $image);
      $stmt->bindParam(':description', $description);

      $stmt->execute();

      $out['message'] = "Product added Successfully";
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
  $category_id = $request->getParam('category_id');
  $supplier_id = $request->getParam('supplier_id');
  $price = $request->getParam('price');
  //$image = $request->getParam('image');
  $description = $request->getParam('description');

  if (empty($token)) {
    $out['error'] = true;
    $out['message'] = "Invalid Token. Please login again.";
  } else {
    $sql = "UPDATE products SET
				name 	        = :name,
				category_id 	= :category_id,
        supplier_id		= :supplier_id,
        price		      = :price,
        description 	= :description
			WHERE id = $id";

    try {
      // Get DB Object
      $db = new db();
      // Connect
      $db = $db->connect();

      $stmt = $db->prepare($sql);

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':category_id', $category_id);
      $stmt->bindParam(':supplier_id', $supplier_id);
      $stmt->bindParam(':price', $price);
      //$stmt->bindParam(':image', $image);
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
