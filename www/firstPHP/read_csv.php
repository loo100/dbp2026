<?php
	$data = nl2br(file_get_contents("data.csv"));
	echo $data;
	$lines = explode('<br />', $data);  // 分隔
	$i = 0;
	echo '<table>';
	foreach($lines as $v){
	    echo '<tr>';
	    $d = explode(',', $v);
	    foreach($d as $item)
		    echo '<td>'.$item.'</td>';
	    echo '</tr>';
	}
     echo '</table>';
    ?>
