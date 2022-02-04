<?php
//function to generate list of swappable coins
function showCoins($array){
	for ($i=0; $i<count($array['data']['coins']); $i++)
	{
			?>
					<option value="<?php print_r($array['data']['coins'][$i]['price'])."\n";?>"><?php print_r($array['data']['coins'][$i]['symbol'])."\n";;?></option>
			<?php
	}
}
//Coinranking api
$curl = curl_init();
$apiKey = readfile('API.txt');
curl_setopt_array($curl, [
	CURLOPT_URL => "https://coinranking1.p.rapidapi.com/coins?referenceCurrencyUuid=yhjMzLPhuIDl&timePeriod=24h&tiers=1&orderBy=marketCap&orderDirection=desc&limit=100&offset=0",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: coinranking1.p.rapidapi.com",
		"x-rapidapi-key: $apiKey"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$array = json_decode($response, true);
	}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$k;
	$out;
	print_r($_POST);
	//PI calculus k = x*y where k is constant
	$token1Reserve = $_POST['tvl']/2/$_POST['token1'];
	$token2Reserve = $_POST['tvl']/2/$_POST['token2'];
	echo "$token1Reserve <br>";
	echo "$token2Reserve <br>";
	$k = $token1Reserve * $token2Reserve;
	echo "$k <br>";
	$token1Reserve += $_POST['in'];
	echo "$token1Reserve";
	echo "<br>";
	$out = $token2Reserve;
	$token2Reserve = $k/$token1Reserve;


	$out -= $token2Reserve;

	echo "$out";
}
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo "AtUna @ ".date('H:i:s');?></title>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <!-- navbar -->
    <div class="main">
      <div class="nav-bar">
        <h4 class="title">AtUna DEX</h4>
        <a href="#">click here</a>
        <a href="#">click here</a>
        <a href="#">click here</a>
        <a href="#">click here</a>
        <a href="#">click here</a>
      </div>

      <div class="swap-zone">
        <form class="" action="index.php" method="post">
          <input type="number" name="in" value="" placeholder="Amount to swap" required oninvalid="this.setCustomValidity('Better if you provide an amount to swap')" onchange="this.setCustomValidity('')">
          <select name="token1"><?php showCoins($array);?></select>
					<output name="result"> <?php echo "$out"; ?> </output>
					<select name="token2"><?php	showCoins($array);?></select>
					<input type="number" name="tvl" value="" placeholder="TVL in $" required oninvalid="this.setCustomValidity('PI huge if no TVL, mate')" onchange="this.setCustomValidity('')">
          <input type="submit" name="" value="Swap">
        </form>
      </div>
    </div>
  </body>
</html>