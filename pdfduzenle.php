<?php

    if( isset($_POST["gonder"])) {
        // echo "<pre>"; print_r($_POST); echo "</pre>";
        $SayfaSayisi = intval($_POST["toplamsayfa"]);
        $arrSonuc = array();
        for($i=1; $i<=$SayfaSayisi; $i++) {
            $arrSonuc[$i] = trim("$i");
            if( isset($_POST["sol"][$i]) ) $arrSonuc[$i] = trim("$i") . "left";
            if( isset($_POST["sag"][$i]) ) $arrSonuc[$i] = trim("$i") . "right";
        }
        $Sayfalar = implode(" ", $arrSonuc);
        $KOMUT = "pdftk ./upload/ILRAPORU.pdf cat $Sayfalar output ./upload/YENI.pdf";
        $cevap = shell_exec($KOMUT);
        
        $KOMUT = "mv ./upload/YENI.pdf ./upload/ILRAPORU.pdf";
        $cevap = shell_exec($KOMUT);
        header("Location: ?"); 
        die();

    }

    // Yeni resimleri hazırlayalım
    $KOMUT = 'rm -f ./pul/*.jpg; convert -compress jpeg -quality 70 -density 40x40 -units PixelsPerInch ./upload/ILRAPORU.pdf pul/sayfa-%04d.jpg';
    $cevap = shell_exec($KOMUT);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>İl Raporu Sayfalarını Düzenleme</title>
</head>
<body >

    <form method="post" action="" enctype="multipart/form-data">

        <h1>İl Raporu Sayfalarını Düzenleme</h1>

        <p><a href='index.php'>Ana Sayfaya Git</a></p>
        
    <style>
        body {
            background-color:  lightgrey;
        }
        img {
            margin: 5px;
            border: 1px solid grey;
            height: 150px;
        }
        div {
            width: 200px;
            height: 230px;
            text-align: center;
            float:  left;
            overflow: hidden;
            border-bottom: 1px solid darkgrey;
            border-right: 1px solid darkgrey;
            padding: 5px;
        }
        .LabelA {font-size: 30px; margin-right: 15px; background-color: #A5D6A7 !important; margin: 2px; display: inline-block; border-radius: 5px; border: 1px solid #33691E;}
        .LabelB {font-size: 30px; margin-left:  15px; background-color: #A5D6A7 !important; margin: 2px; display: inline-block; border-radius: 5px; border: 1px solid #33691E;}

        .SOL {transform: rotate(-90deg);}
        .SAG {transform: rotate( 90deg);}
        .NORMAL {transform: rotate( 0deg);}

    </style>

<script>
    function Cevir(ResimNo, ResimYon) {
        // console.log(ResimNo, ResimYon)
        document.getElementById(ResimNo).className = 'NORMAL';
        if(document.getElementById(ResimYon + ResimNo).checked == true) {
            document.getElementById(ResimNo).className = ResimYon;
        }

    }
</script>

        <?php 
            chdir("./pul/");
            $Resimler = glob("sayfa*.jpg");
            chdir("..");
            $c=1;
            foreach ($Resimler as $Resim) {
                echo "<div>
                        <img id='$c' src='pul/$Resim'><br>
                        <label class='LabelA'>
                            <input id='SOL$c' type='checkbox' name='sol[$c]' onclick=\"Cevir($c, 'SOL')\">&#8630;
                        </label>
                        $c
                        <label class='LabelB'>
                            <input id='SAG$c' type='checkbox' name='sag[$c]' onclick=\"Cevir($c, 'SAG')\">&#8631;
                        </label>
                      </div>";
                $c++;
            }
            echo "<br style='clear: both; '>";
        ?>


        <input type="hidden" name="toplamsayfa" value="<?php echo $c - 1; ?>"></p>
        <p><input type="submit" name="gonder" value="Gönder"></p>

        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>


    </form>
    </body>
</html>