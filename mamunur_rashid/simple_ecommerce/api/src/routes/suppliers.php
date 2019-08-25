<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

// Get All Suppliers
$app->get('/get-suppliers', function (Request $request, Response $response) {
    $out = array('error' => false);

    $token = $request->getHeader('Authorization');
    $token = explode(" ", $token[0]);
    $token = $token[1];

    if (empty($token)) {
        $out['error'] = true;
        $out['message'] = "Invalid Token. Please login again.";
    } else {

        $sql = "SELECT * FROM suppliers";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->query($sql);
            $suppliers = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            $out['suppliers'] = $suppliers;
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});

// Get Single Supplier
$app->post('/get-supplier', function (Request $request, Response $response) {
    $out = array('error' => false);

    $token = $request->getHeader('Authorization');
    $token = explode(" ", $token[0]);
    $token = $token[1];

    $id = $request->getParam('id');

    if (empty($token)) {
        $out['error'] = true;
        $out['message'] = "Invalid Token. Please login again.";
    } else {
        $sql = "SELECT * FROM suppliers WHERE id = $id";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->query($sql);
            $supplier = $stmt->fetch(PDO::FETCH_OBJ);
            $db = null;
            $out['supplier'] = $supplier;
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});

// Add Supplier
$app->post('/add-supplier', function (Request $request, Response $response) {
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
        $out['message'] = "Supplier name is required";
    } else {
        $sql = "INSERT INTO suppliers (name, description) VALUES (:name, :description)";

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

                $out['message'] = "Supplier added Successfully";
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

// Update Supplier
$app->post('/update-supplier', function (Request $request, Response $response) {
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
        $out['message'] = "Supplier name is required";
    } else {
        $sql = "UPDATE suppliers SET name = :name, description = :description WHERE id = $id";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);

            $stmt->execute();

            $out['message'] = "Supplier updated Successfully";
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});

// Delete Supplier
$app->post('/delete-supplier', function (Request $request, Response $response) {
    $out = array('error' => false);

    $token = $request->getHeader('Authorization');
    $token = explode(" ", $token[0]);
    $token = $token[1];

    $id = $request->getParam('id');

    if (empty($token)) {
        $out['error'] = true;
        $out['message'] = "Invalid Token. Please login again.";
    } else {
        $sql = "DELETE FROM suppliers WHERE id = $id";

        try {
            // Get DB Object
            $db = new db();
            // Connect
            $db = $db->connect();

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
            $out['message'] = "Supplier deleted Successfully";
        } catch (PDOException $e) {
            $out['error'] = true;
            $out['message'] = $e->getMessage();
        }
    }
    echo json_encode($out);
});
