CREATE TABLE properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(255),
    age INT,
    floorPlan VARCHAR(255),
    bedrooms INT,
    bathrooms INT,
    garden BOOLEAN,
    parking VARCHAR(255),
    proximity VARCHAR(255),
    mainRoads VARCHAR(255),
    propertyTax FLOAT,
    imagePath VARCHAR(255)
);
