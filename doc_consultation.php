<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients on Appointment</title>
    <link rel="stylesheet" href="css/bs5.css"/>
    <script src="js/bs5.js"></script>
</head>
<body class="bg-light">
    
    <?php
        require("api/config.php");
        
        if(!isset($_SESSION)){
            session_start();
        }
        
        $appointment_id = $_GET['appointment_id'];
        $role = $_SESSION['ROLE'];
        $userId = $_SESSION['USERID'];
        $username = $_SESSION['USERNAME'];
        $name = $_SESSION['NAME'];
        $department = $_SESSION['DEPARTMENT'];
        $prescription = "";
        $diagnosis = "";
        $complain = "";
        
        global $database;
        
        $sqlQuery = "SELECT AB.HOSPITAL_NUMBER, APPOINTMENT_DATE, P.GENDER, APPOINTMENT_TIME, APPOINTMENT_TYPE, STATUS, (SELECT CONCAT(P.FIRSTNAME,' ',P.LASTNAME)) AS NAME, TIMESTAMPDIFF(YEAR, DATE(SYSDATE()), DATE(P.DOB)) AS AGE FROM appointment_booking AB, patients P WHERE AB.HOSPITAL_NUMBER = P.HOSPITAL_NUMBER AND AB.ID = '$appointment_id'";
        $sql = $database->query($sqlQuery);
        
        if($sql->num_rows > 0){

            while($rows = $sql->fetch_array()){
                if($rows['STATUS'] == 2){
                    echo "<div class='alert alert-danger text-center fs-3'>This appointment have been completed</div>";
                    echo exit;
                }
                if($rows['STATUS'] == "0" || "1" && $rows['APPOINTMENT_TYPE'] == "Online Consultation"){
                    echo '
                        <input type="hidden" id="hospitalNumber" value="'.$rows['HOSPITAL_NUMBER'].'">
                        <section class="container my-5">
                            <div class="row my-5">
                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
                                  <span class="float-start fs-6"><a href="home.php" class="text-decoration-none text-primary">< return home</a></span>  Appointment with '.$rows['NAME'].'
                                </div> 
                                
                                <div class="row p-4">
                                    <div class="col-lg-3 col-md-6 col-sm-12 mx-auto mt-4 text-center">
                                       Hospital Number: '.$rows['HOSPITAL_NUMBER'].'
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mx-auto mt-4 text-center">
                                       Gender: '.$rows['GENDER'].'
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mx-auto mt-4 text-center">
                                       Age: '.$rows['AGE'].' years
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mx-auto mt-4 text-center">
                                       <a href="#">View history</a>  
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label>Complain</label>
                                   <textarea class="card w-100 p-3" style="height:150px;">'.$complain.'</textarea>
                                    
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label>Prescription</label>
                                    <textarea class="card w-100 p-3" style="height:150px;">'.$prescription.'</textarea>
                                    
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label>Diagnosis</label>
                                    <textarea class="card w-100 p-3" style="height:150px;">'.$diagnosis.'</textarea>
                                    
                                </div>
                        
                            </div>
                            
                            <div class="row mt-4 mb-3 p-4">
                                <label>Live chat</label>
                                <div class="col-12 card">
                                    <div class="card-body w-100" style="height: 200px; overflow-x: hidden; overflow-y:auto;">
                                        
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="row">
                                            <div class="col-lg-10 col-md-8 col-sm-12">
                                                <input type="text" class="card p-3 w-100"/>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-sm-12">
                                                <button class="btn btn-primary w-100 p-3 btn-lg" onclick="sendMessage()">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-5">
                                <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                                    <button class="btn btn-lg btn-success w-100 " name="finish_treatment">Finish</button>
                                </div>
                                
                            </div>
                            
                        </section>
                    
                    ';
                }else{
                    echo '
                        
                        <section class="container my-5">
                            <div class="row my-5">
                                <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
                                  <span class="float-start fs-6"><a href="home.php" class="text-decoration-none text-primary">< return home</a></span>  Appointment with '.$rows['NAME'].'
                                </div>
                                
                                <div class="row p-4">
                                    <div class="col-lg-3 col-md-6 col-sm-12 mx-auto mt-4 text-center">
                                       Hospital Number: '.$rows['HOSPITAL_NUMBER'].'
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mx-auto mt-4 text-center">
                                       Gender: '.$rows['GENDER'].'
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mx-auto mt-4 text-center">
                                       Age: '.$rows['AGE'].' years
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mx-auto mt-4 text-center">
                                       <a href="#">View history</a>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label>Complain</label>
                                   <textarea class="card w-100 p-3" style="height:150px;">'.$complain.'</textarea>
                                    
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label>Prescription</label>
                                    <textarea class="card w-100 p-3" style="height:150px;">'.$prescription.'</textarea>
                                    
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <label>Diagnosis</label>
                                    <textarea class="card w-100 p-3" style="height:150px;">'.$diagnosis.'</textarea>
                                    
                                </div>
                        
                            </div>
                            
                           
                            
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                                    <button class="btn btn-lg btn-success w-100 " name="finish_treatment">Finish</button>
                                </div>
                                
                            </div>
                            
                        </section>
                    
                    ';
                }
            }
            
        }else{
            echo "<div class='alert alert-danger text-center fs-3'>This appointment ID is not valid</div>";
            
        }
        
    ?>

    <section class="position-fixed bottom-0 w-100 border-top mx-auto p-3 bg-secondary" style="height: 100px;">
        <a href="logout.php" class="btn btn-danger float-end mx-5">Signout</a>
    </section>
    
</body>
</html>