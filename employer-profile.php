<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/jquery-3.2.0.min.js"></script>
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
    <script src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php 
    $usname = $_SESSION['username'];
    include('dbconnect.php');
    $query = "SELECT * FROM internships WHERE employer='$usname'";
    $result = mysqli_query($conn, $query);
?>
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
                <li><a href="#">Logged in as <?php echo $usname; ?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout" role="button"><span class="glyphicon glyphicon-tasks"></span> Log Out</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <h2 class="text-center"><strong>Add Another Internship</strong></h2>
            <form role="form" action="insert_internship.php" method="post">
                <div class="form-group">
                    <label>Employer: </label>
                    <input type="text" name="employer" class="form-control" value="<?php echo $usname ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Title: </label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description: </label>
                    <input type="text" name="description" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Category: </label>
                    <select name="category" class="form-control" required>
                        <option value="Engineering">Engineering</option>
                        <option value="Business">Business</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Finance">Finance</option>
                        <option value="Design">Design</option>
                        <option value="Technology">Technology</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Education">Education</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Stipend: </label>
                    <input type="text" name="stipend" class="form-control">
                </div>
                <div class="form-group">
                    <label>Start Date: </label>
                    <input type="text" name="start_date" placeholder="YYYY-MM-DD" class="form-control datepicker" required>
                </div>
                <div class="form-group">
                    <label>End Date: </label>
                    <input type="text" name="end_date" placeholder="YYYY-MM-DD" class="form-control datepicker" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-block">Add Internship</button>
            </form>
        </div>

        <div class="col-sm-4">
            <h2 class="text-center"><strong>Internships Posted</strong></h2>
            <br>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="well bg-info">
                    <h4><strong>Employer: </strong><?php echo $row['employer']; ?></h4>
                    <h4><strong>Title: </strong><?php echo $row['title']; ?></h4>
                    <p><strong>Description: </strong><?php echo $row['description']; ?></p>
                    <p><strong>Category: </strong><?php echo $row['category']; ?></p>
                    <p><strong>Stipend: Rs. </strong><?php echo $row['stipend']; ?></p>
                    <p><strong>Start Date: </strong><?php echo $row['start_date']; ?></p>
                    <p><strong>End Date: </strong><?php echo $row['end_date']; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php ?>
		<div class="col-sm-4">
			<h2 class="text-center"><strong>Received Applications </strong></h2>
			<table class="table table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Title</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$call="SELECT * FROM student_applications WHERE employer='$usname'";
					$received=mysqli_query($conn,$call);

					while($rowz=mysqli_fetch_assoc($received)){

					 ?>
					 <tr>
					 	<td><?php echo $rowz['name']; ?></td>
					 	<td><?php echo $rowz['email']; ?></td>
					 	<td><?php echo $rowz['job_title']; ?></td>
					</tr>
					<?php } ?>
					</tbody>
					</table>

		</div>
		</div>
	</div>
</body>

<?php mysqli_close($conn); ?>
<script>
    $(document).ready(function(){
        $('.datepicker').datepicker({ format: 'yyyy-mm-dd' });
    });
</script>
</body>
</html>
