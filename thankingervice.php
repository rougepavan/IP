<?php
// Database connection details
$servername = "localhost";
$username = "root";   // Default XAMPP username
$password = "";       // Default XAMPP password
$dbname = "laptop_sales"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure all fields are set and not empty
    if (isset($_POST['customer_name']) && isset($_POST['contact_number']) && isset($_POST['email']) && isset($_POST['problem']) && isset($_POST['address']) &&
        !empty($_POST['customer_name']) && !empty($_POST['contact_number']) && !empty($_POST['email']) && !empty($_POST['problem']) && !empty($_POST['address'])) {

        // Retrieve form data (customer's booking details)
        $customer_name = $_POST['customer_name'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $problem = $_POST['problem'];
        $address = $_POST['address'];

        // Prepare SQL statement to insert the booking details into the database
        $sql = "INSERT INTO service_bookings (customer_name, contact_number, email, problem, address) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare and bind the parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $customer_name, $contact_number, $email, $problem, $address);

        // Execute the statement
        if ($stmt->execute()) {
            // Successful booking, show thank you message with styling
            echo "<div class='success-message'>";
            echo "<h2>Thank you for booking the service, $customer_name!</h2>";
            echo "<p>Your booking details have been successfully submitted. We will contact you soon to confirm the appointment.</p>";
            echo "<p>You will be redirected to the homepage shortly.</p>";
            echo "</div>";

            // Redirect to homepage after 5 seconds
            header("refresh:5; url=homepage.html");
        } else {
            // Error in booking process, show error message with styling
            echo "<div class='error-message'>";
            echo "Error: " . $stmt->error;
            echo "</div>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Display validation error message
        echo "<div class='error-message'>";
        echo "All fields are required!";
        echo "</div>";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Service</title>
    <style>
        /* styles.css */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333333;
        }

        header {
            background-color: #003366;
            color: #fff;
            padding: 1em 0;
            text-align: center;
        }

        header nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        header nav ul li {
            display: inline;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 0.5em 1em;
            transition: background-color 0.3s;
        }

        header nav ul li a:hover {
            background-color: #00509e;
        }

        main {
            max-width: 800px;
            margin: 2em auto;
            padding: 1em;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #003366;
            text-align: center;
        }

        .form-group {
            margin: 1em 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5em;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 0.5em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #003366;
            color: #fff;
            border: none;
            padding: 0.75em 1.5em;
            font-size: 1em;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 1em;
        }

        .form-group button:hover {
            background-color: #00509e;
        }

        footer {
            text-align: center;
            padding: 1em 0;
            background-color: #003366;
            color: #fff;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Success and Error Message Styling */
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            text-align: center;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            text-align: center;
        }

        .error-message, .success-message {
            font-family: Arial, sans-serif;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Book Your Service</h1>
    </header>

    <main>
        <div class="container">
            <h2>Book Your Service</h2>
            <form action="thankingervice.php" method="post">
                <div class="form-group">
                    <label for="customer-name">Customer Name:</label>
                    <input type="text" id="customer-name" name="customer_name" required>
                </div>
                <div class="form-group">
                    <label for="contact-number">Contact Number:</label>
                    <input type="tel" id="contact-number" name="contact_number" required>
                </div>
                <div class="form-group">
                    <label for="email">Email ID:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="problem">Problem with Product:</label>
                    <textarea id="problem" name="problem" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">SUBMIT</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Laptop Sales and Services</p>
    </footer>

</body>
</html>
