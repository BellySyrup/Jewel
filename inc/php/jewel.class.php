<?
Class Jewel 
{
	//declare properties needed to store info
	public $Dbh;
	
	
	//home_info properties
	public $homeInfoId;
	public $homeInfoTitle;
	public $homeInfoText;
	public $homeInfoImage;
	public $homeInfoActive;
	
	//manufacturer properties
	public $manufacturerId;
	public $manufacturerName;
	public $manufacturerPhoneNum;
	public $manufacturerLink;
	public $manufacturerImage;
	public $manufacturerProductTypes;
	
	//testimonial properties
	public $testimonialId;
	public $testimonialAuthor;
	public $testimonialText;
	public $testimonialActive;
	
	//product type properties
	public $productTypeId;
	public $productTypeName;
	public $productTypeDescription;
	public $productTypeImage;
	
	//product services properties
	public $serviceId;
	public $serviceName;
	public $serviceDescription;
	public $serviceImage;
	
	
	
	public function __construct ()
	{
		require_once("connect_db.php");
		$this->Dbh=&$dbh;
	}
	
	
	/*********************************************************************************************/
	//////////////////////////////////// Home Info Methods ////////////////////////////////////////
	/*********************************************************************************************/
	
	public function grabHomeInfo()
	{
		$query="SELECT * 
				FROM home_info
				WHERE active='1'
				LIMIT 2";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['title']=stripslashes($row[1]);
			$data[$x]['text']=stripslashes($row[2]);
			$data[$x]['image']=stripslashes($row[3]);
			$data[$x]['active']=stripslashes($row[4]);
			$x++;
		}
		
		return $data;
	}
	
	public function grabAllHomeInfo()
	{
		$query="SELECT * 
				FROM home_info";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['title']=stripslashes($row[1]);
			$data[$x]['text']=stripslashes($row[2]);
			$data[$x]['image']=stripslashes($row[3]);
			$data[$x]['active']=stripslashes($row[4]);
			$x++;
		}
		
		return $data;
	}
	
	//update a home info using objects' properties
	public function updateHomeInfo()
	{
		try
		{
			$query="UPDATE home_info
					SET title='".addslashes($this->homeInfoTitle)."',
					text='".addslashes($this->homeInfoText)."',
					image='".addslashes($this->homeInfoImage)."',
					active='".addslashes($this->homeInfoActive)."'
					WHERE id='".addslashes($this->homeInfoId)."'";
					
			$this->Dbh->query($query);
			
			return "Update Successful";
		} 
		catch (Exception $e) 
		{
			return "Update unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//delete a home info blurb using the objects' tourId property
	public function deleteHomeInfo()
	{
		try
		{
			$query="DELETE FROM home_info
					WHERE id='".addslashes($this->homeInfoId)."'";
					
			$this->Dbh->query($query);
			
			return "Delete Successful";
		} 
		catch (Exception $e) 
		{
			return "Delete unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//add a new manufacturer using the objects' properties
	public function addHomeInfo()
	{
		try
		{
			$query="INSERT INTO home_info
					SET title='".addslashes($this->homeInfoTitle)."',
					text='".addslashes($this->homeInfoText)."',
					image='".addslashes($this->homeInfoImage)."',
					active='".addslashes($this->homeInfoActive)."'";
					
			$this->Dbh->query($query);
			
			return "Insert Successful";
		} 
		catch (Exception $e) 
		{
			return "Insert unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	
	
	
	
	/*********************************************************************************************/
	///////////////////////////////// Manufacturer Methods ///////////////////////////////////////
	/*********************************************************************************************/
	
	public function grabManufacturerInfo()
	{
		$query="SELECT * 
				FROM manufacturers
				ORDER BY name ASC";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['name']=stripslashes($row[1]);
			$data[$x]['phone_num']=stripslashes($row[2]);
			$data[$x]['link']=stripslashes($row[3]);
			$data[$x]['image']=stripslashes($row[4]);
			
			$productTypesStr=stripslashes($row[5]);
			$productTypes=explode(",",$productTypesStr);
			
			foreach($productTypes as $key=>$type)
			{
				$data[$x]['productType'][$key]=$type;
			}
			$x++;
		}
		
		return $data;
	}
	
	//function tograb the manufacturers whee the name starts with the passed letter
	public function grabAlphaManufacturerInfo($letter)
	{
		$data=null;
		$upperLetter=strtoupper($letter);
		$lowerLetter=strtolower($letter);
		
		$query="SELECT * 
				FROM manufacturers
				WHERE name LIKE '".$upperLetter."%'
				OR name LIKE '".$lowerLetter."%'
				ORDER BY name ASC";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['name']=stripslashes($row[1]);
			$data[$x]['phone_num']=stripslashes($row[2]);
			$data[$x]['link']=stripslashes($row[3]);
			$data[$x]['image']=stripslashes($row[4]);
			
			$productTypesStr=stripslashes($row[5]);
			$productTypes=explode(",",$productTypesStr);
			
			foreach($productTypes as $key=>$type)
			{
				$data[$x]['productType'][$key]=$type;
			}
			$x++;
		}
		
		return $data;
	}
	
	//update a manufaturer's using objects' properties
	public function updateManufacturerInfo()
	{
		try
		{
			$query="UPDATE manufacturers
					SET name='".addslashes($this->manufacturerName)."',
					phone_num='".addslashes($this->manufacturerPhoneNum)."',
					link='".addslashes($this->manufacturerLink)."',
					image='".addslashes($this->manufacturerImage)."',
					product_types='".addslashes($this->manufacturerProductTypes)."'
					WHERE id='".addslashes($this->manufacturerId)."'";
					
			$this->Dbh->query($query);
			
			return "Update Successful";
		} 
		catch (Exception $e) 
		{
			return "Update unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//delete a manufacturer using the objects' tourId property
	public function deleteManufacturerInfo()
	{
		try
		{
			$query="DELETE FROM manufacturers
					WHERE id='".addslashes($this->manufacturerId)."'";
					
			$this->Dbh->query($query);
			
			return "Delete Successful";
		} 
		catch (Exception $e) 
		{
			return "Delete unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//add a new manufacturer using the objects' properties
	public function addManufacturerInfo()
	{
		try
		{
			$query="INSERT INTO manufacturers
					SET name='".addslashes($this->manufacturerName)."',
					phone_num='".addslashes($this->manufacturerPhoneNum)."',
					link='".addslashes($this->manufacturerLink)."',
					image='".addslashes($this->manufacturerImage)."',
					product_types='".addslashes($this->manufacturerProductTypes)."'";
					
			$this->Dbh->query($query);
			
			return "Insert Successful";
		} 
		catch (Exception $e) 
		{
			return "Insert unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	
	
	/*********************************************************************************************/
	/////////////////////////////////// Testimonial Methods ///////////////////////////////////////
	/*********************************************************************************************/
	
	public function grabTestimonialInfo()
	{
		$query="SELECT * 
				FROM testimonials
				WHERE active='1'";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['author']=stripslashes($row[1]);
			$data[$x]['text']=stripslashes($row[2]);
			$x++;
		}
		
		return $data;
	}
	
	public function grabAllTestimonialInfo()
	{
		$query="SELECT * 
				FROM testimonials";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['author']=stripslashes($row[1]);
			$data[$x]['text']=stripslashes($row[2]);
			$data[$x]['active']=stripslashes($row[3]);
			$x++;
		}
		
		return $data;
	}
	
	//update a testimonial using objects' properties
	public function updateTestimonial()
	{
		try
		{
			$query="UPDATE testimonials
					SET author='".addslashes($this->testimonialAuthor)."',
					text='".addslashes($this->testimonialText)."',
					active='".addslashes($this->testimonialActive)."'
					WHERE id='".addslashes($this->testimonialId)."'";
					
			$this->Dbh->query($query);
			
			return "Update Successful";
		} 
		catch (Exception $e) 
		{
			return "Update unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//delete a testimonial using the objects' tourId property
	public function deleteTestimonial()
	{
		try
		{
			$query="DELETE FROM testimonials
					WHERE id='".addslashes($this->testimonialId)."'";
					
			$this->Dbh->query($query);
			
			return "Delete Successful";
		} 
		catch (Exception $e) 
		{
			return "Delete unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//add a new testmonial using the objects' properties
	public function addTestimonial()
	{
		try
		{
			$query="INSERT INTO testimonials
					SET author='".addslashes($this->testimonialAuthor)."',
					text='".addslashes($this->testimonialText)."',
					active='".addslashes($this->testimonialActive)."'";
					
			$this->Dbh->query($query);
			
			return "Insert Successful";
		} 
		catch (Exception $e) 
		{
			return "Insert unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	
	/*********************************************************************************************/
	////////////////////////////////// Product Type Methods ///////////////////////////////////////
	/*********************************************************************************************/
	
	public function grabProductTypeInfo()
	{
		$query="SELECT * 
				FROM product_types
				ORDER BY name ASC";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['name']=stripslashes($row[1]);
			$data[$x]['description']=stripslashes($row[2]);
			$data[$x]['image']=stripslashes($row[3]);
			$x++;
		}
		
		return $data;
	}
	
	public function grabProductTypeList()
	{
		$query="SELECT id,name 
				FROM product_types
				ORDER BY name ASC";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['name']=stripslashes($row[1]);
			$x++;
		}
		
		return $data;
	}
	
	//grab the name of a product type based on a passed id
	public function getProductTypeName($id)
	{
		$query="SELECT name
				FROM product_types
				WHERE id='".addslashes($id)."'";
		
		foreach($this->Dbh->query($query) as $row)
		{
			$data=stripslashes($row[0]);
		}
		
		return $data;
	}
	
	//update a product type using objects' properties
	public function updateProductType()
	{
		try
		{
			$query="UPDATE product_types
					SET name='".addslashes($this->productTypeName)."',
					description='".addslashes($this->productTypeDescription)."',
					image='".addslashes($this->productTypeImage)."'
					WHERE id='".addslashes($this->productTypeId)."'";
					
			$this->Dbh->query($query);
			
			return "Update Successful";
		} 
		catch (Exception $e) 
		{
			return "Update unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//delete a product type using the objects' tourId property
	public function deleteProductType()
	{
		try
		{
			$query="DELETE FROM product_types
					WHERE id='".addslashes($this->productTypeId)."'";
					
			$this->Dbh->query($query);
			
			return "Delete Successful";
		} 
		catch (Exception $e) 
		{
			return "Delete unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//add a new producttype using the objects' properties
	public function addProductType()
	{
		try
		{
			$query="INSERT INTO product_types
					SET name='".addslashes($this->productTypeName)."',
					description='".addslashes($this->productTypeDescription)."',
					image='".addslashes($this->productTypeImage)."'";
					
			$this->Dbh->query($query);
			
			return "Insert Successful";
		} 
		catch (Exception $e) 
		{
			return "Insert unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	
	/*********************************************************************************************/
	////////////////////////////////// Services Methods ///////////////////////////////////////
	/*********************************************************************************************/
	
	public function grabServiceInfo()
	{
		$query="SELECT * 
				FROM services
				ORDER BY name ASC";
		
		$x=0;
		foreach($this->Dbh->query($query) as $row)
		{
			$data[$x]['id']=stripslashes($row[0]);
			$data[$x]['name']=stripslashes($row[1]);
			$data[$x]['description']=stripslashes($row[2]);
			$data[$x]['image']=stripslashes($row[3]);
			$x++;
		}
		
		if(isset($data))
		{
			return $data;
		}
		else
		{
			return null;
		}
	}
	
	//update a product type using objects' properties
	public function updateService()
	{
		try
		{
			$query="UPDATE services
					SET name='".addslashes($this->serviceName)."',
					description='".addslashes($this->serviceDescription)."',
					image='".addslashes($this->serviceImage)."'
					WHERE id='".addslashes($this->serviceId)."'";
					
			$this->Dbh->query($query);
			
			return "Update Successful";
		} 
		catch (Exception $e) 
		{
			return "Update unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//delete a product type using the objects' tourId property
	public function deleteService()
	{
		try
		{
			$query="DELETE FROM services
					WHERE id='".addslashes($this->serviceId)."'";
					
			$this->Dbh->query($query);
			
			return "Delete Successful";
		} 
		catch (Exception $e) 
		{
			return "Delete unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	//add a new producttype using the objects' properties
	public function addService()
	{
		try
		{
			$query="INSERT INTO services
					SET name='".addslashes($this->serviceName)."',
					description='".addslashes($this->serviceDescription)."',
					image='".addslashes($this->serviceImage)."'";
					
			$this->Dbh->query($query);
			
			return "Insert Successful";
		} 
		catch (Exception $e) 
		{
			return "Insert unsuccessful: ".$e->getMessage()."\n";
		}
	}
	
	
	
	
	
	
}
?>