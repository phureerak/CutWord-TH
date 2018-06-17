<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Hello AI</title>
</head>
<body>
	<form action="#" method="POST">
		คำที่ต้องการตัด: <input type="text" name="word"><br>
		<input type="submit" name="submit" value="กดยืนยัน">
	</form>
</body>
</html>
<?php 
	if(isset($_POST['submit'])) {
		//base_convert('10000', 2, 10);สองไป10
		$strWord = $_POST['word'];
		$strWord = ereg_replace('[[:space:]]+', '', trim($strWord));
		$longWord=0;
		$word=[];
		while(true){
			array_push($word,iconv_substr($strWord,$longWord,1, "UTF-8"));
			if($word[$longWord]!=NULL){
				//echo $word[$longWord]." // ".mb_ord($word[$longWord])." // ".$longWord."<br> ";
				$longWord++;
			}else break;		
		}
		//print_r($word);
		//echo $longWord;
		$wordcheck=[];
		$numWord=[];
		$n=0;
		$chspace=0;
		for($i=0;$i<$longWord;$i++){
			
			if((mb_ord($word[$i])>=3648&&mb_ord($word[$i])<=3652)){
				array_push($wordcheck,$word[$i].$word[$i+1]);
				array_push($numWord,2);
				$i++;
				$n++;
			}
			else if((mb_ord($word[$i])>=3585&&mb_ord($word[$i])<=3630)){
					array_push($wordcheck,$word[$i]);
					array_push($numWord,1);	
					$n++;
			}
			else if((mb_ord($word[$i])>=3632&&mb_ord($word[$i])<=3642)||(mb_ord($word[$i])>=3655&&mb_ord($word[$i])<=3661)){
				if(isset($numWord[$n-1])){
					$wordcheck[$n-1]=$wordcheck[$n-1].$word[$i];
					$numWord[$n-1]=$numWord[$n-1]+1;
				}
			}
		}
		
		//print_r($wordcheck);
		echo "<BR>";
		//print_r($numWord);
		echo "<BR>";
		$active=[];
		$acXED=[];
		$firstPosi=[];
		$lastPosi=[];
		$last=0;
		$BN=0;
		$dic = ["หลวง","ตา","ตาม","วง","ลวง","มหา","หา","บัว","กิน","ขน","นม","ขนม","มอ","มอบ","อบ","บก","กร","กรอ","กรอบ","อก","รอบ","รอ","แมว","บัญ","บัญชี","ชี","กล","กลาง","ลาง","กรอก"];
		for ($a=0; $a < $n ; $a++) { 
			array_push($active,$wordcheck[$a]);
			$BN+=$numWord[$a];
			//echo count($active);
		//	echo $active[$a]."//<BR>";
			
			for ($first=0; $first < $last ; $first++) { 
				$active[$first]=$active[$first].$wordcheck[$a];
				//echo $active[$first]."/<BR>";
			}

			for ($b=0; $b < count($active) ; $b++) { 
				for ($chdic=0; $chdic < count($dic); $chdic++) {
						if(strcmp($dic[$chdic],$active[$b])==0){

							array_push($acXED,$active[$b]);
							//echo "\?".$active[$b]."?/";
							array_push($lastPosi,$BN);
							//echo ($BN)."//";
							array_push($firstPosi,($BN)-(strlen($active[$b]))/3);
							break;
						} 
					}		
			}
			$last++;
		}
		echo "<BR>";
		print_r($acXED);
		echo "<BR>First";
		print_r($firstPosi);
		echo "<BR>Last";
		print_r($lastPosi);
		echo "<BR>";
		echo "<BR>";
		for ($y=0; $y < count($acXED); $y++) { 
			$mh=0;
			for ($g=$y+1; $g < count($acXED); $g++) { 

				if ($lastPosi[$y]==$firstPosi[$g]) {
					$child[$y][$mh]=$g;
					$mh++;
				}
			}
		}
		

		$graph=[];
		$visited=[];
		$np=0;
		foreach ($child as $value) {
			array_push($graph,$value);	
			array_push($visited,$value);	
			$np++;	 
		}
		for (; $np < count($acXED); $np++) { 
			array_push($graph,NULL);	
			array_push($visited,NULL);	
		}
		
		$firr=[];
		$lass=[];
		for ($btt=0; $btt < count($acXED); $btt++) { 
			if ($firstPosi[$btt]==0) {
				array_push($firr,$btt);	
			}
			else break;
		}
		echo (count($acXED)-1);
		for ($btr=count($acXED)-1; $btr > 0; $btr--) { 
			if ($lastPosi[$btr]==(count($word)-1)) {
				array_push($lass,$btr);	
			}
		}
		echo "<BR>firr";
		print_r($firr);
		echo "<BR>lass";
		print_r($lass);
		echo "<BR>";

		$wordA=[];
		$gra = new Graph($graph);
		for ($ewq=0; $ewq < count($firr); $ewq++) { 
			array_push($wordA,$gra->breadthFirstSearch($ewq));
		}

	$wordLA=[];
	foreach ($wordA as $key => $value ) {
		foreach ($value as $name => $val) {
			$wordsuB=[];
			foreach ($val as $va ) {
				//array_push($wordsuB,$va);
				array_push($wordsuB,$acXED[$va]);	
			}
			print_r($wordsuB);
			for ($tre=0; $tre < count($lass); $tre++) { 
				if ($va==$lass[$tre]) {
					array_push($wordLA,$wordsuB);
				}
			}
			echo "<BR>";	
		}
	}
	echo "<BR>";
	print_r($wordLA);
	echo "<BR>";

	for ($mr=0; $mr <count($wordLA) ; $mr++) { 
		/*
		if (strcasecmp(str1, str2)) {
			# code...
		}
		*/
	}
	for ($mr=0; $mr <count($wordLA) ; $mr++) { 
		$ph='';
		for ($mc=0; ($mc < count($wordLA[$mr])); $mc++) { 
			
			echo $ph.$wordLA[$mr][$mc];
			$ph=' | ';
		}
		echo "<BR>";
	}


	} 
	else {
	echo "ERROR";
	}
?>

<?php

	function mb_ord($string)
	{
	    if (extension_loaded('mbstring') === true)
	    {
	        mb_language('Neutral');
	        mb_internal_encoding('UTF-8');
	        mb_detect_order(array('UTF-8', 'ISO-8859-15', 'ISO-8859-1', 'ASCII'));
	        $result = unpack('N', mb_convert_encoding($string, 'UCS-4BE', 'UTF-8'));
	        if (is_array($result) === true)
	        {
	            return $result[1];
	        }
	    }
	    return ord($string);
	}

	class Graph
		{
		  protected $graph;
		  //protected $visited;

		  public function __construct($graph) {
		    $this->graph = $graph;
		  }

		  public function breadthFirstSearch($origin) {

		    $q = new SplQueue();

		    // enqueue the origin vertex and mark as visited
		    $q->enqueue($origin);

		    $path = array();
		    $path[$origin] = new SplDoublyLinkedList();
		    $path[$origin]->setIteratorMode(
		      SplDoublyLinkedList::IT_MODE_FIFO|SplDoublyLinkedList::IT_MODE_KEEP
		    );

		    $path[$origin]->push($origin);
		    $wordB=[];
		    // while queue is not empty and destination not found
		    while (!$q->isEmpty() ) {
		      $t = $q->dequeue();

		      if (!empty($this->graph[$t])){
		        // for each adjacent neighbor
		        foreach ($this->graph[$t] as $vertex) {
		            $q->enqueue($vertex);
		            $path[$vertex] = clone $path[$t];
		            $path[$vertex]->push($vertex);

		           	array_push($wordB,$path[$vertex]);
		        }
		      }
		    }
		    return $wordB;
		  }
		}
?>


