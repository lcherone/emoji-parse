<?php
/**
 * Parses Version: 13.0
 * 
 * http://unicode.org/Public/emoji/13.0/emoji-test.txt
 */
$version = '13.0';
 
if (!file_exists('./emoji-test/'.$version.'.txt')) {
    file_put_contents(
        './emoji-test/'.$version.'.txt', 
        file_get_contents('http://unicode.org/Public/emoji/'.$version.'/emoji-test.txt')
    );
}

// break into blocks
$blocks = explode(PHP_EOL.PHP_EOL, file_get_contents('./emoji-test/'.$version.'.txt'));

// unset header
unset($blocks[0]);

$emoji = [];

foreach ($blocks as $index => $chunk) {
    $top = explode(PHP_EOL, trim($chunk))[0];

    if (substr($top, 0, strlen('# group:')) == '# group:') {
        $group = trim(str_replace('# group:', '', $top));
    } elseif (substr($top, 0, strlen('# subgroup:')) == '# subgroup:') {

        $lines = explode(PHP_EOL, $chunk);
        unset($lines[0]);

        foreach ($lines as $line) {

            if (!isset($group)) continue;

            $subgroup = trim(str_replace('# subgroup:', '', $top));

            $linegroup = explode(';', $line);

            $parts = explode('#', $linegroup[1]);

            $icon = explode(' ', trim($parts[1]), 3);

            $emoji[$group][$subgroup][] = [
                'group' => trim($group),
                'subgroup' => $subgroup,
                'name' => isset($linegroup[0]) ? trim($linegroup[0]) : '',
                'status' => isset($parts[0]) ? trim($parts[0]) : '',
                'emoji' => isset($icon[0]) ? trim($icon[0]) : '',
                'version' => isset($icon[1]) ? trim($icon[1]) : '',
                'description' => isset($icon[2]) ? trim($icon[2]) : ''
            ];
        }
    }
}

// out
// - print_r
file_put_contents('./output/print_r.'.$version.'.txt', print_r($emoji, true));
