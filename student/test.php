<?php
    $self_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
    $the_parse = parse_url($self_url);
    print_r($the_parse);
    echo "<br>";
    parse_str($the_parse["query"], $query_arr);
    print_r($query_arr);
?>