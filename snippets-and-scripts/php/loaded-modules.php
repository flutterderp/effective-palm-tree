<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
		<link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wgth@400;700&family=Source+Sans+Pro:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">

    <style>
			:root {
				--border__error: #9c0110;
				--border__primary: #902364;
				--border__secondary: #d3d3d3;
				--border__success: #0b6901;
				--border__warning: #e9d201;
				--callout__error: #cf0115;
				--callout__primary: #b92d80;
				--callout__secondary: #f0f0f0;
				--callout__success: #9bff91;
				--callout__warning: #fff48e;
				--color__black: #1f1f1f;
				--color__black__alt: #0a0a0a;
				--color__blue: #2974a7;
				--color__blue__focus: #215e87;
				--color__grey: #cacaca;
				--color__error: #cf0115;
				--color__error__focus: #fe051d;
				--color__primary: #b92d80;
				--color__primary__focus: #e50188;
				--color__secondary: #e6e6e6;
				--color__secondary__focus: #f0f0f0;
				--color__success: #9bff91;
				--color__success__focus: #1ffe08;
				--color__warning: #fff48e;
				--color__warning__focus: #fee605;
				--color__white: #fefefe;
			}
			* { box-sizing: border-box; margin: 0; min-height: 0; min-width: 0; padding: 0; }
			html { font-family: 'Source Serif Pro', Georgia, 'Times New Roman', Times, serif; font-size: 100%; line-height: normal; }
			html, body { background: #fefefe; color: #0a0a0a; }

			code, pre { background: #fafafa; border: 1px solid #aaa; border-radius: 3px; color: #0a0a0a; font-family: 'Source Code Pro', monospace; }
			code { display: inline-block; padding: 4px 8px; }
			pre { margin: 20px auto; overflow-x: scroll; padding: 14px 16px; }

			ol, ul { list-style: none; margin: 1rem 0; overflow: auto; padding: 0 0 0 1.875rem; width: auto; }
			ol { counter-reset: li; }
			li { padding-bottom: 0.1875rem; /* padding-left: 25px; */ position: relative; /* text-indent: -23px; */ }
			li { padding-left: 1.875rem; text-indent: 0; }
			li::before { color: var(--color__primary); content: '•'; direction: rtl; display: inline-block; font-weight: bold; left: 0; margin: 0;
				position: absolute; text-align: right; top: 0; width: 0.75rem; }
			ol > li { counter-increment: li; }
			ol > li::before { content: '.' counter(li); width: 1rem; }

			.monospace { font-family: 'Source Code Pro', monospace; }
			.wrapper { margin: 1.125rem auto; overflow: auto; width: 97vw; }

			@media (prefers-color-scheme: dark) {
				html, body { background: #333; color: #fefefe; }
				code, pre { background: #555; border-color: #555; color: #fefefe; }
			}
    </style>
	</head>
	<body>
		<main class="wrapper">
			<?php $exts = get_loaded_extensions(); ?>
			<h2>Loaded PHP modules</h2>
			<ol>
				<?php foreach($exts as $ext) : ?>
					<li><?php echo $ext; ?></li>
				<?php endforeach; ?>
			</ol>
		</main>
	</body>
</html>