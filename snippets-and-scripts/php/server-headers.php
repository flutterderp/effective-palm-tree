<?php
if(function_exists('opcache_reset'))
{
  opcache_reset();
}

$utc_tz = new DateTimeZone('UTC');
$today  = new DateTime(null, $utc_tz);

header('Cache-Control: no-store, max-age=0');
header('Last-Modified: ' . $today->format('r'));
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script Afar Single Bucket</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wgth@400;700&family=Source+Sans+Pro:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">

    <style>
      * { margin: 0; padding: 0; }
      html { font-family: 'Source Serif Pro', Georgia, 'Times New Roman', Times, serif; font-size: 100%; line-height: normal; }
      html, body { background: #fefefe; color: #0a0a0a; }

      code, pre { background: #fafafa; border: 1px solid #aaa; border-radius: 3px; color: #0a0a0a; font-family: 'Source Code Pro', monospace; }
      code { display: inline-block; padding: 4px 8px; }
      pre { margin: 20px auto; overflow-x: scroll; padding: 14px 16px; }

      ul { margin: 20px auto; padding: 0 0 0 30px; }
      ul ul { margin: 0 auto; }
      li { margin: 6px 0; }
      ul:first-child > li:first-child { margin-top: 0; }
      ul:first-child > li:last-child { margin-bottom: 0; }

      .monospace { font-family: 'Source Code Pro', monospace; }
      .wrapper { margin: 0 auto; overflow: auto; width: 97vw; }

      @media (prefers-color-scheme: dark) {
        html, body { background: #333; color: #fefefe; }
        code, pre { background: #555; border-color: #555; color: #fefefe; }
      }
    </style>
  </head>
  <body>
    <main class="wrapper">
      <ul>
        <li>
          <?php $gzip_status = (bool) ini_get('zlib.output_compression'); ?>
          <b>gzip status:</b> <?php var_export($gzip_status); ?>
        </li>
        <li>
          <b>HTTPS:</b> <?php var_export(isset($_SERVER['HTTPS'])); ?>
          <?php echo isset($_SERVER['HTTPS']) ? '<ul><li>value is <code>' . $_SERVER['HTTPS'] . '</code></li></ul>' : ''; ?>
        </li>
        <li>
          <b>HTTP_X_REAL_IP:</b> <?php var_export(isset($_SERVER['HTTP_X_REAL_IP'])); ?>
          <br><i>usually set if requests go through a proxy or firewall (e.g. Sucuri)</i>
          <?php echo isset($_SERVER['HTTP_X_REAL_IP']) ? '<ul><li>value is <code>' . $_SERVER['HTTP_X_REAL_IP'] . '</code></li></ul>' : ''; ?>
        </li>
        <li>
          <b>HTTP_X_FORWARDED_FOR:</b> <?php var_export(isset($_SERVER['HTTP_X_FORWARDED_FOR'])); ?>
          <br><i>usually set if requests go through a proxy or firewall (e.g. Sucuri)</i>
          <?php echo isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? '<ul><li>value is <code>' . $_SERVER['HTTP_X_FORWARDED_FOR'] . '</code></li></ul>' : ''; ?>
        </li>
        <li>
          <b>HTTP:X-Forwarded-Proto:</b> <?php var_export(isset($_SERVER['HTTP:X-Forwarded-Proto'])); ?>
          <br><i>usually set if requests go through a proxy or firewall (e.g. Sucuri)</i>
          <?php echo isset($_SERVER['HTTP:X-Forwarded-Proto']) ? '<ul><li>value is <code>' . $_SERVER['HTTP:X-Forwarded-Proto'] . '</code></li></ul>' : ''; ?>
        </li>
        <li>
          <b>HTTP_X_FORWARDED_PROTO:</b> <?php var_export(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])); ?>
          <br><i>usually set if requests go through a proxy or firewall (e.g. Sucuri)</i>
          <?php echo isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? '<ul><li>value is <code>' . $_SERVER['HTTP_X_FORWARDED_PROTO'] . '</code></li></ul>' : ''; ?>
        </li>
        <li>
          <b>HTTP_CF_VISITOR:</b> <?php var_export(isset($_SERVER['HTTP_CF_VISITOR'])); ?>
          <br><i>usually set if requests go through Cloudflare</i>
          <?php echo isset($_SERVER['HTTP_CF_VISITOR']) ? '<ul><li>value is <code>' . $_SERVER['HTTP_CF_VISITOR'] . '</code></li></ul>' : ''; ?>
        </li>
        <li>
          <b>REQUEST_SCHEME:</b> <?php var_export(isset($_SERVER['REQUEST_SCHEME'])); ?>
          <?php echo isset($_SERVER['REQUEST_SCHEME']) ? '<ul><li>value is <code>' . $_SERVER['REQUEST_SCHEME'] . '</code></li></ul>' : ''; ?>
        </li>
      </ul>

      <pre><?php /* print_r($_SERVER); */ ?></pre>
    </main>
  </body>
</html>
