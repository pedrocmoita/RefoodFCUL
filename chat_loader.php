<?php
include "abreconexao.php";

$user_id = $_GET['de'];
$inst_id = $_GET['para'];
$chats = "SELECT * FROM Mensagens WHERE (de='$user_id' AND para='$inst_id') OR (de='$inst_id' AND para='$user_id')";
$chat_result = mysqli_query($conn, $chats);
while($chat = mysqli_fetch_assoc($chat_result)){
        if($chat['de'] == $user_id){
            	echo "<div style='text-align: right;'>
                	<p style='background-color: lightblue; word-wrap: break-word; display: inline-block; padding: .5rem; border-radius: .75rem; max-width: 70%;'>
                        ".$chat["message"]."
			</p>
              		</div>";
	}else{
            	echo "<div style='text-align:left;'>
                    	<p style='background-color: antiquewhite; word-wrap: break-word; display: inline-block; padding: .5rem; border-radius: .75rem; max-width: 70%;'>
                        ".$chat["message"]."
                   	</p>
                	</div>";
        	}
    	}
?>
