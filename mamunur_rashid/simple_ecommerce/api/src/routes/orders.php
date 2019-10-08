<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

// Confirm Order
$app->post('/confirm-order', function (Request $request, Response $response) {
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

      //$stmt = $db->prepare($sql);

      /*$stmt->bindParam(':name', $name);
      $stmt->bindParam(':category_id', $category_id);
      $stmt->bindParam(':supplier_id', $supplier_id);
      $stmt->bindParam(':price', $price);
      $stmt->bindParam(':image', $image);
      $stmt->bindParam(':description', $description);

      $stmt->execute();*/

      $out['message'] = "Order placed successfully. Some of our agent will contact you soon.";
    } catch (PDOException $e) {
      $out['error'] = true;
      $out['message'] = $e->getMessage();
    }
  }
  echo json_encode($out);
});
