<?php
if(function_exists('opcache_reset'))
{
  opcache_reset();
}

$utc_tz    = new DateTimeZone('UTC');
$today     = new DateTime(null, $utc_tz);
$client_ip = '';

header('Cache-Control: no-store, max-age=0');
header('Last-Modified: ' . $today->format('r'));

switch(true)
{
	case isset($_SERVER['HTTP_X_REAL_IP']) :
		$client_ip = $_SERVER['HTTP_X_REAL_IP'];
		break;
	case isset($_SERVER['CLIENT_IP']) :
		$client_ip = $_SERVER['CLIENT_IP'];
		break;
	default :
		$client_ip = $_SERVER['REMOTE_ADDR'];
		break;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What's My IP Address?</title>
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wgth@400;700&family=Source+Sans+Pro:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">

    <style>
      * { margin: 0; padding: 0; }
      html { font-family: 'Source Serif Pro', Georgia, 'Times New Roman', Times, serif; font-size: 100%; line-height: normal; }
      html, body { background: #fefefe; color: #0a0a0a; }

      code, pre { background: #fafafa; border: 1px solid #aaa; border-radius: 3px; color: #0a0a0a; font-family: 'Source Code Pro', monospace; }
      code { display: inline-block; padding: 4px 8px; }
			p { margin: 20px auto; }
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
			<p>As best as we could tell:</p>
			<ul>
				<li>Your IP address is: <code><?php echo $client_ip; ?></code></li>
				<!-- <li>Your user agent is: <code><?php echo $_SERVER['HTTP_USER_AGENT']; ?></code></li> -->
			</ul>

			<!-- <pre><?php /* print_r($_SERVER); */ ?></pre> -->
    </main>
  </body>
</html>
