<?php
    // Database bağlantısı
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ogrenci_kayit";

    // Create connection
    $baglan = mysqli_connect($servername,$username,$password,$dbname);

    // Check connection
    if ($baglan -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
    }

    // kullanıcı kayıt yaptığında boş değerlerle işlem yapılmasını önlemek için if yapısı oluşturulmalı ve isset metodu kullanılmalı
    if(isset($_POST["isim"]) &&  isset($_POST["soyisim"]) && isset($_POST["no"]) && isset($_POST["sinif"])){ 
        /* şimdi if in içine geldiğimize göre tüm alanlar doldurulmuş ve değerler girilmiş. Bu değerleri 
           mysql e kaydetmeliyiz
        */

        // database de oluşturduğumuz öğrenciler tablomuza girilen değerleri kaydediyoruz.
        
        $isim = $_POST["isim"] ;
        $soyisim = $_POST["soyisim"] ;
        $no = $_POST["no"] ;
        $sinif = $_POST["sinif"] ;

        $sql_command = "INSERT INTO ogrenciler (isim,soyisim,no,sinif) VALUES ('$isim','$soyisim','$no','$sinif')";
        
        $sonuc = mysqli_query($baglan,$sql_command);

        /* Bu işlemin sonucunda işlem başarılı ise 0'dan büyük bir değer dönecektir, eğer başarısız ise 0 gibi
           bir değer dönecektir. Bir eğer(if) satırı ile durumu kontrol edip ekrana bilgi mesajı yazdırıyoruz.
        */
            if ($sonuc==0){
                echo "Eklenemedi, kontrol ediniz";
            }
            else{
            header('Location: index.php');  // Sayfayı yenilediğinde Aradığınız sayfa, girdiğiniz bilgileri kullandı. O sayfaya dönmeniz, gerçekleştirdiğiniz işlemlerin tekrarlanmasına yol açabilir. Devam etmek istiyor musunuz? yazısıyla karşılaşınca ve onayla deyince listeye bir önceki kayıdı tekrar ekliyor. Bu istemediğimiz bir şey. Bunu çözmek için yeniden aynı sayfaya yönlendirme işlemi yapıyoruz.
            }
          
        
        }

      
        if(isset($_GET["sil"])){
            $id = $_GET["sil"];
            $sil_command = "DELETE FROM ogrenciler WHERE id = '$id'";
            $silme_sonucu = mysqli_query($baglan,$sil_command);

            if($silme_sonucu){
                Header("Location:index.php");
            }
            else{
                echo "Hata";
            }
        }
        


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Kayıt Sistemi</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script> <!-- Jquery dosyasını alttaki bootstrap.min.js dosyasından önce yazman gerek !!!! ÖNEMLİ -->
    <script src="assets/js/bootstrap.min.js"></script> 
    <style>
        input,select{
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    
    <h1 class="text-center text-primary">Öğrenci Kayıt Uygulaması</h1>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 mx-auto rounded" style="background-color:black;color:white;padding:15px">  <!-- mx-auto container ı sayfada ortalar  -->
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">İsim:</label>
                        <input type="text" name="isim" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Soyisim:</label>
                        <input type="text" name="soyisim" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">No:</label>
                        <input type="text" name="no" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Sınıf:</label>
                        <select class="form-control" name="sinif">
                            <option value="" disabled selected>Lütfen bir sınıf seçiniz.</option>
                            <option value="9">9.Sınıf</option>
                            <option value="10">10.Sınıf</option>
                            <option value="11">11.Sınıf</option>
                            <option value="12">12.Sınıf</option>
                        </select>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="Kaydet" class="btn btn-warning">
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <h4 class="text-center text-danger"><b>Güncel Sınıf Listesi</b></h4>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 mx-auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>id</th>
                        <th>İsim</th>
                        <th>Soyisim</th>
                        <th width="75">No</th>
                        <th width="100">Sınıf</th>
                        <th width="100"></th>
                    </thead>
                    <tbody>
                        <tr>

                        <!-- Şimdi veritabanına kaydettiğimiz verileri buraya getirip yazdırmamız lazım -->
                        <?php
                            $deger_getir = "SELECT * FROM ogrenciler";
                            $getirdi = mysqli_query($baglan,$deger_getir);

                            while($ogrList = mysqli_fetch_array($getirdi)){ // while döngüsü sql sorgusu çalıştıktan sonra bütün satırları teker teker okuyacak. Döngünün çalışması sırasında satırlar tarafından okunan bütün verileri tutacak bir değişkene ihtiyaç var.Onun için $ogrList diye bir değişken oluşturduk. php nin de mysqli_fetch_array metodunu kullanıp içine sql komutumuzu atıyoruz.
                        ?>

                            <td><?=$ogrList["id"];?></td>  <!-- php echo yazımının kısa halidir -->
                            <td><?=$ogrList["isim"];?></td>
                            <td><?=$ogrList["soyisim"];?></td>
                            <td><?=$ogrList["no"];?></td>
                            <td><?=$ogrList["sinif"];?></td>
                            <td class="text-center"><a href="?sil=<?=$ogrList["id"];?>" class="btn btn-danger" onclick="return confirm('Silinsin mi?')">Sil</a></td> <!-- sil butonuna bastığımızda ve silinsin mi sorusuna evet dediğimizde verdiğimiz id arama çubuğunda görünecek. Bu kayıt get yöntemi ile gelmiş olacak. -->
                        
                        </tr>

                        <?php  } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>