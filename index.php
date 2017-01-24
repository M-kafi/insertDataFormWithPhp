<?php
error_reporting(0);
require 'db/connect.php';
require 'db/security.php';


 $records = array();

if ( !empty($_POST) ){
    if( isset( $_POST['first_name'],$_POST['last_name'],$_POST['bio'] ) ){
    $first_name = trim( $_POST['first_name']);
    $last_name  = trim( $_POST['last_name']);
    $bio        = trim($_POST['bio']);

        if ( !empty( $first_name )&& !empty( $last_name ) && !empty($bio) ){

          $statement  = $db->prepare("INSERT INTO
                                      people(first_name,last_name,bio,created)
                                      VALUES (?,?,?,NOW() )
                                      ");

          $statement-> bind_param('sss', $first_name,$last_name,$bio );

           if( $statement->execute() ){
             header( 'Location: index.php ' );
             die();

           }


        }

  }

}
 //////////////////////////////////


  if ( $results = $db->query( " SELECT * FROM people " ) ){

      if ( $results ->num_rows ){
           while ( $row = $results->fetch_object() ){
             $records[]= $row;


           }
           $results->free();

      }



  }





?>
<!DOCTYPE >

<html>

<head>

<title> people </title>

</head>

<body>
  <h3> people </h3>
<?php
   if ( !count($records) ){
    echo 'No records found.';
  }else{
 ?>
    <table>
            <thead>
                    <tr>
                        <th> First name </th>
                        <th> Last name </th>
                        <th> Bio </th>
                        <th> Created </th>
                     </tr>

            </thead>
            <tbody>
            <?php  foreach($records as $r){ ?>
                   <tr>
                       <td> <?php echo escape($r->first_name) ; ?></td>
                       <td> <?php echo escape($r->last_name) ; ?> </td>
                       <td> <?php echo escape ($r->bio) ; ?> </td>
                       <td> <?php echo escape($r->created) ; ?></td>

                   </tr>
            <?php    } ?>

            </tbody>

        </table>
  <?php }  ?>
<hr>

<form action = "" method = "post" >
   <div class="field" >
     <lable for="first_name"> First name </label>
       <input type="text" name="first_name" id="first_name" autocomplete="off" >
   </div>
   <div class="field" >
     <lable for="last_name"> Last name </label>
       <input type="text" name="last_name" id="last_name" autocomplete="off" >
   </div>
   <div class="field" >
     <lable for="bio">Bio </label>
       <textarea name="bio" id="bio" ></textarea>
   </div>
   <input type="submit" value="Insert" >



</form>


</body>

</html>
