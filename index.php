<?php

session_start();

$victoire = 0;
$tmp = 1;

if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 
    [
        [1=>0,2=>0,3=>0],
        [4=>0,5=>0,6=>0],
        [7=>0,8=>0,9=>0]
    ];

    $_SESSION['tour'] = 0;
    $tmp = 0;

} 

else {
  
    $morpion = $_SESSION['count'];
    if ($morpion[0][1]!="0"){
        if (($morpion[0][1]==($morpion[1][5]))&&($morpion[0][1]==($morpion[2][9]))){
            $victoire = 1;
        }
    }

    elseif ($morpion[0][3]!="0"){
        if (($morpion[0][3]==($morpion[1][5]))&&($morpion[0][3]==($morpion[2][7]))){
            $victoire = 1;
        }
    }
    
    for($j=1;$j<4;$j++){
        for($i=1;$i<3;$i++){
            $tmp = 1;
            if (($morpion[0][$j]!=$morpion[$i][$i*3+$j])||($morpion[0][$j]==0)){
                $tmp = 0;
                break;
            }
        }
        if ($tmp==1){
            break;
        }
    }

    if ($tmp==0){
        for($j=0;$j<3;$j++){
            for($i=1;$i<3;$i++){
                $tmp = 1;
                if (($morpion[$j][$j*3+1]!=$morpion[$j][$j*3+$i+1])||($morpion[$j][$j*3+1]==0)){
                    $tmp = 0;
                    break;
                }
            }
            if ($tmp==1){
                break;
            }
        }
    }
    

    if (isset($_GET['coup'])){
        $id = $_GET['coup'];

        if ($_GET['tour']==0){
            $symbole = "X";
            $_SESSION['tour'] = 1;
        }

        else {
            $symbole = "O";
            $_SESSION['tour'] = 0;
        }

        if (($id<4)&&($id>0)){
            $_SESSION['count'][0][$id]=$symbole;
        }
        elseif (($id<7)&&($id>3)){
            $_SESSION['count'][1][$id]=$symbole;
        }
        elseif (($id<10)&&($id>6)){
            $_SESSION['count'][2][$id]=$symbole;
        }
        header("location: index.php");
    }
}

if (isset($_GET)){
    if (isset($_GET['fin'])){
        unset($_SESSION['count']);
        session_destroy();
        header("location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morpion</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    
    <div class="container">

    <h1>Mon Morpion</h1> 

    <div class="grille">    
        <?php
            $morpion = $_SESSION['count'];
            foreach ($morpion as $row){
            
                foreach ($row as $cle=>$valeur){
                    if ($valeur==0){?> 
                        <a href="./index.php?coup=<?= $cle ?>&tour=<?= $_SESSION['tour'] ?>">
                            <div class="test"><?= "<p>0</p>"?></div>   
                        </a>  
                        <?php
                    }

                    else {
                        ?>
                        <div class="test">
                            <?= $valeur ?>  
                        </div>
                        <?php
                    }
                }  
            }   
        ?>
    </div>

    <?php
        
        if (($victoire)||($tmp)){
            echo "<h2>Victoire des ";
            if ($_SESSION['tour']==1){
                echo "X </h2>";
            }
            else {
                echo "O </h2>";
            }
        }

    ?>

    <br>
    <a class="end" href="./index.php?fin"><section>Fin</section></a>
    
</body>
</html>

