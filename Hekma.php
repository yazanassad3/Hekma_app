<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
  </head>
<style>


</style>
<body>
    <div class="container">
      <img src="logo/Logo2.png" alt="">
      <br style="color:#eee"> 
      <?php 
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST["val"]==1)
        getTextv(0,2);
        elseif($_POST["val"]==2)
        getTextv(3,5);
        else
        getTextv(6,7);

      }else
      getTextv(1,3);

      ?>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="POST" >
      <input type="submit" name="val" value='1'>
      <input type="submit" name="val" value='2'>
      <input type="submit" name="val" value='3'>
    </form>
</body>
</html>
<?php
function getTextv($start=0,$end=0){
  $hekmaSections=[];
  $images = glob(  "images/*.jpg");
  $Handle=fopen("captions\captions.txt","r");
  fgets($Handle);
  
  foreach($images as $image)
  { 
    $Data=fgetcsv($Handle,1000,";");
    $hekmaSections[] = [
      'title' => $Data[2],
      'author' => $Data[1],
      'image' => $image
    ];
   
  }
  for($i=$start;$i<=$end;$i++){
    setValueinner($hekmaSections[$i]);
  }

}

function setValueinner($hekmaSections){
  $hekmaSection=$hekmaSections; 
  echo "<div class='content'>";
  echo  "<img class='img-content' src=". $hekmaSection["image"]." alt=''>";
  echo    "<div>";
  echo     "<p>".$hekmaSection["author"]."</p>";
  echo     "<p>". $hekmaSection["title"]."</p>";
  echo  "</div>";
  echo "</div>";
}