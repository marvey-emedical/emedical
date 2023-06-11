<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <link rel="stylesheet" href="css/bs5.css"/>
    <script src="js/bs5.js"></script>
</head>
<body class="bg-light">
    
    <?php
         if(!isset($_SESSION)){
            session_start();
        }
        require("api/config.php");
        $result = "";
        if(isset($_POST['signin'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            if(empty($username)){
                $result = "<div class='alert alert-danger'>Username cannot be empty</div>";
            }
            
            if(empty($password)){
                 $result = "<div class='alert alert-danger'>Password cannot be empty</div>";
            }
            
            if(!empty($username) && !empty($password)){
                global $database;
                $sqlQuery = "SELECT ID, ROLE, USERNAME, DEPARTMENT, NAME FROM usertable WHERE USERNAME = '$username' AND PASSWORD = MD5('$password')";
                $sql = $database->query($sqlQuery);
                if($sql->num_rows > 0){
                    $result = "<div class='alert alert-success'>Login successful</div>";
                    while($rows = $sql->fetch_array()){
                        $_SESSION['ROLE'] = $rows['ROLE'];
                        $_SESSION['USERID'] = $rows['ID'];
                        $_SESSION['USERNAME'] = $rows['USERNAME'];
                        $_SESSION['NAME'] = $rows['NAME'];
                        $_SESSION['DEPARTMENT'] = $rows['DEPARTMENT'];
                    }
                    $database->close();
                    header("Location:home.php");
                }else{
                    $result = "<div class='alert alert-danger'>Username or Password is incorrect</div>";
                }
            }
        }
        
    
    ?>

    <section class="container my-5">
        <div class="row my-5">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
                Welcome to ABC Clinic
            </div>
            <div class="col-lg-6 col-md-8 col-sm-12 mx-auto my-5 h-50 card">
                <div class="card-header fs-3 fw-bold bg-transparent text-center p-3">
                    Signin
                </div>
                <div class="card-body">
                    <div class="result">
                        <?php echo $result; ?>
                    </div>
                    <form action="signin.php" METHOD="POST">
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
                            <input type="submit" name="signin" class="btn btn-lg btn-primary w-100" value="Signin"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>