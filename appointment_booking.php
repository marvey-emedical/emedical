<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment booking</title>
    <link rel="stylesheet" href="css/bs5.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="js/bs5.js"></script>
</head>
<body class="bg-light">
    
    <?php
    
        require("api/config.php");
        if(!isset($_SESSION)){
            session_start();
        }
        
        $result = "";
        $hospital_number = "";
        $appointment_date = "";
        $appointment_time = "";
        $appointment_type = "";
        $doctor = "";
        $comment = "";
        
        
        if(isset($_POST['book_appointment'])){
            $hospital_number = $_POST['hospital_number'];
            $appointment_date = $_POST['appointment_date'];
            $appointment_time = $_POST['appointment_time'];
            $appointment_type = $_POST['appointment_type'];
            $doctor = $_POST['doctor'];
            $comment = $_POST['comment'];
            
            if(empty($hospital_number) || empty($appointment_date) || empty($appointment_time) || empty($doctor) || empty($comment) ){
                $result = "<div class='alert alert-danger text-center'>Please fill all details to book patient for appointment</div>";
            }else{
                # Check if patient exists
                global $database;
                $sqlQuery1 = "SELECT CONCAT(FIRSTNAME,' ',LASTNAME) AS NAME FROM patients WHERE hospital_number = '$hospital_number' LIMIT 1";
                $sql1 = $database->query($sqlQuery1);
                $database->close();
                if($sql1->num_rows > 0){
                    while($rows = $sql1->fetch_array()){
                        $patient_name = $rows['NAME'];
                    }
                    
                    
                    # save new appointment entry
                    $conn1 = new Mysqli($host, $user, $pass, $db);
                    
                    $sqlQuery2 = "INSERT INTO appointment_booking (hospital_number, appointment_date, doctor, appointment_time, appointment_type, stampdate) VALUES('$hospital_number','$appointment_date','$doctor','$appointment_time','$appointment_type',SYSDATE())";
                    $sql2 = $conn1->query($sqlQuery2);
                    if($sql2){
                         $result = "<div class='alert alert-success text-center'>".$patient_name." have been successfully booked for a/an ".$appointment_type." with ".$doctor." for ".$appointment_date." by ".$appointment_time." </div>";
                         $conn1->close();
                         $hospital_number = "";
                            $appointment_date = "";
                            $appointment_time = "";
                            $appointment_type = "";
                            $doctor = "";
                            $comment = "";
                         
                    }else{
                        $result = "<div class='alert alert-danger text-center'>".$conn1->error."</div>";
                    }
                }else{
                    $result = "<div class='alert alert-danger text-center'>No patient exists with the hospital number</div>";
                }
            }
            
        }
        
    
    ?>

    <section class="container my-5">
        <div class="row my-5">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
              <span class="float-start fs-6"><a href="home.php" class="text-decoration-none text-primary"><i class="bi bi-arrow-left"></i></a></span>  Register patient
            </div>

    
        <form action="appointment_booking.php" METHOD="POST">
            <div class="w-100"><?php echo $result; ?></div>
            <!--Home page view for Patients-->  
            <div class="row p-5 mt-5 bg-white">
                
                <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">
                    <div class="mb-3">
                        <label for="hospital_number" class="form-label">Hospital Number</label>
                        <input type="text" value="<?php echo $hospital_number; ?>" class="form-control" name="hospital_number" id="hospital_number" aria-describedby="helpId" placeholder="">
                        
                    </div>
                    
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Appointment date</label>
                        <input type="date" value="<?php echo $appointment_date; ?>" class="form-control" name="appointment_date" id="appointment_date" aria-describedby="helpId" placeholder="">
                        
                    </div>
                    
                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">Appointment time</label>
                        <input type="time" value="<?php echo $appointment_time; ?>" class="form-control" name="appointment_time" id="appointment_time" aria-describedby="helpId" placeholder="">
                        
                    </div>
                    
                    
                    <div class="mb-3">
                        <label for="doctor" class="form-label">Doctor</label>
                        <select class="form-control" name="doctor" id="doctor" aria-describedby="helpId">
                            <option><?php echo $doctor; ?></option>
                            <?php
                                $conn3 = new Mysqli($host, $user, $pass, $db);
                                $sqlQuery3 = "SELECT NAME FROM  usertable WHERE DEPARTMENT = 'Doctor'";
                                $sql3 = $conn3->query($sqlQuery3);
                                while($rows = $sql3->fetch_array()){
                                    echo "<option>".$rows['NAME']."</option>";
                                }
                                $conn3->close();
                            ?>
                        </select>
                        
                    </div>
                    
                     <div class="mb-3">
                        <label for="appointment_type" class="form-label">Appointment Type</label>
                        <select class="form-control" name="appointment_type" id="appointment_type" aria-describedby="helpId">
                            <option><?php echo $appointment_type; ?></option>
                            <option>Physical consultation</option>
                            <option>Online Consultation</option>
                        </select>
                        
                    </div>
                    
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <input type="text" value="<?php echo $comment; ?>" class="form-control" name="comment" id="comment" aria-describedby="helpId" placeholder="">
                        
                    </div>
                    
                    <div class="mb-3">
                        
                        <input type="submit" class="btn btn-lg form-control bg-primary text-white" name="book_appointment" value="Book appointment">
                        
                    </div>
                </div>
                
            </div>
        
        </form>
        
        
    </section>
    <section class="position-fixed bottom-0 w-100 border-top mx-auto p-3 bg-secondary" style="height: 100px;">
        <a href="logout.php" class="btn btn-danger float-end mx-5">Signout</a>
    </section>
    
</body>
</html>