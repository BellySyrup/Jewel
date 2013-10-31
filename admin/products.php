<?

//show php errors and warnings
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//include the jewel class
require_once("../inc/php/jewel.class.php");

//create jewel object
$oJewel=new Jewel();
//initialize response and image name to nothing
$response="";
$img_name="";
//initialize section to reduce php warnings
$section=0;
$selected=' selected="selected"';

//if section is passed
if(isset($_GET['section']))
{
	$section=$_GET['section'];
}

//grab an uploaded photo if there is one
if(isset($_FILES["photo"]))
{
	$photo=$_FILES["photo"];
}

//if there was an uploaded photo
if(isset($photo))
{	
	if(isset($_POST['manufacturerActionButton']))
	{
		$img_path = "../images/manufacturers/"; //set the path to where the photos will be saved
	}
	elseif(isset($_POST['productTypeActionButton']))
	{
		$img_path = "../images/product_types/"; //set the path to where the photos will be saved
	}
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
		
		if(isset($_POST['manufacturerActionButton']))
		{
			$max_height = 100;
		}
		elseif(isset($_POST['productTypeActionButton']))
		{
			$max_height = 200;
		}
		
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
		
		exec("convert ".$img_path.$img_name." -resize ".$new_width."x".$new_height." ".$img_path.$img_name);
		
		//exec("convert ".$img_path.$img_name." -resize 50x50^ -gravity center -extent 50x50 ".$img_path."thumbs/".$img_name);
        //exec("convert ".$img_path.$img_name." -resize 50x50 -gravity center -extent 50x50 ".$img_path."thumbs/".$img_name);
	}
	
	//$img_name="blahasdsafv.jpg";
}

//if image name is still nothing and a current filename has been passed
if($img_name=="" && isset($_POST['currentImageFileName']))
{
	$img_name=$_POST['currentImageFileName'];
}

//update home Manufacturer information
if(isset($_POST['manufacturerActionButton']))
{
	if($_POST['manufacturerActionButton']=="Delete Manufacturer")
	{
		$oJewel->manufacturerId=$_POST['manufacturerId'];
		$response=$oJewel->deleteManufacturerInfo();
	}
	else
	{
		$oJewel->manufacturerName=$_POST['manufacturerName'];
		$oJewel->manufacturerPhoneNum=$_POST['manufacturerPhoneNum'];
		$oJewel->manufacturerLink=$_POST['manufacturerLink'];
		$oJewel->manufacturerImage=$img_name;
		//insert code to make product type string
		$chosenProuctTypes=$_POST['productTypes'];
		$oJewel->manufacturerProductTypes=$chosenProuctTypes[0];
		foreach($chosenProuctTypes as $key=>$chosenProductType)
		{
			if($key>0)
			{
				$oJewel->manufacturerProductTypes.=','.$chosenProductType;
			}
		}
		
		if($_POST['manufacturerActionButton']=="Add Manufacturer")
		{
			$response=$oJewel->addManufacturerInfo();
		}
		elseif($_POST['manufacturerActionButton']=="Update Manufacturer")
		{
			$oJewel->manufacturerId=$_POST['manufacturerId'];
			$response=$oJewel->updateManufacturerInfo();
		}
	}
}


//update product type information
if(isset($_POST['productTypeActionButton']))
{
	if($_POST['productTypeActionButton']=="Delete Product Type")
	{
		$oJewel->productTypeId=$_POST['productTypeId'];
		$response=$oJewel->deleteProductType();
	}
	else
	{
		$oJewel->productTypeName=$_POST['productTypeName'];
		$oJewel->productTypeDescription=$_POST['productTypeDescrip'];
		$oJewel->productTypeImage=$img_name;
		
		if($_POST['productTypeActionButton']=="Add Product Type")
		{
			$response=$oJewel->addProductType();
		}
		elseif($_POST['productTypeActionButton']=="Update Product Type")
		{
			$oJewel->productTypeId=$_POST['productTypeId'];
			$response=$oJewel->updateProductType();
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
				<h2>Products Page Content Editing</h2>
				<select name="sectionDropdown" id="sectionDropdown">
					<option value="0">Choose a section to edit...</option>
					<option value="1" <? if($section==1){echo $selected;} ?>>Manufacturers</option>
					<option value="2" <? if($section==2){echo $selected;} ?>>Product Types</option>
				</select>
				<hr />
				<? 
				//output response if there is one
				if($response!="")
				{?>
					<div class="response">
						<? echo $response; ?>
					</div>
				<?}
				//if a section was chosen
				if(isset($_GET['section']))
				{
					//if it was the manufacturer section
					if($_GET['section']==1)
					{?>
						<div id="contentEditSection">
							<h2>Manufaturers <input type="button" id="addButton" class="theButtons" value="Add Manufacturer" /></h2>
							<div id="alphabet">
								<?
								for($i=65;$i<=90;$i++) 
								{?>
									<a href="./products.php?section=1&alpha=<? echo chr($i); ?>"><? echo chr($i); ?></a>
								<?}?>
							</div>
							<form id="addForm" class="updateForm" method="post" action="products.php?section=1" enctype="multipart/form-data">
								<label for="manufacturerName">Name: </label>
								<input type="text" name="manufacturerName" size="60" value="" /><br />
								<label for="manufacturerPhoneNum">Phone #: </label>
								<input type="text" name="manufacturerPhoneNum" size="60" value="" /><br />
								<label for="manufacturerLink">Support Link: </label>
								<input type="text" name="manufacturerLink" size="60" value="" /><br />
								<label for="manufacturerProductTypes">Product Types: </label>	
								<? 
								//grab the list of product types and output them as checkboxes
								$productTypes=$oJewel->grabProductTypeList(); 
								
								foreach($productTypes as $productType)
								{?>
									<label class="checkBoxes"><input type="checkbox" name="productTypes[]" value="<? echo $productType['id']; ?>" /> &nbsp;<? echo $productType['name']; ?></label>
								<?}?>

								<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
								<label for="photo">Choose an image: </label><br />
								<input class="photoSelect" type="file" name="photo"/><br />
								<input type="submit" class="theButtons" name="manufacturerActionButton" value="Add Manufacturer" />
							</form>
							<?	
							//if a letter has been chosen							
							if(isset($_GET['alpha']))
							{
								$alpha=$_GET['alpha'];
								$manufacturers=$oJewel->grabAlphaManufacturerInfo($alpha);
								
								if(empty($manufacturers))
								{?>
									<p class="emptyNotice" >There are currently no manucaturers that start with <? echo $alpha; ?>.</p> 
								<?}
								else
								{
									//output the manufacturers
									foreach($manufacturers as $manufacturer)
									{?>
										<form style="min-height:870px;" class="updateForm" method="post" action="products.php?section=1" enctype="multipart/form-data">
											<label for="manufacturerName">Name: </label>
											<input type="text" name="manufacturerName" size="60" value="<? echo $manufacturer['name']; ?>" /><br />
											<label for="manufacturerPhoneNum">Phone #: </label>
											<input type="text" name="manufacturerPhoneNum" size="60" value="<? echo $manufacturer['phone_num']; ?>" /><br />
											<label for="manufacturerLink">Support Link: </label>
											<input type="text" name="manufacturerLink" size="60" value="<? echo $manufacturer['link']; ?>" /><br />
											<label for="manufacturerProductTypes">Product Types: </label>
											<? 
											//grab the list of product types and output them as checkboxes
											$productTypes=$oJewel->grabProductTypeList(); 
											
											foreach($productTypes as $productType)
											{
												$checked='';
												foreach($manufacturer['productType'] as $id)
												{
													if($id==$productType['id'])
													{
														$checked=' checked="checked"';
													}
												}?>
												<label class="checkBoxes"><input type="checkbox" name="productTypes[]" value="<? echo $productType['id']; ?>" <? echo $checked; ?> /> &nbsp;<? echo $productType['name']; ?></label>
											<?}?>
					
											<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
											<label>Current Image: </label>
											<input type="hidden" name="currentImageFileName" value="<? echo $manufacturer['image']; ?>" />
											<img src="../images/manufacturers/<? echo $manufacturer['image']; ?>" title="Current Image for <? echo $manufacturer['name']; ?>" alt="You do not have a current image set" /><br />
											<label for="photo">Choose another image:</label><br />
											<input class="photoSelect" type="file" name="photo"/><br />
											<input type="hidden" name="manufacturerId" value="<? echo $manufacturer['id']; ?>" />
											<input type="submit" class="theButtons" name="manufacturerActionButton" value="Update Manufacturer" />
											<input type="submit" class="theButtons" name="manufacturerActionButton" value="Delete Manufacturer" />
										</form>
									<?}
								}
							}?>
						</div>
					<?}
					//if it was the product type section
					elseif($_GET['section']==2)
					{?>
						<div id="contentEditSection">
							<h2>Product Types <input type="button" class="theButtons" id="addButton" value="Add Product Type" /></h2>
							<form id="addForm" class="updateForm" method="post" action="products.php?section=2" enctype="multipart/form-data">
								<label for="productTypeName">Name: </label>
								<input type="text" name="productTypeName" size="50" value="" /><br />
								<label for="productTypeDescrip">Description: </label>
								<textarea name="productTypeDescrip"></textarea><br /> 
								<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
								<label>Choose an image:</label><br />
								<input class="photoSelect" type="file" name="photo"/><br />								
								<input type="submit" class="theButtons" name="productTypeActionButton" value="Add Product Type" />
							</form>
							<?
							//grab and output the product types
							$productTypes=$oJewel->grabProductTypeInfo();
							foreach($productTypes as $productType)
							{?>
								<form style="min-height:700px;" class="updateForm" method="post" action="products.php?section=2" enctype="multipart/form-data">
									<label for="productTypeName">Name: </label>
									<input type="text" name="productTypeName" size="50" value="<? echo $productType['name']; ?>" /><br />
									<label for="productTypeDescrip">Description: </label>
									<textarea name="productTypeDescrip"><? echo $productType['description']; ?></textarea><br />
									<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
									<label>Current Image: </label>
									<input type="hidden" name="currentImageFileName" value="<? echo $productType['image']; ?>" />
									<img src="../images/product_types/<? echo $productType['image']; ?>" title="Current Image for <? echo $productType['name']; ?>" /><br />
									<label for="photo">Choose another image:</label><br />
									<input class="photoSelect" type="file" name="photo"/><br />
									<input type="hidden" name="productTypeId" value="<? echo $productType['id']; ?>" />
									<input type="submit" class="theButtons" name="productTypeActionButton" value="Update Product Type" />
									<input type="submit" class="theButtons" name="productTypeActionButton" value="Delete Product Type" />
								</form>
							<?}?>
						</div>
					<?} 
				}?>
			</div>
		</div>
	</body>
</html>