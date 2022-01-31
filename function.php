<?php 
//Semih Silistre tarafından kodlanmıştır.
//Bu alanda bir şeyi değiştirmenize gerek yoktur.
ob_start();

function create_token($musteriappid,$app_secret){
    $ch = curl_init("https://service.payizone.com/token");
    $payload = json_encode( array( "app_id"=> $musteriappid, "app_secret" => $app_secret ) );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result);
    return $result->token;
}

function getPostDetail($token,$number,$price){
    $authorization = "Authorization: Bearer ".$token;
    $ch = curl_init("https://service.payizone.com/getPos");
    $payload = json_encode( array( "card_number"=> $number, "amount" => $price ) );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result);
    return $result->payToken;
}
function doPayment($token,$name,$number,$month,$year,$cvc2,$price,$redirect,$id,$note){
    $ch = curl_init("https://service.payizone.com/pay3D");
    $payload = json_encode( array( "card_holder"=> $name, "card_number" => $number, "exp_month" => $month, "exp_year" => $year, "cvv" => $cvc2, "amount" => $price, "payment_token" => $token, "redirect_url" => $redirect, "other_code" => $id, "note" => $note) );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result);
    $adres=$result->redirectUrl;
    //print_r($result);
    header("Location:$adres");
    exit;
}





?>