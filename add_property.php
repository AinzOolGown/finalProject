<?php
session_start();
include 'database_config.php';


// Function to sanitize input data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_FILES['propertyImage']) && $_FILES['propertyImage']['error'] == UPLOAD_ERR_OK) {
		$uploadDir = '..\demo';
		$tmpName = $_FILES['propertyImage']['tmp_name'];
		$fileName = basename($_FILES['propertyImage']['name']);
		$uploadFile = '..\demo' . $fileName;

		if (move_uploaded_file($tmpName, $uploadFile)) {
			//echo "File is valid, and was successfully uploaded.\n";
			$imagePath = $uploadFile;
		} else {
			//echo "Possible file upload attack!\n";
		}
	} else {
		//echo "No file uploaded or upload error.\n";
	}
	
    $location = test_input($_POST["location"]);
    $age = test_input($_POST["age"]);
    $floorPlan = test_input($_POST["floorPlan"]);
    $bedrooms = test_input($_POST["bedrooms"]);
    $bathrooms = test_input($_POST["bathrooms"]);
    $garden = isset($_POST["garden"]) ? 1 : 0; // Checkbox
    $parking = test_input($_POST["parking"]);
    $proximity = test_input($_POST["proximity"]);
    $mainRoads = test_input($_POST["mainRoads"]);
    $propertyTax = test_input($_POST["propertyTax"]);
    $imagePath = $uploadDir . $fileName; // This should be set to the path of the uploaded image
	$property_details = $_SESSION['user_email'];

    // SQL to insert data
    $sql = "INSERT INTO properties (location, age, floorPlan, bedrooms, bathrooms, garden, parking, proximity, mainRoads, propertyTax, imagePath, email) 
            VALUES (:location, :age, :floorPlan, :bedrooms, :bathrooms, :garden, :parking, :proximity, :mainRoads, :propertyTax, :imagePath, :email)";

    try {
        $stmt = $pdo->prepare($sql);

        // Bind parameters to statement
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':floorPlan', $floorPlan);
        $stmt->bindParam(':bedrooms', $bedrooms, PDO::PARAM_INT);
        $stmt->bindParam(':bathrooms', $bathrooms, PDO::PARAM_INT);
        $stmt->bindParam(':garden', $garden, PDO::PARAM_BOOL);
        $stmt->bindParam(':parking', $parking);
        $stmt->bindParam(':proximity', $proximity);
        $stmt->bindParam(':mainRoads', $mainRoads);
        $stmt->bindParam(':propertyTax', $propertyTax);
        $stmt->bindParam(':imagePath', $imagePath);
		$stmt->bindParam(':email', $property_details);

        // Execute the statement
        $stmt->execute();
        //echo "New record created successfully";
    } catch(PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
		exit;
    }
	
	$newPropertyData = [
		'location' => $location,
		'age' => $age,
		'floorPlan' => $floorPlan,
		'bedrooms' => $bedrooms,
		'bathrooms' => $bathrooms,
		'garden' => $garden, 
		'parking' => $parking,
		'proximity' => $proximity,
		'mainRoads' => $mainRoads,
		'propertyImage' => $propertyTax,
		'imagePath' => $imagePath,
		'email' => $property_details
	];

	echo json_encode(['success' => true, 'property' => $newPropertyData]);
	
}

// Close connection
$pdo = null;
?>
