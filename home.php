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
        $role = $_SESSION['ROLE'];
        $userId = $_SESSION['USERID'];
        $username = $_SESSION['USERNAME'];
        $name = $_SESSION['NAME'];
        $department = $_SESSION['DEPARTMENT'];
        
        if(empty($userId)){
            header("Location:index.php");
        }
    
    
    ?>

    <section class="container my-5">
        <div class="row my-5">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
                Hello, <?php echo $name ?>
                <div class="fs-4 fw-bold">
                    <?php echo $department; ?>
                </div>
            </div>

    

            <!--Home page view for Health Information officers-->
            <?php if($role == "1"){ ?>
                <div class="col-lg-3 col-md-6 col-sm-12 mx-auto my-5 h-50">
                    <a href="register_patient.php" class="text-decoration-none text-dark">
                        <div class="card fs-3 fw-bold text-center py-5">
                            Register patient
                        </div>
                    </a>
                    
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mx-auto my-5 h-50">
                    <a href="view_patient.php" class="text-decoration-none text-dark">
                        <div class="card fs-3 fw-bold text-center py-5">
                            View patient
                        </div>
                    </a>
                    
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mx-auto my-5 h-50">
                    <a href="appointment_booking.php" class="text-decoration-none text-dark">
                        <div class="card fs-3 fw-bold text-center py-5">
                            Book appointment
                        </div>
                    </a>
                    
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 mx-auto my-5 h-50">
                    <a href="view_patients_on_appointment.php" class="text-decoration-none text-dark">
                        <div class="card fs-3 fw-bold text-center py-5">
                            View appointments
                        </div>
                    </a>                
                </div>
                
            <!--</div>-->
        <?php } ?>
        <!--Home page view for Doctors-->
        
        <?php if($role == "5"){ ?>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mx-auto my-5 h-50">
                    <a href="doctors_list.php" class="text-decoration-none text-dark">
                        <div class="card fs-3 fw-bold text-center py-5">
                            View appointments
                        </div>
                    </a>
                    
                </div>
            </div>
        <?php } ?>
        
        <?php if($role == "10"){ ?>
            <div class="row p-5 mt-5 bg-white">
                <div class="col-12"></div>
                <div class="col-12 overflow-auto">
                    <a href="create_user.php" class="btn btn-primary float-end m-4">New user</a>
                    <table class="table table-bordered">
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Username
                            </th>
                            <th>
                                Department
                            </th>
                            <th>
                                Date registered
                            </th>
                            <th>
                                Status
                            </th>
                        </tr>
                        
                        <?php
                        
                            global $database;
                            $sqlQuery = "SELECT ID, ROLE, USERNAME, DEPARTMENT, STAMPDATE, NAME FROM usertable ORDER BY STAMPDATE ASC";
                            $sql = $database->query($sqlQuery);
                            while($rows = $sql->fetch_array()){
                                $result = "<tr>";
                                    $result .= "<td>".$rows['ID']."</td>";
                                    $result .= "<td>".$rows['NAME']."</td>";
                                    $result .= "<td>".$rows['USERNAME']."</td>";
                                    $result .= "<td>".$rows['DEPARTMENT']."</td>";
                                    $result .= "<td>".$rows['STAMPDATE']."</td>";
                                    $result .= "<td><span class='badge bg-success'>Active</span></td>";
                                $result .= "</tr>";
                                
                                echo $result;
                            }
                        
                        ?>
                        
                    </table>
                </div>
            </div>
        <?php } ?>

        
        
            
            
        
    </section>
    <section class="position-fixed bottom-0 w-100 border-top mx-auto p-3 bg-secondary" style="height: 100px;">
        <a href="logout.php" class="btn btn-danger float-end mx-5">Signout</a>
    </section>
    
</body>
</html>