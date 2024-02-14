<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST["json"];
    $result = json_decode($data, true);
    if(isset($result['page_conf']['ipp'])) {
        $ipp = $result['page_conf']['ipp'];
        $_SESSION['page']=$ipp;
        echo $ipp;
    }
}

$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
//echo $currentPage;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hekmah</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?// echo (isset($_GET['page'])?$_GET['page']:1);?>
    <?php echo "<form action='q2.php' method='post' >"; ?>
        <textarea name="json" rows="7" ></textarea>
        <input type="submit" class="generate" name="generate" value="Generate">
    </form>

    <div class="container">
      <img src="logo/Logo2.png" alt="">
      <br style="color:#eee"> 
      <?php
      /*if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if($_POST["val"]==1)
        getTextv(0,2);
        elseif($_POST["val"]==2)
        getTextv(3,5);
        else
        getTextv(6,7);

      }else
      getTextv(1,3);*/
      $ipp = isset($_SESSION['page']) ? $_SESSION['page'] : 4;
      
      
      if(isset($_GET['page'])) {
          $n = $_GET['page'];
          $startPoint = (($n - 1) * $ipp);
          $endPoint = (($n - 1) * $ipp) + $ipp;
          getTextv($startPoint, $endPoint);
      } else {
          
          $n = 1;
          $startPoint = (($n - 1) * $ipp);
          $endPoint = (($n - 1) * $ipp) + $ipp;
          getTextv($startPoint, $endPoint);
      }

?>
    </div>
    <div class="bottombar">
<?php
    $numPage = 3;
    for($i = 1;$i <= $numPage;$i++) {
      echo "<a href='?page=" . $i . "'>" . $i . "</a>";
    }
?>
    </div>
</body>
</html>
<?php
function getTextv($start = 0, $end = 0)
{
    $hekmaSections = [];
    $images = glob("images/*.jpg");
    $Handle = fopen("captions\captions.txt", "r");
    fgets($Handle);

    foreach($images as $image) {
        $Data = fgetcsv($Handle, 1000, ";");
        $hekmaSections[] = [
          'title' => $Data[2],
          'author' => $Data[1],
          'image' => $image
        ];

    }

    //$paggge=isset($ipp)?$ipp:3;
    //count($hekmaSections)/($paggge);

    for($i = $start;$i < $end;$i++) {
        if($i == count($hekmaSections)) {
            break;
        }
        setValueinner($hekmaSections[$i]);
    }

}

function setValueinner($hekmaSections)
{
    $hekmaSection = $hekmaSections;
    echo "<div class='content'>";
    echo  "<img class='img-content' src=" . $hekmaSection["image"] . " alt=''>";
    echo    "<div class='para'>";
    echo     "<p>" . $hekmaSection["author"] . "</p>";
    echo     "<p>" . $hekmaSection["title"] . "</p>";
    echo  "</div>";
    echo "</div>";
}

