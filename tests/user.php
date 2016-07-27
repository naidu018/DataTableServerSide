<?php
$data = array();
$con = mysqli_connect("localhost",'root','root','show_emails');
//echo "<pre>\n{$_REQUEST["search"]["value"]}\n</pre> ";
$sql = "SELECT * FROM emails";

$query = mysqli_query($con,$sql) or die(mysqli_error($con));

$searchvalue = isset($_REQUEST["search"]["value"])? $_REQUEST["search"]["value"] : '';
$ordervalue=$_REQUEST["order"]["0"]["column"];

// Logic is the user tries to set one at each time. If he sets the ordervalue, then the following logic is accompanied. 
//New idea is to elimintate the second condition
if($searchvalue) 
{
    $sql= "select * from emails where _messageId like '%$searchvalue%' or _from like '%$searchvalue%' or _pSetup like '%$searchvalue%' or _Deadline like '%$searchvalue%' or _Subject like '%$searchvalue%' or _AssignedPerson like '%$searchvalue%'";
   
    $query = mysqli_query($con,$sql) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $data_row = array();
    foreach($row as $key=>$value){
        array_push($data_row, $value);
    }
    array_push($data,$data_row);
}
$reverse=array_reverse($data);
//echo '<code><pre>';
$json_to_return = array();
$json_to_return["draw"] = $_REQUEST["draw"];
$json_to_return["recordsTotal"] = sizeof($data);
$json_to_return["recordsFiltered"] = sizeof($data);
$json_to_return["data"] = $reverse;

}

else if($ordervalue>0|| ($ordervalue==0&&$_REQUEST["order"]["0"]["dir"]=="desc"))
{
	switch($ordervalue)
	{
		case 0:
			$sql = "SELECT * FROM emails order by _messageId asc";
				$query = mysqli_query($con,$sql) or die(mysqli_error($con));
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
				$data_row = array();
				foreach($row as $key=>$value)
				{
					array_push($data_row, $value);
				}
				array_push($data,$data_row);
				}
				break;
		case 1:
			if($_REQUEST["order"]["0"]["dir"]=="asc")
			{
				$sql = "SELECT * FROM emails order by _from";
				$query = mysqli_query($con,$sql) or die(mysqli_error($con));
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
				$data_row = array();
				foreach($row as $key=>$value)
				{
					array_push($data_row, $value);
				}
				array_push($data,$data_row);
			}
			}
			else
			{
				$sql = "SELECT * FROM emails order by _from desc";
				$query = mysqli_query($con,$sql) or die(mysqli_error($con));
				while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
				{
				$data_row = array();
				foreach($row as $key=>$value)
				{
					array_push($data_row, $value);
				}
				array_push($data,$data_row);
			}
			}
			break;
		case 5: 
				if($_REQUEST["order"]["0"]["dir"]=="asc")
				{
					$sql = "SELECT * FROM emails order by _Subject";
					$query = mysqli_query($con,$sql) or die(mysqli_error($con));
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
					$data_row = array();
					foreach($row as $key=>$value)
					{
						array_push($data_row, $value);
					}
					array_push($data,$data_row);
					}
				}
				else
				{
					$sql = "SELECT * FROM emails order by _Subject desc";
					$query = mysqli_query($con,$sql) or die(mysqli_error($con));
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
					$data_row = array();
					foreach($row as $key=>$value)
					{
						array_push($data_row, $value);
					}
					array_push($data,$data_row);
					}
				}
	}
//echo '<code><pre>';
	$json_to_return = array();
	$json_to_return["draw"] = $_REQUEST["draw"];
	$json_to_return["recordsTotal"] = sizeof($data);
	$json_to_return["recordsFiltered"] = sizeof($data);
	$json_to_return["data"] = $data;
	
//echo '</pre></code>';s
}

// If the user tries to search for something, then the searchvalue is not set to anything and the following is accompanied.
else if(!$searchvalue)
{
		while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
		{
			$data_row = array();
			foreach($row as $key=>$value)
			{
			array_push($data_row, $value);
			}
		array_push($data,$data_row);
		}	
	$reverse=array_reverse($data);
	//echo '<code><pre>';
	$json_to_return = array();
	$json_to_return["draw"] = $_REQUEST["draw"];
	$json_to_return["recordsTotal"] = sizeof($data);
	$json_to_return["recordsFiltered"] = sizeof($data);
	$json_to_return["data"] = $reverse;
	
//echo '</pre></code>';
}
// If nothing is set then the following logic is accompanied to display the records according to the search keyword
else 
{
    $sql= "select * from emails where _messageId like '%$searchvalue%' or _from like '%$searchvalue%' or _pSetup like '%$searchvalue%' or _Deadline like '%$searchvalue%' or _Subject like '%$searchvalue%' or _AssignedPerson like '%$searchvalue%'";
   
    $query = mysqli_query($con,$sql) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
    $data_row = array();
    foreach($row as $key=>$value){
        array_push($data_row, $value);
    }
    array_push($data,$data_row);
}
$reverse=array_reverse($data);
//echo '<code><pre>';
$json_to_return = array();
$json_to_return["draw"] = $_REQUEST["draw"];
$json_to_return["recordsTotal"] = sizeof($data);
$json_to_return["recordsFiltered"] = sizeof($data);
$json_to_return["data"] = $reverse;

}

$data=array_slice($json_to_return["data"], $_REQUEST["start"],$_REQUEST["length"]);
$json_to_return["data"]=$data;
echo json_encode($json_to_return);
?>
