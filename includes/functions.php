<?php
// Вывод массивов
function pre($array){
    echo "<pre>";
    echo var_dump($array);
    echo "</pre>";
}


// Функция вывода данных
function postMessage($result){
	if($row = $result->num_rows > 0){
		while($row = $result->fetch_assoc()){	
		echo "
   
                <div class='comment'>
                        <div class='comment__info'>
                            <span class='comment__date'><b>$row[date]</b></span>
                            <span class='comment__name'>$row[name]</span>
                        </div>
                    <div class='comment__text'>
                        $row[message]
                    </div>
                </div>
                
			 ";
		}
	}
}
