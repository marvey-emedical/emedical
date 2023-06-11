<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Patient</title>
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
        $firstname = "";
        $lastname = "";
        $gender = "";
        $marital_status = "";
        $religion = "";
        $place_of_birth = "";
        $state_of_origin = "";
        $lga = "";
        $tribe = "";
        $country = "";
        $state_of_residence = "";
        $address = "";
        $email = "";
        $patient_phone = "";
        $nok_name = "";
        $nok_address = "";
        $nok_phone = "";
        $relationship = "";
        
        if(isset($_POST['registerPatient'])){
        
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $marital_status = $_POST['marital_status'];
            $religion = $_POST['religion'];
            $place_of_birth = $_POST['place_of_birth'];
            $state_of_origin = $_POST['state_of_origin'];
            $lga = $_POST['lga'];
            $tribe = $_POST['tribe'];
            $country = $_POST['country'];
            $state_of_residence = $_POST['state_of_residence'];
            $address = $_POST['address'];
            $email = $_POST['email'];
            $patient_phone = $_POST['patient_phone'];
            $nok_name = $_POST['nok_name'];
            $nok_address = $_POST['nok_address'];
            $nok_phone = $_POST['nok_phone'];
            $relationship = $_POST['relationship'];
            
            $dob = $_POST['dob'];
            $password = "PASS";
            
            if(empty($firstname) || empty($lastname) || empty($gender) || empty($marital_status) || empty($religion) || empty($place_of_birth) || empty($state_of_origin) || empty($lga) || empty($tribe) || empty($country) || empty($state_of_residence) || empty($address) || empty($email) || empty($patient_phone) || empty($nok_name) || empty($nok_address) || empty($nok_phone) || empty($relationship)){
                $result = "<div class='alert alert-danger'>Please input all details</div>";
            }else{
                
                #get last hospital number
                $conn2 = new Mysqli($host, $user, $pass, $db);
                $sqlQuery2 = "SELECT COUNT(*)+1 AS NUM FROM patients";
                $sql2 = $conn2->query($sqlQuery2);
                while($rows = $sql2->fetch_array()){
                    $hospitalno = $rows['NUM'];
                }
                $conn2->close();
                $currentYear = strftime("%Y",time());
                $hospitalNumber = $currentYear."/1000".$hospitalno;
                
                
                global $database;
                $sqlQuery = "INSERT INTO patients (hospital_number,firstname,lastname,gender,dob,marital_status,religion,place_of_birth,state_of_origin,lga,tribe,country,address,phone,next_of_kin_name,next_of_kin_address,next_of_kin_pphone,relationship,stampdate,password)
                VALUES ('$hospitalNumber','$firstname','$lastname','$gender','$dob','$marital_status','$religion','$place_of_birth','$state_of_origin','$lga','$tribe','$country','$address','$patient_phone','$nok_name','$nok_address','$nok_phone','$relationship',SYSDATE(),'$email')";
            
                $sql = $database->query($sqlQuery);
                if($sql){
                    $result = "<div class='alert alert-success text-center'>Patient registered successfully with hospital number ".$hospitalNumber." <br><br> Patient can make use of patient appointment portal. Login OTP will always be sent to ".$email."</div>";
                    $firstname = "";
                    $lastname = "";
                    $gender = "";
                    $marital_status = "";
                    $religion = "";
                    $place_of_birth = "";
                    $state_of_origin = "";
                    $lga = "";
                    $tribe = "";
                    $country = "";
                    $state_of_residence = "";
                    $address = "";
                    $email = "";
                    $patient_phone = "";
                    $nok_name = "";
                    $nok_address = "";
                    $nok_phone = "";
                    $relationship = "";
                }else{
                    $result = $database->error;
                }
                
            }
            
        }
    
    ?>

    <section class="container my-5">
        <div class="row my-5">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
              <span class="float-start"><a href="home.php" class="text-decoration-none text-primary"><i class="bi bi-arrow-left"></i></a></span>  Register patient
            </div>

    
        <form action="register_patient.php" METHOD="POST">
            <div class="w-100"><?php echo $result; ?></div>
            <!--Home page view for Patients-->  
            <div class="row p-5 mt-5 bg-white">
                <div class="col-12 bg-secondary p-3 text-primary fw-bold fs-6 mb-3 rounded">Bio data</div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                      <label for="firstname" class="form-label">Firstname</label>
                        <input type="text"
                            class="form-control" name="firstname" id="firstname" aria-describedby="helpId" placeholder="" value="<?php echo $firstname; ?>">
                     
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Lastname</label>
                        <input type="text" value="<?php echo $lastname; ?>"
                            class="form-control" name="lastname" id="lastname" aria-describedby="helpId" placeholder="">
                    
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select
                            class="form-control" name="gender" id="gender" aria-describedby="helpId" placeholder="">
                            <option><?php echo $gender; ?></option>
                            <option>MALE</option>
                            <option>FEMALE</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="marital_status" class="form-label">Marital status</label>
                        <select
                            class="form-control" name="marital_status" id="marital_status" aria-describedby="helpId" placeholder="">
                            <option><?php echo $marital_status; ?></option>
                            <option>SINGLE</option>
                            <option>MARRIED</option>
                            <option>DIVORCED</option>
                            <option>WIDOW</option>
                            <option>WIDOWER</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="religion" class="form-label">Religion</label>
                        <select
                            class="form-control" name="religion" id="religion" aria-describedby="helpId" placeholder="">
                            <option><?php echo $religion; ?></option>
                            <option>CHRISTIAN</option>
                            <option>ISLAM</option>
                            <option>TRADITIONAL</option>
                            <option>OTHERS</option>
                        </select>
                        
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    
                    <div class="mb-3">
                        <label for="place_of_birth" class="form-label">Place of birth</label>
                        <input type="text" value="<?php echo $place_of_birth; ?>"
                            class="form-control" name="place_of_birth" id="place_of_birth" aria-describedby="helpId" placeholder="">
                        
                    </div>
    
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="state" class="form-label">State of origin</label>
                        <select
                            class="form-control" name="state_of_origin" id="state_of_origin" aria-describedby="helpId" placeholder="">
                            <option><?php echo $state_of_origin; ?></option>
                            <option>IGBO</option>
                            <option>HAUSA</option>
                            <option>YORUBA</option>
                        </select>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="lga" class="form-label">LGA</label>
                        
                        <select
                            class="form-control" name="lga" id="lga" aria-describedby="helpId" placeholder="">
                            <option><?php echo $lga; ?></option>
                            <option>LGA 1</option>
                            <option>LGA 2</option>
                            <option>LGA 3</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
    
                    <div class="mb-3">
                        <label for="tribe" class="form-label">Tribe</label>
                        <select
                            class="form-control" name="tribe" id="tribe" aria-describedby="helpId" placeholder="">
                            <option><?php echo $tribe; ?></option>
                            <option>IGBO</option>
                            <option>HAUSA</option>
                            <option>YORUBA</option>
                        </select>
                        
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select
                            class="form-control" name="country" id="country" aria-describedby="helpId" placeholder="">
                            <option>NIGERIA</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="state_of_residence" class="form-label">State of residence</label>
                        <input type="text" value="<?php echo $state; ?>"
                            class="form-control" name="state_of_residence" id="state_of_residence" aria-describedby="helpId" placeholder="">
                        
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of birth</label>
                        <input type="date" value="<?php echo $dob; ?>"
                            class="form-control" name="dob" id="dob" aria-describedby="helpId" placeholder="">
                        
                    </div>
                </div>
                
                
                
                <div class="col-12 bg-secondary p-3 text-primary fw-bold fs-6 mb-3 rounded">Contact</div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="address" class="form-label">House address (in full)</label>
                        <textarea
                            class="form-control" name="address" id="address" aria-describedby="helpId" placeholder=""><?php echo $address; ?></textarea>
                        
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" value="<?php echo $email; ?>"
                            class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="">
                        
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="patient_phone" class="form-label">Phone number</label>
                        <input type="text" value="<?php echo $patient_phone; ?>"
                            class="form-control" name="patient_phone" id="patient_phone" aria-describedby="helpId" placeholder="">
                        
                    </div>
                </div>
                
                <div class="col-12 bg-secondary p-3 text-primary fw-bold fs-6 mb-3 rounded">Next of Kin details</div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="nok_name" class="form-label">Next of kin name</label>
                        <input type="text" value="<?php echo $nok_name; ?>"
                            class="form-control" name="nok_name" id="nok_name" aria-describedby="helpId" placeholder="">
                        
                    </div>
                </div>
                
                
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="nok_phone" class="form-label">Next of kin phone</label>
                        <input type="text" value="<?php echo $nok_phone; ?>"
                            class="form-control" name="nok_phone" id="nok_phone" aria-describedby="helpId" placeholder="">
                        
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="relationship" class="form-label">Relationship</label>
                        <input type="text" value="<?php echo $relationship; ?>"
                            class="form-control" name="relationship" id="relationship" aria-describedby="helpId" placeholder="">
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="mb-3">
                        <label for="nok_address" class="form-label">Next of kin address</label>
                        <textarea
                            class="form-control" name="nok_address" id="nok_address" aria-describedby="helpId" placeholder=""><?php echo $nok_address; ?></textarea>
                        
                    </div>
                </div>
                <!--<div class="col-lg-4 col-md-6 col-sm-12">-->
                <!--    <div class="mb-3">-->
                <!--        <label for="password" class="form-label">Password</label>-->
                <!--        <input type="text" value="<?php echo $password; ?>"-->
                <!--            class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="">-->
                        
                <!--    </div>-->
                <!--</div>-->
                <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                    <div class="mb-3">
                        
                        <input type="submit" class="btn btn-lg form-control bg-primary text-white" name="registerPatient" value="Register patient">
                        
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