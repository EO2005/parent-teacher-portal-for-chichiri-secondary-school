<?php
    class Admin{

        /*
            This section of the code provides that admin to Manage
            The users and non-users of the system as
            well as the other entites , these are just crud functionalites so the system can work as 
            expected.
        */
    
            /*
                - Managing Parents
            */
    
            function addParent($parent_id, $first_name, $password, $last_name, $phone_number, $email_address, $address, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $addParent = "insert into parents values('$parent_id', '$password', '$first_name', '$last_name', '$phone_number', '$email_address', '$address')";
                $query = mysqli_query($conn, $addParent);;
                if($query == true){
                    echo "<script>alert('Parent Added Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Add Parent'); window.history.back();</script>";
                    echo $conn->error;
                }
                $conn->close();
            } 
    
            function editParent($parent_id, $first_name, $last_name, $phone_number, $email_address, $address, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $updateParents = "update parents set first_name='$first_name', last_name='$last_name', phone_number='$phone_number', email_address='$email_address', address='$address' where parent_id = '$parent_id'";
                $query = mysqli_query($conn, $updateParents);
                if($query == true){
                    echo "<script>alert('Parent Updated Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Update Parent'); window.history.back();</script>";
                }
                $conn->close();
            }
    
            function deleteParent($parent_id, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $deleteParent = "delete from parents where parent_id = '$parent_id'";
                $query = mysqli_query($conn, $deleteParent);
                if($query == true){
                    echo "<script>alert('Parent Deleted Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Delete Parent'); window.history.back();</script>";
                }
                $conn->close();
            }
    
            /*
                - Managing Teachers
            */
    
            function addTeachers($teacher_id, $password, $first_name, $last_name, $gender, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $addTeachers = "insert into teachers values('$teacher_id', '$password', '$first_name', '$last_name', '$gender')";
                $query = mysqli_query($conn, $addTeachers);;
                if($query == true){
                    echo "<script>alert('Teacher Added Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Add Teacher'); window.history.back();</script>";
                }
                $conn->close();
            }
            
            // ... (similar updates for editTeachers and deleteTeachers)
    
            /*
                - Managing Subjects
            */
    
            function addSubject($subject_name, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $addSubject = "insert into subjects(subject_name) values('$subject_name')";
                $query = mysqli_query($conn, $addSubject);;
                if($query == true){
                    echo "<script>alert('Subject Added Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Add Subject'); window.history.back();</script>";
                }
                $conn->close();
            }
    
            function deleteSubjects($subject_id, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $deleteSubject = "delete from subjects where subject_id = '$subject_id'";
                $query = mysqli_query($conn, $deleteSubject);
                if($query == true){
                    echo "<script>alert('Subject Deleted Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Delete Subject'); window.history.back();</script>";
                }
                $conn->close();
            }
    
            /*
                - Managing Classes
            */
    
            function addClasses($class_name, $date_enrolled ,$location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $addClasses = "insert into classes(class_name, date_enrolled) values('$class_name', '$date_enrolled')";
                $query = mysqli_query($conn, $addClasses);;
                if($query == true){
                    echo "<script>alert('Class Added Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Add Class'); window.history.back();</script>";
                }
                $conn->close();
            }
            
            function deleteClasses($class_id, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $deleteClass = "delete from classes where class_id = '$class_id'";
                $query = mysqli_query($conn, $deleteClass);
                if($query == true){
                    echo "<script>alert('Class Deleted Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Delete Class'); window.history.back();</script>";
                }
                $conn->close();
            }
    
            /*
                - Manage Students
            */
    
            function addStudents($student_id, $first_name, $last_name, $date_of_birth, $gender, $address, $parent_id, $class_id, $location) {
                // Create a database connection
                $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                
                // Check if the connection was successful
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                // Insert student information into the 'students' table
                $addStudent = "INSERT INTO students (student_id, first_name, last_name, date_of_birth, address, gender)
                               VALUES ('$student_id', '$first_name', '$last_name', '$date_of_birth', '$address', '$gender')";
                $query1 = mysqli_query($conn, $addStudent);
                
                // Insert student-parent relationship into the 'student_parents' table
                $insertStudentToParent = "INSERT INTO student_parents (student_id, parent_id)
                                          VALUES ('$student_id', '$parent_id')";
                $query2 = mysqli_query($conn, $insertStudentToParent);
                
                // Insert student-class relationship into the 'student_classes' table
                $insertStudentToClass = "INSERT INTO student_classes (student_id, class_id)
                                         VALUES ('$student_id', '$class_id')";
                $query3 = mysqli_query($conn, $insertStudentToClass);
                
                // Check if all queries were successful
                if ($query1 && $query2 && $query3) {
                    echo "<script>alert('Student Added Successfully'); window.history.back();</script>";
                    header("Location: $location");
                } else {
                    echo "<script>alert('Failed To Add Student'); window.history.back();</script>";
                    echo $conn->connect_error;
                }
                
                // Close the database connection
                $conn->close();
            }
            
            
            // ... (similar updates for editStudents and deleteStudents)
    
            function editStudents($student_id, $first_name, $last_name, $address, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $updateStudents = "update students set first_name = '$first_name', '$last_name', '$address' where student_id = '$student_id'";
                $query = mysqli_query($conn, $updateStudents);
                if($query == true){
                    echo "<script>alert('Student Updated Successfully'); window.history.back();</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Update Student'); window.history.back();</script>";
                }
                $conn->close();
            }
            
            function deleteStudents($student_id, $location){
                $conn = new mysqli('localhost','root','','parent_teacher_portal_chichiri');
                $deleteStudent = "delete from students where student_id = '$student_id'";
                $query = mysqli_query($conn, $deleteStudent);
                if($query == true){
                    echo "<script>alert('Student Deleted Successfully')</script>";
                    header("Location:" . $location);
                }
                else{
                    echo "<script>alert('Failed To Delete Student'); window.history.back();</script>";
                }
                $conn->close();
            }
    }
?>