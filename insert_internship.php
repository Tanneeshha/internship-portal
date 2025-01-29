<?php
session_start();
include_once('dbconnect.php');

$err = ""; // Default error message

$employer = trim($_POST['employer']);
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$stipend = trim($_POST['stipend']);
$category = trim($_POST['category']); // New category field

$s_date = trim($_POST['start_date']);
$s_date = date("Y-m-d", strtotime($s_date));
$e_date = trim($_POST['end_date']);
$e_date = date("Y-m-d", strtotime($e_date));

// Validation
if (empty($employer)) { $err .= "Employer is empty & "; }
if (empty($title)) { $err .= "Title is empty & "; }
if (empty($description)) { $err .= "Description is empty & "; }
if (empty($stipend)) { $err .= "Stipend is empty & "; }
if (empty($category)) { $err .= "Category is empty."; }

if (!empty($err)) {
    echo "<script>alert('$err');</script>";
    echo "<script>setTimeout(\"location.href = 'employer-profile.php';\", 200);</script>";
} else {
    // No errors, proceed to insert
    $uemployer = mysqli_real_escape_string($conn, $employer);
    $utitle = mysqli_real_escape_string($conn, $title);
    $udescription = mysqli_real_escape_string($conn, $description);
    $ustipend = mysqli_real_escape_string($conn, $stipend);
    $ucategory = mysqli_real_escape_string($conn, $category);
    $s_date = mysqli_real_escape_string($conn, $s_date);
    $e_date = mysqli_real_escape_string($conn, $e_date);

    $query = "INSERT INTO internships(employer, title, description, stipend, category, start_date, end_date) 
              VALUES ('$uemployer', '$utitle', '$udescription', '$ustipend', '$ucategory', '$s_date', '$e_date')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Internship added successfully');</script>";
        echo "<script>setTimeout(\"location.href = 'employer-profile.php';\", 200);</script>";
    } else {
        echo "<script>alert('Error. Please try again.');</script>";
        echo "<script>setTimeout(\"location.href = 'employer-profile.php';\", 200);</script>";
    }

    // Close DB connection
    mysqli_close($conn);
}
?>
