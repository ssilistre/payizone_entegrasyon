<?php 
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

$kkno='5166435208588928';
$fiyat=1;
$ids = md5(uniqid());


if(isset($_POST["odemeyap"])){
    $token=create_token('musteriappid','app_secret');
    $payloadtoken=getPostDetail($token,$kkno,1);
    $token=$payloadtoken;
    $name='semih silistre';
    $number=$kkno;
    $exp_month='03';
    $exp_year='24';
    $cvc2='870';
    $price=1;
    $redirect='http://localhost/odeme/callback.php';
    $id=$ids;
    $note="Deneme Test Amaçlı";
    doPayment($token,$name,$number,$exp_month,$exp_year,$cvc2,$price,$redirect,$id,$note);
}

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

   <div class="col-md-6 offset-md-3">
                    <span class="anchor" id="formPayment"></span>
                    <!-- form card cc payment -->
                    <div class="card card-outline-secondary">
                        <div class="card-body">
                            <h3 class="text-center">Credit Card Payment</h3>
                            <hr>
                            <div class="alert alert-info p-2 pb-3">
                                <a class="close font-weight-normal initialism" data-dismiss="alert" href="#"><samp>×</samp></a> 
                                CVC code is required.
                            </div>
                            <form class="form" method="post" role="form" autocomplete="off">
                                <div class="form-group">
                                    <label for="cc_name">Card Holder's Name</label>
                                    <input type="text" name="kkisim" class="form-control" id="cc_name" pattern="\w+ \w+.*" title="First and last name" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" class="form-control" name="kkno" autocomplete="off" maxlength="20" pattern="\d{16}" title="Credit card number" required="">
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-12">Card Exp. Date</label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="exp_month" size="0">
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="exp_year" size="0">
                                            <option>2018</option>
                                            <option>2019</option>
                                            <option>2020</option>
                                            <option>2021</option>
                                            <option>2022</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="exp_cc" class="form-control" autocomplete="off" maxlength="3" pattern="\d{3}" title="Three digits at back of your card" required="" placeholder="CVC">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-12">Amount</label>
                                </div>
                                <div class="form-inline">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">₺</span></div>
                                        <input type="text" name="fiyat" class="form-control text-right" id="exampleInputAmount" placeholder="39">
                                        <div class="input-group-append"><span class="input-group-text">.00</span></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <button type="reset" class="btn btn-default btn-lg btn-block">Cancel</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" name="odemeyap" class="btn btn-success btn-lg btn-block">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /form card cc payment -->
           