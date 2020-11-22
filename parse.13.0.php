<?php
/**
 * Parses Version: 13.0
 * 
 * http://unicode.org/Public/emoji/13.0/emoji-test.txt
 */
 
if (!file_exists('emoji-test.txt')) {
    file_put_contents('emoji-test.txt', file_get_contents('http://unicode.org/Public/emoji/13.0/emoji-test.txt'));
}

// break into blocks
$blocks = explode(PHP_EOL.PHP_EOL, file_get_contents('emoji-test.txt'));

// unset header
unset($blocks[0]);

$emoji = [];

foreach ($blocks as $chunk) {
    $top = explode(PHP_EOL, $chunk)[0];

    if (substr($top, 0, strlen('# group:')) == '# group:') {
        $group = trim(str_replace('# group:', '', $top));
    } elseif (substr($top, 0, strlen('# subgroup:')) == '# subgroup:') {

        $lines = explode(PHP_EOL, $chunk);
        unset($lines[0]);

        foreach ($lines as $line) {

            $subgroup = trim(str_replace('# subgroup:', '', $top));

            $linegroup = explode(';', $line);

            $parts = explode('#', $linegroup[1]);

            $icon = explode(' ', trim($parts[1]), 2);

            $emoji[$group][$subgroup][] = [
                'group' => trim($group),
                'subgroup' => $subgroup,
                'name' => isset($linegroup[0]) ? trim($linegroup[0]) : '',
                'status' => isset($parts[0]) ? trim($parts[0]) : '',
                'emoji' => isset($icon[0]) ? trim($icon[0]) : '',
                'description' => isset($icon[1]) ? trim($icon[1]) : '',
            ];
        }
    }
}

header('Content-Type: text/plain;charset=UTF-8');
file_put_contents('parse.13.0.php.txt', print_r($emoji, true));
print_r($emoji);
