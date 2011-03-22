<?php

function scanDirectories($rootDir, $allData=array()) {
    // set filenames invisible if you want
    $invisibleFileNames = array(".", "..", ".htaccess", ".htpasswd", 'index.php');
    // run through content of root directory
    $dirContent = scandir($rootDir);
    foreach($dirContent as $key => $content) {
        // filter all files not accessible
        $path = $rootDir.'/'.$content;
        if(!in_array($content, $invisibleFileNames)) {
            // if content is file & readable, add to array
            if(is_file($path) && is_readable($path)) {
                // save file name with path

                $fileContent = file_get_contents($path);
                if(strpos($fileContent, 'extends PHPUnit_Framework_TestCase')) {
                  $allData[] = $path;
                }
              
            // if content is a directory and readable, add path and name
            }elseif(is_dir($path) && is_readable($path)) {
                // recursive callback to open new directory
                $allData = scanDirectories($path, $allData);
            }
        }
    }
    return $allData;
}

function pre($var) {
  echo '<pre>';
  if(is_array($var) || is_object($var))
    foreach($var as $k => $v) {
      echo $v."\n";
    }
  else
    echo $var;
  echo '</pre>';
}

  $testableFiles = scanDirectories('.');

  $unitTest = isset($_GET['test']) && in_array($_GET['test'], $testableFiles) ? $_GET['test'] : false;
?>
<style>
  * { font-family: Arial, sans-serif; }
  textarea, pre { font-family: Courier New, monospace; }
  a,
  a:visited { color: blue; }
  a:hover,
  a:focus,
  a:active { color: darkcyan; text-decoration: none; }

</style>
<h1>PHPSkill Test Environment</h1>
<ul>
<?php foreach($testableFiles as $k => $file): ?>
  <li><a href="?test=<?php echo $file ?>"><?php echo $file ?></a></li>
<?php endforeach; ?>
</ul>

<?php
  if($unitTest != false):

    $unitTestClass = explode('.', $unitTest);

    $cmd = 'phpunit --verbose '.substr($unitTestClass[1],1);
    
    pre($cmd);

    $lastLine = exec($cmd, $output, $retVal);
    pre($output);
    pre($retVal);

    $fileContent = file_get_contents($unitTest);

  ?>

    <form action="" method="post">
      <textarea rows="30" cols="150" name="filename"><?php echo $fileContent ?></textarea>
      
    </form>

  <?

  endif;
?>