<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
print_r($_GET["id"]);
// Process delete operation after confirmation
if(isset($_GET["id"]) && !empty($_GET["id"])){
    // Include config file
    require_once "../Controllers/config.php";
    //$param_id = trim($_GET["id"]);
    // Prepare a delete statement
    $sql = "DELETE FROM general WHERE id = ?";
    
    $param_id = trim($_GET["id"]);
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
 
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $sql1 = "DELETE FROM datos WHERE idgeneral = ?";
            if($stmt1 = mysqli_prepare($link, $sql1)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt1, "i", $param_id);
                
                // Set parameters
                $param_id = trim($_GET["id"]);
                if(mysqli_stmt_execute($stmt1)){

                }
            }
            
            
        } else{
            echo "Something went wrong. Please try again later.";
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
    
    $sql = "DELETE FROM fotos WHERE idgeneral = ?";
    if($stmt = mysqli_prepare($link, $sql)){

        mysqli_stmt_bind_param($stmt, "i", $param_id);
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: /PhpProject1/app/Views/index.php");
            exit();            
        }
    }
    else{
            echo "Something went wrong. Please try again later.";
        }
    
    
    
    
   
        // Set parameters
    
    
    
    if(mysqli_stmt_execute($stmt)){
        
    }    
        

    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: /PhpProject1/app/Views/error.php");
        exit();
    }
}
?>