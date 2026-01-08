<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import(__DIR__ . '/vendor/tamagoage/devtools/ecs.php');

    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/ecs.php', // この設定ファイル自身もチェック
    ]);
};
