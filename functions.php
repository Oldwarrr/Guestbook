<?php

// Функция вывода данных
function postMessage($result){
	if($row = $result->num_rows > 0){
		while($row = $result->fetch_assoc()){	
		echo "
				<div class='note'>
					<p>
						<span class='date'>$row[date]</span>
						<span class='name'>$row[name]</span>
					</p>
					<p>
					$row[message]
					</p>
                    
				</div>	
			 ";
		}
	}
}