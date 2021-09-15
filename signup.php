<?php
    session_start();
    include("include/connection.php");
    include("include/common_functions.php");
    $msg='';
    if(isset($_POST['upload'])){

        $target = "images/".basename($_FILES['image']['name']);
        $image=$_FILES['image']['name'];
        
        $user_type=$_POST['user_type'];
        
        $full_name=$_POST['full_name'];
        $contact=$_POST['contact'];
        $email = $_POST['email'];
        $pasword = $_POST['password'];
        $hashed_pass = get_hash($pasword);

        echo $user_type;
        echo $full_name;

        if(!empty($full_name) && !empty($pasword) && !empty($email)){
            $condition_check="select * from User where email = '$email'";
            $result = mysqli_query($con,$condition_check);
            if(!mysqli_num_rows($result)>0){
                $query = "insert into User (user_name,contact,password,email,user_image,user_type) values('$full_name','$contact','$hashed_pass','$email','$image','$user_type');";
                mysqli_query($con,$query);
                
                if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
                    $msg = "Image Uploaded";
                    header("Location: login.php");
                }
                else{
                    $msg = "There was problem in uploading the image";
                }
                die;

            }else{
                $msg = "Email is already in Use";
            }
        }else{
            echo "Please enter valid input";
        }

        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="css/auth.css" rel="stylesheet">
</head>
<body>
    <main class="container my-5">
    <div class="row">
        <section class="col-md-6 my-5 offset-md-3">

        <div class="card shadow p-5">
            <form method="POST" enctype="multipart/form-data">

            <h3 class="text-center text-uppercase mb-4">Register</h3>
            <hr>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" placeholder="Full Name" name="full_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Contact</label>
                <input type="number" placeholder="contact" name="contact" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" placeholder="Email" name="email" class="form-control" required>
            </div>

            <label for="Password">Password</label>
            
            <div class="input-group mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" aria-label="Enter Password" aria-describedby="basic-addon2" required>    
            </div>
            
            <div class="form-group">
                <label>User Image</label>
                <input type="file" name="image" placeholder="Image" class="form-control" required>
            </div>

            <label for="User Type">User Type</label>
            
            <div class="input-group mb-3">
                <select  name="user_type" id="user_type" class="form-select"  aria-describedby="basic-addon2">
                    <option value="customer">Customer</option>
                    <option  value="land owner">Property Manager</option>   
                    <option  value="admin">Admin</option>
                </select>
                
            </div>

            <div class="form-group">
                <input name="upload"  type="submit" class="btn btn-block btn-secondary rounded-pill mt-3" value="Register User">
            </div>

            <p class="mt-3 text-white">Already have an Account ? <a href="login.php" class="text-white"> Login Here</a></p>

            </form>
        </div>
        </section>
    </div>
    </main>
</body>
</html>