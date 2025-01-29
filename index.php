<?php 
include('dbconnect.php');

// Get search input
$search_keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$category_filter = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : "";

// Base query
$query = "SELECT * FROM internships WHERE end_date > CURDATE()";

// Apply filters
if (!empty($search_keyword)) {
    $query .= " AND (title LIKE '%$search_keyword%' OR employer LIKE '%$search_keyword%' OR description LIKE '%$search_keyword%')";
}
if (!empty($category_filter) && $category_filter != "All") {
    $query .= " AND category = '$category_filter'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/jquery-3.2.0.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    /* Centering the form */
    .form-inline {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Styling the search input */
    .form-inline input[type="text"] {
        width: 300px;
        padding: 10px;
        border: 2px solid #007bff;
        border-radius: 5px;
        outline: none;
    }

    .form-inline input[type="text"]:focus {
        border-color: #0056b3;
        box-shadow: 0 0 5px rgba(0, 91, 187, 0.5);
    }

    /* Styling the category dropdown */
    <style>
        /* Styling the search bar */
        .search-container {
            text-align: center;
            margin: 20px 0;
        }

        .search-container input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 2px solid #007bff;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Dropdown styling */
        .search-container select {
            width: 220px; /* Ensures text does not cut off */
            padding: 10px;
            border: 2px solid #007bff;
            border-radius: 5px;
            font-size: 16px;
            background-color: white;
            color: #333;
            text-align: left;
            white-space: nowrap; /* Prevents text wrapping */
            min-width: 220px;
        }

        .search-container button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        /* Fix for dropdown options */
        .search-container select option {
            padding: 10px;
            font-size: 16px;
            white-space: nowrap;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">InternScope</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="login">Log In <span class="glyphicon glyphicon-user"></span></a></li>
                <li><a href="signup">Sign Up <span class="glyphicon glyphicon-user"></span></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container bg-success" id="content">
    <h1 class="text-primary text-center">Available Internships</h1>

    <!-- Search Bar -->
    <form method="GET" action="index.php" class="form-inline text-center">
        <input type="text" name="search" class="form-control" placeholder="Search by title, employer, or description" value="<?= htmlspecialchars($search_keyword) ?>">
        
        <!-- Category Dropdown -->
        <select name="category" class="form-control">
            <option value="All" <?= ($category_filter == "All") ? "selected" : "" ?>>All Categories</option>
            <option value="Engineering" <?= ($category_filter == "Engineering") ? "selected" : "" ?>>Engineering</option>
            <option value="Business" <?= ($category_filter == "Business") ? "selected" : "" ?>>Business</option>
            <option value="Marketing" <?= ($category_filter == "Marketing") ? "selected" : "" ?>>Marketing</option>
            <option value="Finance" <?= ($category_filter == "Finance") ? "selected" : "" ?>>Finance</option>
            <option value="Design" <?= ($category_filter == "Design") ? "selected" : "" ?>>Design</option>
            <option value="Technology" <?= ($category_filter == "Technology") ? "selected" : "" ?>>Technology</option>
            <option value="Healthcare" <?= ($category_filter == "Healthcare") ? "selected" : "" ?>>Healthcare</option>
            <option value="Education" <?= ($category_filter == "Education") ? "selected" : "" ?>>Education</option>
        </select>

        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <br>

    <!-- Display Internships -->
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="well bg-info">
            <h4><strong>Employer: </strong><?php echo $row['employer']; ?></h4>
            <h4><strong>Title: </strong><?php echo $row['title']; ?></h4>
            <p><strong>Description: </strong><?php echo $row['description']; ?></p>
            <p><strong>Stipend: Rs. </strong><?php echo $row['stipend']; ?></p>
            <p><strong>Start Date: </strong><?php echo $row['start_date']; ?></p>
            <p><strong>End Date: </strong><?php echo $row['end_date']; ?></p>
            <p><strong>Category: </strong><?php echo $row['category']; ?></p>
            <a role="button" href="login" class="btn btn-block btn-success">Apply</a>
        </div>
    <?php } ?>

    <?php if (mysqli_num_rows($result) == 0) { ?>
        <p class="text-center text-danger">No internships found.</p>
    <?php } ?>

</div>

<?php mysqli_close($conn); ?>

</body>
</html>
