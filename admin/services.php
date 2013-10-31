<?
error_reporting(E_ALL);

ini_set('display_errors', 'On');

require_once("../inc/php/jewel.class.php");

//create jewel object
$oJewel=new Jewel();
//initialize response to nothing
$response="";
$img_name="";
$selected=' selected="selected"';

//grab an uploaded photo if there is one
if(isset($_FILES["photo"]))
{
	$photo=$_FILES["photo"];
}

//if there was an uploaded photo
if(isset($photo))
{
	$img_path = "../images/services/"; //set the path to where the photos will be saved
	$img_tmp_name = $photo["tmp_name"]; //gives photo string temp name
	$img_name = $photo["name"]; //make mage name unique
	
	//make file name web freindly
	$replace = "_";
	$pattern = "/([[:alnum:]_\.-]*)/";
	$img_name = str_replace(str_split(preg_replace($pattern, $replace, $img_name)), $replace, $img_name);
	
	//check to see if file was moved from the temp folder to th stoage directory successfully
	if(move_uploaded_file($img_tmp_name, $img_path.$img_name))
	{
		//get width and height of the image
		$size = getimagesize($img_path.$img_name);
		$ratio = $size[0] / $size[1];
		
		//set the maximum dimensions
		$max_width  = 200; 
		$max_height = 200;
		
		//based on if the image is portrait or landscape, set the dimensions while maintaining the ratio
		if ($ratio < 1)
		{
			$new_height = $max_height;
			$new_width = floor($new_height * $ratio);
		} 
		else
		{
			$new_width = $max_width;
			$new_height = floor($new_width / $ratio);
		}
		
		//perform the image magic conversion
		//exec("convert ".$img_path.$img_name." -resize ".$new_width."x".$new_height." ".$img_path.$img_name);
		
		//exec("convert ".$img_path.$img_name." -resize 50x50^ -gravity center -extent 50x50 ".$img_path."thumbs/".$img_name);
        exec("convert ".$img_path.$img_name." -resize 200x200 -gravity center -extent 200x200 ".$img_path.$img_name);
	}
}

if($img_name=="" && isset($_POST['currentImageFileName']))
{
	$img_name=$_POST['currentImageFileName'];
}

//update service information
if(isset($_POST['serviceActionButton']))
{
	if($_POST['serviceActionButton']=="Delete Service")
	{
		$oJewel->serviceId=$_POST['serviceId'];
		$response=$oJewel->deleteService();
	}
	else
	{
		$oJewel->serviceName=$_POST['serviceName'];
		$oJewel->serviceDescription=$_POST['serviceDescription'];
		$oJewel->serviceImage=$img_name;
		
		if($_POST['serviceActionButton']=="Add Service")
		{
			$response=$oJewel->addService();
		}
		elseif($_POST['serviceActionButton']=="Update Service")
		{
			$oJewel->serviceId=$_POST['serviceId'];
			$response=$oJewel->updateService();
		}
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Jewel Admin</title>
		<link rel="icon" type="image/png" href="../images/tab_logo.png" />
		<link rel="stylesheet" type="text/css" href="./css/awesomeness.css" />
		
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="./js/admin_awesomeness.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1>Jewel Administration</h1>
				<div id="nav">
					<a href="./index.php" title="Change Home Content">Home</a>
					<a href="./products.php" title="Change Product Content">Products</a>
					<a href="./services.php" title="Change Services Content">Services</a>
				</div>
			</div>
			<div id="content">
				<div id="contentEditSection">
					<h2>Service Page Content Editing</h2>
					<? 
					if($response!="")
					{?>
						<div class="response">
							<? echo $response; ?>
						</div>
					<?}?>
					<div id="homeBlurbs">
						<h2>Services Information <input type="button" id="addButton" class="theButtons" value="Add Service" /></h2>
						<form id="addForm" class="updateForm" method="post" action="services.php" enctype="multipart/form-data">
							<label for="serviceName">Name: </label>
							<input type="text" name="serviceName" size="50" value="" /><br />
							<label for="serviceDescription">Description: </label>
							<textarea name="serviceDescription"></textarea><br />
							<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
							<label for="photo">Choose an image: </label><br />
							<input class="photoSelect" type="file" name="photo"/><br />				
							<input type="submit" class="theButtons" name="serviceActionButton" value="Add Service" />
						</form>
						<?
							$services=$oJewel->grabServiceInfo();
							
							if($services!=null)
							{
								foreach($services as $service)
								{?>
									<form class="updateForm" method="post" action="services.php" enctype="multipart/form-data">
										<label for="serviceName">Name: </label>
										<input type="text" name="serviceName" size="50" value="<? echo $service['name']; ?>" /><br />
										<label for="serviceDescription">Description: </label>
										<textarea name="serviceDescription"><? echo $service['description']; ?></textarea><br />
										<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
										<label>Current Image: </label>
										<input type="hidden" name="currentImageFileName" value="<? echo $service['image']; ?>" />
										<img src="../images/services/<? echo $service['image']; ?>" title="Current Image for <? echo $service['name']; ?>" /><br />
										<label for="photo">Choose another image: </label><br />
										<input class="photoSelect" type="file" name="photo"/><br />
										<input type="hidden" name="serviceId" value="<? echo $service['id']; ?>" />
										<input type="submit" class="theButtons" name="serviceActionButton" value="Update Service" />
										<input type="submit" class="theButtons" name="serviceActionButton" value="Delete Service" />
									</form>
								<?}
							}
							else
							{?>
								<div id="emptyResponse">
									<p>There are no services. Please add one.</p>
								</div>
							<?}?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>