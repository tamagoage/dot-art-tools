<?php

declare(strict_types=1);

/**
 * 渡された画像の解像度を落とし、ドット絵の参考にする
 * dot-art-tools/src/getDotRef.php pixelate sample.jpg dir/samplesapmle.jpg
 */

const CMD_PIXELATE = '-resize 10% -sharpen 0x1 -scale 500%';
const CMD_ART = '-resize 10% -filter point -resize 800% -fx "(i%8!=0)*(j%8!=0)*u"';
const OUT_DIR = 'pixelated/';

$mode = $argv[1] ?? null;
$input = $argv[2] ?? null;

try {
    if ($mode === null || $input === null) {
        exit(1);
    }

    match ($mode) {
        'pixelate' => generatePixelatedImage($input),
        default => throw new Exception('存在しないオプション'),
    };
} catch (Exception $e) {
    echo $e->getMessage();
}

/**
 * @param non-empty-string $inputFile
 * @return non-empty-string
 */
function generatePixelatedImage(string|null $input): void
{
    $output = pathinfo($input, PATHINFO_FILENAME) . '_pixelated.png';
    runMagic($input, CMD_PIXELATE, $output);
}

/**
 * @param non-empty-string $inputFile
 * @param non-empty-string $outputFile
 */
function runMagic(string $input, string $params, string $output): void
{
    $cmd = sprintf(
        'magick %s %s %s',
        escapeshellarg($input),
        $params,
        escapeshellarg($output)
    );

    exec($cmd, $outputResult, $resultCode);

    if ($resultCode !== 0) {
        throw new Exception("変換失敗: コード $resultCode");
    }
}
