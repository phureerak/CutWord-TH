<!DOCTYPE html>
<html>


<head>
	<title>455555</title>
</head>
<body>

</body>
</html>
<?php
$arr = array(
  array('id'=>100, 'parentid'=>0, 'name'=>'a'),
  array('id'=>101, 'parentid'=>100, 'name'=>'a'),
  array('id'=>102, 'parentid'=>101, 'name'=>'a'),
  array('id'=>103, 'parentid'=>101, 'name'=>'a'),
);

$new = array();
foreach ($arr as $a){
    $new[$a['parentid']][] = $a;
}
$tree = createTree($new, array($arr[0]));
print_r($tree);

function createTree(&$list, $parent){
    $tree = array();
    foreach ($parent as $k=>$l){
        if(isset($list[$l['id']])){
            $l['children'] = createTree($list, $list[$l['id']]);
        }
        $tree[] = $l;
    } 
    return $tree;
}
?>