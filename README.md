# emoji-parse

Little bit of PHP code to parse `http://unicode.org/Public/emoji/5.0/emoji-test.txt` into a working PHP array. 

Resulting array will look like (see: parse.5.0.php.txt for complete output):

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
