<?php
////// Semih Silistre tarafından yazılmıştır.
//// Aşağıdaki bilgileri https://portal.payizone.com/genel-ayarlar/api sayfasından temin edebilirsiniz.

$api_key="############";
$api_secretkey="############";


////Aşağıda değiştirmeniz gereken yerlere yorum satırı ile yazdım. Onun dışında bir alan değiştirmenize gerek yoktur.
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $hashcode=$_POST['VerifyHash'];
    $otherkey=$_POST['otherCode'];
    //$kayitno=$_POST['saleID'];


    $VerifyHash = hash("sha256", ''.$api_key.'' . "|" . ''.$api_secretkey.'' . "|" . ''.$otherkey.''. "|true");
    if($VerifyHash == $_POST['VerifyHash']) {

        ////ödeme başarılı adımlarını bu alana yazınız.
        $payment_status = true;
        echo 'Ödeme başarılı';
        echo $otherkey.'nolu fatura ödenmiştir.';
    } else {
        //ödeme başarısız ise bu adımlarını bu alana yazınız.

        $payment_status = false;
        echo 'Ödeme başarırız.';
    }
}

?>
Semih