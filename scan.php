<!DOCTYPE html>
<html>
<head>
    <title>Dymles GANZ PHP Scanner</title>
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: monospace;
            text-align: center;
            padding: 50px;
        }
        button {
            background-color: #444;
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .result {
            margin-top: 30px;
            text-align: left;
            display: inline-block;
            background: #222;
            padding: 20px;
            border-radius: 10px;
            max-height: 500px;
            overflow-y: auto;
            position: relative;
        }
        .result p {
            color: #0f0;
            margin: 5px 0;
        }
        #copyButton {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 14px;
            padding: 8px 15px;
            background-color: #08f;
        }
    </style>
</head>
<body>
    <h1>Dymles GANZ PHP File Scanner</h1>
    <form method="post">
        <button type="submit" name="scan">Scan Now</button>
    </form>

    <?php
    if (isset($_POST['scan'])) {
        echo "<div class='result'><button id='copyButton'>Copy</button><h2>Scan Result:</h2>";
        $currentDir = __DIR__;
        $modifiedFiles = [];
        $timeThreshold = time() - (3 * 24 * 60 * 60);
        $minSize = 1536;

        function scanDirectory($dir, $timeThreshold, $minSize, &$modifiedFiles) {
            $items = scandir($dir);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') continue;
                $path = $dir . DIRECTORY_SEPARATOR . $item;
                if (is_dir($path)) {
                    scanDirectory($path, $timeThreshold, $minSize, $modifiedFiles);
                } elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                    if (filemtime($path) >= $timeThreshold && filesize($path) > $minSize) {
                        $modifiedFiles[] = $path;
                    }
                }
            }
        }

        scanDirectory($currentDir, $timeThreshold, $minSize, $modifiedFiles);

        if (count($modifiedFiles) > 0) {
            usort($modifiedFiles, function($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            echo "<div id='copyText' style='display:none;'>";
            foreach ($modifiedFiles as $file) {
                echo htmlspecialchars($file) . "\n";
            }
            echo "</div>";

            foreach ($modifiedFiles as $file) {
                $modifiedTime = date("Y-m-d H:i:s", filemtime($file));
                $fileSizeKB = round(filesize($file) / 1024, 2);
                echo "<p>" . htmlspecialchars($file) . " <span style='color:#888'>($modifiedTime, {$fileSizeKB} KB)</span></p>";
            }
        } else {
            echo "<p style='color: red;'>No recently modified PHP files found over 1.5KB.</p>";
        }

        echo "</div>";
    }
    ?>

    <script>
        const copyBtn = document.getElementById('copyButton');
        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                const copyText = document.getElementById('copyText').innerText;
                navigator.clipboard.writeText(copyText).then(() => {
                    copyBtn.innerText = 'Copied!';
                    setTimeout(() => {
                        copyBtn.innerText = 'Copy';
                    }, 2000);
                });
            });
        }
    </script>
</body>
</html>
