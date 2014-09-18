<?php
//compile less to css

//The compile method compiles a string of LESS code to CSS.
require get_template_directory() . '/inc/lessc.inc.php';

$less = new lessc;

//The compileChecked method is like compileFile, but it only compiles if the output file doesn’t exist or it’s older than the input file:
$inputFile = get_template_directory() . '/assets/less/init.less';
$outputFile = get_template_directory() . '/assets/css/app.css';

$less = new lessc;

function autoCompileLess($inputFile, $outputFile) {
  // load the cache
  $cacheFile = $inputFile.".cache";

  if (file_exists($cacheFile)) {
    $cache = unserialize(file_get_contents($cacheFile));
  } else {
    $cache = $inputFile;
  }

  $less = new lessc;
  $newCache = $less->cachedCompile($cache);

  if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
    file_put_contents($cacheFile, serialize($newCache));
    file_put_contents($outputFile, $newCache['compiled']);
  }
}

autoCompileLess( $inputFile, $outputFile);

//If there any problem compiling your code, an exception is thrown with a helpful message:
try {
  $less->compile("invalid LESS } {");
} catch (exception $e) {
  echo "fatal error: " . $e->getMessage();
}