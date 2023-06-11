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
        require("api/config.php");
    ?>

    <section class="container my-5">
        <div class="row my-5">
            <div class="col-lg-12 col-md-12 col-sm-12 mx-auto fs-1 fw-bolder text-center">
              <span class="float-start fs-6"><a href="home.php" class="text-decoration-none text-primary"><i class="bi bi-arrow-left"></i></a></span>  List of patients
            </div>

            <div class="col-lg-12 overflow-auto mt-5">
                <table class="table table-bordered" style="white-space: nowrap;">
                    <tr>
                        <td>#</td>
                        <td>HOSPITAL NUMBER</td>
                        <td>Firstname</td>
                        <td>Lastname</td>
                        <td>Date of birth</td>
                        <!--<td>Age</td>-->
                        <td>Gender</td>
                        <td>Marital status</td>
                        <td>Religion</td>
                        <td>Place of birth</td>
                        <td>State of origin</td>
                        <td>Local Government Area</td>
                        <td>Tribe</td>
                        <td>Country</td>
                        <!--<td>State of residence</td>-->
                        <td>Address</td>
                        <!--<td>Email</td>-->
                        <td>Phone number</td>
                        <td>Next of kin (Name)</td>
                        <td>Next of kin (Address)</td>
                        <td>Next of kin (Phone number)</td>
                        <td>Next of kin (relationship)</td>
                    </tr>
                    <?php
                    
                        global $database;
                        
                        $sqlQuery = "SELECT * FROM patients ORDER BY STAMPDATE ASC";
                        $sql = $database->query($sqlQuery);
                        while($rows = $sql->fetch_array()){
                            $result = "<tr>";
                            $result .= "<td>".$rows['id']."</td>";
                            $result .= "<td>".$rows['hospital_number']."</td>";
                            $result .= "<td>".$rows['firstname']."</td>";
                            $result .= "<td>".$rows['lastname']."</td>";
                            $result .= "<td>".$rows['dob']."</td>";
                            // $result .= "<td>".$rows['ID']."</td>";
                            $result .= "<td>".$rows['gender']."</td>";
                            $result .= "<td>".$rows['marital_status']."</td>";
                            $result .= "<td>".$rows['religion']."</td>";
                            $result .= "<td>".$rows['place_of_birth']."</td>";
                            $result .= "<td>".$rows['state_of_origin']."</td>";
                            $result .= "<td>".$rows['lga']."</td>";
                            $result .= "<td>".$rows['tribe']."</td>";
                            $result .= "<td>".$rows['country']."</td>";
                            // $result .= "<td>".$rows['ID']."</td>";
                            $result .= "<td>".$rows['address']."</td>";
                            // $result .= "<td>".$rows['ID']."</td>";
                            $result .= "<td>".$rows['phone']."</td>";
                            $result .= "<td>".$rows['next_of_kin_name']."</td>";
                            $result .= "<td>".$rows['next_of_kin_address']."</td>";
                            $result .= "<td>".$rows['next_of_kin_pphone']."</td>";
                            $result .= "<td>".$rows['relationship']."</td>";
                            $result .= "</tr>";
                            
                            echo $result;
                            
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