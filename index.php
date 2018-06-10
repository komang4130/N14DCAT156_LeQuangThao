<?php
  include("header.php"); 

  if ( !isset($_SESSION["is_logged"]))
  {
  	header("Location: login.php");
  	exit();
  }
  $res = $conn->query("SELECT id,song_name,link,enc_file FROM song");
  if ( !$res )
  {
    echo "<script>alert('There is no song in the list yet.');</script>";
  }
  else
  {
    $html = "";
    while ( $row = $res->fetch_assoc() )
    {
      $kq = exec("python unsteg.py ".$row["enc_file"]);
      $html = $html."<li class='list-group-item'>
  <span>Song name: ".$row["song_name"]."<br/>"."</span>
    <audio controls='controls'>
      <source src="."'".$row["link"]."'".">
    </audio>
   <br/>
   Secret message: ".$kq."
  </li>";
    }
    $res->close();
    $conn->close();
  }

?>  
<div class="container">
  <ul class="list-group">
  <?php echo $html; ?>
</ul>
</div>
