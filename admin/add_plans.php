<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Update Plans</title>
    <style>
        
/* General styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Form container */
.form-container {
    width: 400px;
    padding: 20px;
    background-color: #fff;
    border: 2px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Heading */
.form-container h2 {
    margin-bottom: 20px;
    color: #333;
    font-size: 1.8em;
}

/* Form labels and inputs */
form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

form input,
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
    box-sizing: border-box;
    resize:none;
}

/* Button */
form button {
    width: 100%;
    padding: 10px;
    font-size: 1.1em;
    font-weight: bold;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #0056b3;
}

/* Error messages */
.error-message {
    color: red;
    font-size: 0.9em;
    margin-top: -10px;
    margin-bottom: 10px;
    display: none;
}


    </style>
</head>
<body>
<div class="form-container">
        <h2>Update Membership Plans</h2>
        <form id="updateForm" action="update_plan.php" method="POST">
    
            <label for="plan_name">Plan Name:</label>
            <input type="text" name="plan_name" id="plan_name" required>
            <small class="error-message" id="plan_name_error"></small>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea>
            <small class="error-message" id="description_error"></small>

            <label for="duration">Duration (in months):</label>
            <input type="number" name="duration" id="duration" required>
            <small class="error-message" id="duration_error"></small>

            <label for="price">Price:</label>
            <input type="text" name="price" id="price" required>
            <small class="error-message" id="price_error"></small>

            <button type="submit" name="submit">Update Plan</button>
        </form>
    </div>
</body>
<script>
    document.getElementById('updateForm').addEventListener('submit', function(event) {
    let isValid = true;


    // Plan Name Validation
    const planName = document.getElementById('plan_name');
    const planNameError = document.getElementById('plan_name_error');
    if (planName.value.trim() === '') {
        isValid = false;
        planNameError.textContent = 'Plan Name is required.';
        planNameError.style.display = 'block';
    } else {
        planNameError.style.display = 'none';
    }

    // Description Validation
    const description = document.getElementById('description');
    const descriptionError = document.getElementById('description_error');
    if (description.value.trim() === '') {
        isValid = false;
        descriptionError.textContent = 'Description is required.';
        descriptionError.style.display = 'block';
    } else {
        descriptionError.style.display = 'none';
    }

    // Duration Validation
    const duration = document.getElementById('duration');
    const durationError = document.getElementById('duration_error');
    if (duration.value.trim() === '' || duration.value <= 0) {
        isValid = false;
        durationError.textContent = 'Duration must be a positive number.';
        durationError.style.display = 'block';
    } else {
        durationError.style.display = 'none';
    }

    // Price Validation
    const price = document.getElementById('price');
    const priceError = document.getElementById('price_error');
    if (price.value.trim() === '' || price.value <= 0) {
        isValid = false;
        priceError.textContent = 'Price must be a positive number.';
        priceError.style.display = 'block';
    } else {
        priceError.style.display = 'none';
    }

    // Prevent form submission if not valid
    if (!isValid) {
        event.preventDefault();
    }
});

</script>
</html>