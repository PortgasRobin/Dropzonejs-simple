<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if(isset($_GET["delete"]) && $_GET["delete"] == true)
	{
		$name = $_POST["filename"];
		if(file_exists('./uploads/'.$name))
		{
			unlink('./uploads/'.$name);
			$link = mysql_connect("104.238.97.76", "mvstelev_trivias", "@YXk9~nRma]=");
			mysql_select_db("mvstelev_trivias", $link);
			mysql_query("DELETE FROM uploads WHERE name = '$name'", $link);
			mysql_close($link);
			echo json_encode(array("res" => true));
		}
		else
		{
			echo json_encode(array("res" => false));
		}
	}
	else
	{
		$file = $_FILES["file"]["name"];
		$filetype = $_FILES["file"]["type"];
		$filesize = $_FILES["file"]["size"];

		if(!is_dir("uploads/"))
			mkdir("uploads/", 0777);

		if($file && move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/".$file))
		{
			$link = mysql_connect("104.238.97.76", "mvstelev_trivias", "@YXk9~nRma]=");
			mysql_select_db("mvstelev_trivias", $link);
			mysql_query("INSERT INTO uploads VALUES(null, '$file','$filetype','$filesize')", $link);
			mysql_close($link);
		}
	}
	
}