<?php
/**
 * Parses Version: 5.0
 * 
 * http://unicode.org/Public/emoji/5.0/emoji-test.txt
 */
 
if (!file_exists('emoji-test.txt')) {
    file_put_contents('emoji-test.txt', file_get_contents('http://unicode.org/Public/emoji/5.0/emoji-test.txt'));
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
                'name' => trim($linegroup[0]),
                'status' => trim($parts[0]),
                'emoji' => trim($icon[0]),
                'description' => trim($icon[1]),
            ];
        }
    }
}

header('Content-Type: text/plain;charset=UTF-8');
print_r($emoji);