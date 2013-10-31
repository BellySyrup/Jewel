<?
error_reporting(E_ALL);

ini_set('display_errors', 'On');

require_once("../inc/php/jewel.class.php");

//create jewel object
$oJewel=new Jewel();
//initialize response to nothing
$response="";
$img_name="";
$section=0;
$selected=' selected="selected"';

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
	$img_path = "../images/home_info/"; //set the path to where the photos will be saved
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
		$max_width  = 100; 
		$max_height = 100;
		
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
        exec("convert ".$img_path.$img_name." -resize 100x100 -gravity center -extent 100x100 ".$img_path.$img_name);
	}
}

if($img_name=="" && isset($_POST['currentImageFileName']))
{
	$img_name=$_POST['currentImageFileName'];
}

//update home blurb information
if(isset($_POST['blurbActionButton']))
{
	if($_POST['blurbActionButton']=="Delete Blurb")
	{
		$oJewel->homeInfoId=$_POST['blurbId'];
		$response=$oJewel->deleteHomeInfo();
	}
	else
	{
		$oJewel->homeInfoTitle=$_POST['homeBlurbTitle'];
		$oJewel->homeInfoText=$_POST['homeBlurbText'];
		$oJewel->homeInfoImage=$img_name;
		$oJewel->homeInfoActive=$_POST['homeBlurbActive'];
		
		if($_POST['blurbActionButton']=="Add Blurb")
		{
			$response=$oJewel->addHomeInfo();
		}
		elseif($_POST['blurbActionButton']=="Update Blurb")
		{
			$oJewel->homeInfoId=$_POST['blurbId'];
			$response=$oJewel->updateHomeInfo();
		}
	}
}


//update testimonial information
if(isset($_POST['testimonialActionButton']))
{
	
	if($_POST['testimonialActionButton']=="Delete Testimonial")
	{
		$oJewel->testimonialId=$_POST['testimonialId'];
		$response=$oJewel->deleteTestimonial();
	}
	else
	{
		$oJewel->testimonialAuthor=$_POST['testimonialAuthor'];
		$oJewel->testimonialText=$_POST['testimonialText'];
		$oJewel->testimonialActive=$_POST['testimonialActive'];
		
		if($_POST['testimonialActionButton']=="Add Testimonial")
		{
			$response=$oJewel->addTestimonial();
		}
		elseif($_POST['testimonialActionButton']=="Update Testimonial")
		{
			$oJewel->testimonialId=$_POST['testimonialId'];
			$response=$oJewel->updateTestimonial();
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
				<h2>Home Page Content Editing</h2>
				<select name="sectionDropdown" id="sectionDropdown">
					<option value="0">Choose a section to edit...</option>
					<option value="1" <? if($section==1){echo $selected;} ?>>Info Blurbs</option>
					<option value="2" <? if($section==2){echo $selected;} ?>>Testimonials</option>
				</select>
				<hr />
				<? 
				if($response!="")
				{?>
					<div class="response">
						<? echo $response; ?>
					</div>
				<?}
				if(isset($_GET['section']))
				{
					if($_GET['section']==1)
					{?>
						<div id="contentEditSection">
							<h2>Home Information Blurbs <input type="button" id="addButton" class="theButtons" value="Add Information Blurb" /></h2>
							
							<form id="addForm" class="updateForm" method="post" action="index.php?section=1" enctype="multipart/form-data">
								<label for="homeBlurbTitle">Title: </label>
								<input type="text" name="homeBlurbTitle" size="50" value="" /><br />
								<label for="homeBlurbText">Text: </label>
								<textarea name="homeBlurbText"></textarea><br />
								<label>Choose an image: </label><br />
								<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
								<input class="photoSelect" type="file" name="photo"/><br />
								<label for="homeBlurbActive">Active?</label>
								<select name="homeBlurbActive">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select><br />
								<input type="submit" class="theButtons" name="blurbActionButton" value="Add Blurb" />
							</form>
							<?
								$blurbs=$oJewel->grabAllHomeInfo();
								
								foreach($blurbs as $blurb)
								{?>
									<form class="updateForm" method="post" action="index.php?section=1" enctype="multipart/form-data">
										<label for="homeBlurbTitle">Title: </label>
										<input type="text" name="homeBlurbTitle" size="50" value="<? echo $blurb['title']; ?>" /><br />
										<label for="homeBlurbText">Text: </label>
										<textarea name="homeBlurbText"><? echo $blurb['text']; ?></textarea><br />
										<input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
										<label>Current Image: </label>
										<input type="hidden" name="currentImageFileName" value="<? echo $blurb['image']; ?>" />
										<img src="../images/home_info/<? echo $blurb['image']; ?>" title="Current Image for <? echo $blurb['title']; ?>" /><br />
										<label>Choose another image:</label><br />
										<input class="photoSelect" type="file" name="photo"/><br />
										<label for="homeBlurbActive">Active?</label>
										<select name="homeBlurbActive">
											<option value="1" <? if($blurb['active']==1){echo $selected;} ?>>Yes</option>
											<option value="0" <? if($blurb['active']==0){echo $selected;} ?>>No</option>
										</select><br />
										<input type="hidden" name="blurbId" value="<? echo $blurb['id']; ?>" />
										<input type="submit" class="theButtons" name="blurbActionButton" value="Update Blurb" />
										<input type="submit" class="theButtons" name="blurbActionButton" value="Delete Blurb" />
									</form>
								<?}
							?>
						</div>
					<? }
					elseif($_GET['section']==2)
					{?>
						<div id="contentEditSection">
							<h2>Testimonials <input type="button" id="addButton" class="theButtons" value="Add Testimonial" /></h2>
							<form id="addForm" class="updateForm" method="post" action="index.php?section=2">
								<label for="testimonialAuthor">Author: </label>
								<input type="text" name="testimonialAuthor" size="50" value="" /><br />
								<label for="testimonialText">Quote: </label>
								<textarea name="testimonialText" maxlength="75"></textarea><span class="maxCharLimit">You have reached the max character limit!</span><br />
								<label for="testimonialActive">Active?</label>
								<select name="testimonialActive">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select><br />
								<input type="submit" class="theButtons" name="testimonialActionButton" value="Add Testimonial" />
							</form>
							<?
								$testimonials=$oJewel->grabAllTestimonialInfo();
								foreach($testimonials as $testimonial)
								{?>
									<form class="updateForm" method="post" action="index.php?section=2">
										<label for="testimonialAuthor">Author: </label>
										<input type="text" name="testimonialAuthor" size="50" value="<? echo $testimonial['author']; ?>" /><br />
										<label for="testimonialText">Quote: </label>
										<textarea name="testimonialText" maxlength="75"><? echo $testimonial['text']; ?></textarea><span class="maxCharLimit">You have reached the max character limit!</span><br />
										<label for="testimonialActive">Active?</label>
										<select name="testimonialActive">
											<option value="1" <? if($testimonial['active']==1){echo $selected;} ?>>Yes</option>
											<option value="0" <? if($testimonial['active']==0){echo $selected;} ?>>No</option>
										</select><br />
										<input type="hidden" name="testimonialId" value="<? echo $testimonial['id']; ?>" />
										<input type="submit" class="theButtons" name="testimonialActionButton" value="Update Testimonial" />
										<input type="submit" class="theButtons" name="testimonialActionButton" value="Delete Testimonial" />
									</form>
								<?}
							?>
						</div>
					<? } 
				}?>
			</div>
		</div>
	</body>
</html>