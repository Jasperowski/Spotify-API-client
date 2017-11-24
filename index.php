<?php
/// create curl resource
$token='';
$track='';
$client_ID=$_POST['ID'];
$client_secret=$_POST['SECRET'];
$playlist_ID=$_POST['PLAY_ID'];
$name=$_POST['NAME'];
$token=base64_encode($client_ID.':'.$client_secret);
$ch = curl_init();
//header('Content-Type: application/json');
curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic $token", ''));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$return = curl_exec($ch);
$access_token=json_decode($return, true);
$access_token=$access_token['access_token'];
//var_dump($access_token);
//var_dump($return)
// set url
curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/users/$name/playlists/$playlist_ID");//
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, null);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.$access_token]);
curl_setopt($ch, CURLOPT_VERBOSE, true);
// $output contains the output string
$output = curl_exec($ch);
$decoded_output=json_decode($output, true);
$out=json_encode($decoded_output, JSON_PRETTY_PRINT);
//echo $out;
foreach($decoded_output['tracks']['items'] as $track)
{
    $image=$track['track']['album']['images'][0]['url'];//¯\_ ﾟل͜ ﾟ_/¯
//    echo "<img src=" . $image . ">";
    echo' <img src="'.$image.'">';
}
curl_setopt($ch, CURLOPT_URL, "");
// close curl resource to free up system resources
curl_close($ch);
?>


