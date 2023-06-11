<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients on Appointment</title>
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
        
        $role = $_SESSION['ROLE'];
        $userId = $_SESSION['USERID'];
        $username = $_SESSION['USERNAME'];
        $name = $_SESSION['NAME'];
        $department = $_SESSION['DEPARTMENT'];
        
        $date = !empty($_POST['queryDate'])? (string)$_POST['queryDate']:"";
        if(empty($date)){
            $date = strftime("%Y-%m-%d", time());
            // $date = date_default_timezone_set('Africa/Lagos');

        }
    ?>

    <section class="container my-5">
        <div class="row my-5">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
              <span class="float-start fs-6"><a href="home.php" class="text-decoration-none text-primary"><i class="bi bi-arrow-left"></i></a></span>  Patients on appointment
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12 mx-auto mt-4">
                    <form action = "doctors_list.php" METHOD="POST">
                        <div class="mb-3">
                           
                            <label for="Appointment date" class="form-label">Date</label>
                            <input type="date" value="<?php echo $date; ?>"
                                class="form-control" name="queryDate" id="queryDate" aria-describedby="helpId" placeholder="">
                        
                        
                        </div>
                        <div class="mb-3">
                           
                            
                            <input type="submit" class="btn btn-primary btn-lg w-100" value="Query"  class="form-control" name="submit">
                        
                        
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-12 overflow-auto mt-5">
                <div class="alert alert-success text-center">Patients on appointment to meet Dr. <?php echo $name; ?></div>
                <table class="table table-bordered" style="white-space: nowrap;">
                    
                    <tr>
                        <th>HOSPITAL NUMBER</th>
                        <th>PATIENT NAME</th>
                        <th>APPOINTMENT DATE</th>
                        <th>APPOINTMENT TIME</th>
                        <th>APPOINTMENT TYPE</th>
                        <th>DOCTOR</th>
                        <th>DATE BOOKED</th>
                        <th>STATUS</th>
                        <th>PROCESS</th>
                    </tr>
                        <?php 
                        
                            if(isset($_POST['submit'])){
                            
                                $date = $_POST['queryDate'];
                                
                                
                                
                                
                                global $database;
                                if(empty($date)){
                                    $sqlQuery = "SELECT ID, HOSPITAL_NUMBER, APPOINTMENT_DATE, APPOINTMENT_TIME, APPOINTMENT_TYPE, DOCTOR, STAMPDATE, STATUS, (SELECT CONCAT(FIRSTNAME,' ',LASTNAME) FROM patients WHERE HOSPITAL_NUMBER = AP.HOSPITAL_NUMBER ) AS PATIENT_NAME FROM appointment_booking AP WHERE DATE(APPOINTMENT_DATE) = DATE(SYSDATE()) AND DOCTOR='$name'"; 
                                }else{
                                    $sqlQuery = "SELECT ID, HOSPITAL_NUMBER, APPOINTMENT_DATE, APPOINTMENT_TIME, APPOINTMENT_TYPE, DOCTOR, STAMPDATE, STATUS, (SELECT CONCAT(FIRSTNAME,' ',LASTNAME) FROM patients WHERE HOSPITAL_NUMBER = AP.HOSPITAL_NUMBER ) AS PATIENT_NAME FROM appointment_booking AP WHERE DATE(APPOINTMENT_DATE) = DATE('$date') AND DOCTOR='$name'";
                                }
                                
                               
                                $sql = $database->query($sqlQuery);
                                $rows_fetched = $sql->num_rows;
                                
                                
                                $result = $rows_fetched;
                                
                                
                                $database->close();
                                while($rows = $sql->fetch_array()){
                                    
                                    if($rows['STATUS'] == 0){
                                        $status = "<span class='badge bg-dark'>Not attended to</span>";
                                        $consult = "<a href='doc_consultation.php?appointment_id=".$rows['ID']."' class='btn btn-primary'>Begin consultation</a>";
                                    }
                                    if($rows['STATUS'] == 1){
                                        $consult = "<a href='doc_consultation.php?appointment_id=".$rows['ID']."' class='btn btn-outline-primary'>View Summary</a>";
                                        $status = "<span class='badge bg-warming'>Currently on consultation</span>";
                                    }
                                    if($rows['STATUS'] == 2){
                                        $consult = "<a href='doc_consultation.php?appointment_id=".$rows['ID']."' class='btn btn-outline-primary'>View Summary</a>";
                                        $status = "<span class='badge bg-success'>Consultation ended</span>";
                                    }
                                    
                                    $result = "<tr>";
                                    $result .= "<td>".$rows['HOSPITAL_NUMBER']."</td>";
                                    $result .= "<td>".$rows['PATIENT_NAME']."</td>";
                                    $result .= "<td>".$rows['APPOINTMENT_DATE']."</td>";
                                    $result .= "<td>".$rows['APPOINTMENT_TIME']."</td>";
                                    $result .= "<td>".$rows['APPOINTMENT_TYPE']."</td>";
                                    $result .= "<td>".$rows['DOCTOR']."</td>";
                                    $result .= "<td>".$rows['STAMPDATE']."</td>";
                                    $result .= "<td>".$status."</td>";
                                    $result .= "<td>".$consult."</td>";
                                    $result .= "</tr>";
                                    
                                    echo $result;
                                }
                            
                            }
                            
                        ?>
                </table>
            </div>
    
    
        </div>
        
        
    </section>
    <section class="position-fixed bottom-0 w-100 border-top mx-auto p-3 bg-secondary" style="height: 100px;">
        <a href="logout.php" class="btn btn-danger float-end mx-5">Signout</a>
    </section>
    
</body>
</html>