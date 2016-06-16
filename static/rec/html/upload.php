<?php
$php_path = 'uploads/rec/';
$save_folder = '../../../'.$php_path;
//echo $save_folder;exit;

if(! file_exists($save_folder)) {
  if(! mkdir($save_folder)) {
    die("failed to create save folder $save_folder");
  }
 }

function valid_wav_file($file) {
  $handle = fopen($file, 'r');
  $header = fread($handle, 4);
  list($chunk_size) = array_values(unpack('V', fread($handle, 4)));
  $format = fread($handle, 4);
  fclose($handle);
  return $header == 'RIFF' && $format == 'WAVE' && $chunk_size == (filesize($file) - 8);
}

$key = 'filename';
$tmp_name = $_FILES["upload_file"]["tmp_name"][$key];
$upload_name = $_FILES["upload_file"]["name"][$key];
$type = $_FILES["upload_file"]["type"][$key];
$filename = "$save_folder".time()."$upload_name";
$filename_sql="$php_path".time().rand(0,1000).".mp3";
$saved = 0;


if( valid_wav_file($tmp_name)) {
  $saved = move_uploaded_file($tmp_name, $filename) ? 1 : 0;
  exec("ffmpeg.exe -i $filename ../../../$filename_sql",$out,$status);
  unlink($filename);
}
$arr=array(
		'saved'=>$saved,
		'url'=>$filename_sql
		);
		$arr=json_encode($arr);

if($_POST['format'] == 'json') {
  header('Content-type: application/json');
  print $arr;
} else {
  print $saved ? "Saved" : 'Not saved';
}

exit;
?>
