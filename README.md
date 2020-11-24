# emoji-parse

Little bit of PHP code to parse `http://unicode.org/Public/emoji/13.0/emoji-test.txt` into a workable PHP array. 

Resulting array will look like (see: ./output/print_r.13.0.txt for complete output, or ./output/13.0.sql for mysql dump file):

    Array
    (
        [Smileys & People] => Array
            (
                [face-positive] => Array
                    (
                        [0] => Array
                            (
                                [group] => Smileys & People
                                [subgroup] => face-positive
                                [name] => 1F600
                                [status] => fully-qualified
                                [emoji] => 😀
                                [description] => grinning face
                            )
    
                        [1] => Array
                            (
                                [group] => Smileys & People
                                [subgroup] => face-positive
                                [name] => 1F601
                                [status] => fully-qualified
                                [emoji] => 😁
                                [description] => beaming face with smiling eyes
                            )
    
                        [2] => Array
                            (
                                [group] => Smileys & People
                                [subgroup] => face-positive
                                [name] => 1F602
                                [status] => fully-qualified
                                [emoji] => 😂
                                [description] => face with tears of joy
                            )
    
                        [3] => Array
                            (
                                [group] => Smileys & People
                                [subgroup] => face-positive
                                [name] => 1F923
                                [status] => fully-qualified
                                [emoji] => 🤣
                                [description] => rolling on the floor laughing
                            )
        // snip ..
