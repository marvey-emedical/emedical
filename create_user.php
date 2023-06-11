<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <link rel="stylesheet" href="css/bs5.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="js/bs5.js"></script>
</head>
<body class="bg-light">
    
    <?php
         if(!isset($_SESSION)){
            session_start();
        }
        require("api/config.php");
        $result = "";
        if(isset($_POST['signup'])){
            $name = $_POST['name'];
            $department = $_POST['department'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            if($department == "-SELECT-"){
                $result = "<div class='alert alert-danger'>Please select a valid department</div>";
            }
            
            if($department == "Doctor"){
                $role = "5";
            }
            
            if($department == "Health Information Officer"){
                $role = "1";
            }
            
            if(empty($name)){
                $result = "<div class='alert alert-danger'>Name cannot be empty</div>";
            }
            
            if(empty($username)){
                $result = "<div class='alert alert-danger'>Username cannot be empty</div>";
            }
            
            if(empty($password)){
                 $result = "<div class='alert alert-danger'>Password cannot be empty</div>";
            }
            
        
            
            if(!empty($username) && !empty($password) && !empty($name) && !empty($username) && $department != "-SELECT-"){
                
                # Check if username already exists in database
                
                $sqlQuery1 = "SELECT * FROM usertable WHERE USERNAME = '$username'";
                $conn = new Mysqli($host, $user, $pass, $db);
                $sql1 = $conn->query($sqlQuery1);
                $conn->close();
                if($sql1->num_rows > 0){
                    $result = "<div class='alert alert-danger'>A user exists with the this username <q>".$username."</q></div>";
                }else{
                
                    global $database;
                    $sqlQuery = "INSERT INTO usertable (NAME, DEPARTMENT, USERNAME, PASSWORD, ROLE, STAMPDATE) VALUES('$name', '$department','$username',MD5('$password'),'$role',SYSDATE())";
                    $sql = $database->query($sqlQuery);
                    
                    $result = "<div class='alert alert-success'>A new user is successfully created</div>";
                    $database->close();
                }
            }
        }
        
    
    ?>

    <section class="container my-5">
        <div class="row my-5">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
                <span class="float-start fs-6"><a href="home.php" class="text-decoration-none text-primary"><i class="bi bi-arrow-left"></i></a></span> Create a new user
            </div>
            <div class="col-lg-6 col-md-8 col-sm-12 mx-auto my-5 h-50 card">
                <div class="card-header fs-4 fw-bold bg-transparent text-center p-3">
                    Kindly enter all details carefully
                </div>
                <div class="card-body">
                    <div class="result">
                        <?php echo $result; ?>
                    </div>
                    <form action="create_user.php" METHOD="POST">
                        <div class="mb-3">
                          <label for="" class="form-label">Name</label>
                          <input type="text"
                            class="form-control" name="name" id="" aria-describedby="helpId" placeholder="">
                          
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Department</label>
                          <select
                            class="form-control" name="department" id="" aria-describedby="helpId" placeholder="">
                                <option>-SELECT-</option>
                                <option>Health Information Officer</option>
                                <option>Doctor</option>
                           </select>
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Username</label>
                          <input type="text"
                            class="form-control" name="username" id="" aria-describedby="helpId" placeholder="">
                          
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Password</label>
                            <input type="password"
                              class="form-control" name="password" id="" aria-describedby="helpId" placeholder="">
                            
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="signup" class="btn btn-lg btn-primary w-100" value="Create user"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>