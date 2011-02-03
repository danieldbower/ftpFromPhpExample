<?php
  function ftpConnectionString(){
    return 'ftp://testuser:password@localhost';
  }

  function getFromFtp($dirForFile, $fileToFetch){
    return file_get_contents(ftpConnectionString() . $dirForFile . $fileToFetch);
  }

  function sendToFtp($dirForFile, $fileToFetch, $putContents){
    # create a stream context telling PHP to overwrite the file
    $options = array('ftp' => array('overwrite' => true)); 
    $stream = stream_context_create($options); 

    if ($putContents){ 
      return file_put_contents(ftpConnectionString() . $dirForFile . $fileToFetch, $putContents, 0, $stream);
    } else {
      return 0;
    }
  }
?>

<html>
<head><title>ftp api</title></head>
<body>

<?php
  if(isset($_POST['api']) && ($_POST['api'] == 'get') ) {
      echo getFromFtp($_POST['dirName'], $_POST['fileName']);
            
  } elseif(isset($_POST['api']) && $_POST['api'] == 'send') {
      echo sendToFtp($_POST['dirName'], $_POST['fileName'], $_POST['contents']);

  } else {
?>
      <h2>Put File</h2>
        <form method="post">
            <input type="text" name="api" value="send">
            <input type="text" name="dirName" value="/home/testuser/">
            <input type="text" name="fileName" value="testfile2.txt">
            <input type="text" name="contents">
            <input type="submit">
        </form>
<?php
  }
?>

</body>
</html>
