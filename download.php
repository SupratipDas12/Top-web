<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$url = $data['url'] ?? '';

if(!$url){
    echo json_encode(["error"=>"No URL"]);
    exit;
}

$folder = "videos/";
if(!is_dir($folder)) mkdir($folder);

$filename = time().".mp4";
$output = $folder.$filename;

/*
 yt-dlp command
 -f mp4 = mp4 format
 -o = output file
*/
$cmd = "./yt-dlp -f mp4 -o \"$output\" \"$url\" 2>&1";
exec($cmd, $out, $status);

if($status !== 0){
    echo json_encode(["error"=>"Download failed"]);
    exit;
}

echo json_encode([
    "video"=>$output
]);
