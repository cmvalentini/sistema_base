<?php

class upload {
	
	#params
	static $path_dir;
	
	# Storage the value of post variables 
	var $post = array();
	
	# Storage and decoded value of get variables
	var $get = array();
	
	#
	var $file = array();
	
	#
	var $watermark = '';
	
	function upload() {
		// Initialize the post variable
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			#If post value contain data assing to variable
			if(isset($_POST) && count($_POST) > 0){
				$this->post = $_POST;
				if(get_magic_quotes_gpc()){
					// Get rid of magic quotes and slashes if presente
					array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
				}
			}
			
			#If files contain data assing to variable 
			if(isset($_FILES) && count($_FILES) > 0){
				$this->file = $_FILES;
			}
		}
		
		// Initialize the get variable
		$this->get = $_GET;
		
		// Decode the URl 
		array_walk_recursive($this->get, array($this, 'urldecode'));
	}
	
	function setWatermark($data){
		$this->watermark = $data;
	}
	
	/*
	 * 	Function register news
	 */
	 
	function registerPostNews()
	{
		#variables to register post
		$news = array();
		$options = array();
		if(isset($this->post) && !empty($this->post)){
			#if post article is set in hidden 
			if($this->post['hidden'] == 'postArticle'){
	 			$news = $this->post;

				#set params to pass into function
				$options['title'] = $news['title'];
				$options['news'] = nl2br($news['text_area']);
				$options['type_publish'] = $news['type_publish'];
				$options['date'] = '';
				$options['category'] = $news['category'];
				
				$test = setNews($options);
				return TRUE;
	 		}
	 	
	 	}
		# Return false  
		return FALSE;
	}
	
	/**/
	
	function getPostNews($options=null, $filtro=null){
		if((isset($options) && !empty($options)) || ((isset($filtro) && !empty($filtro)))){
			return getNews($options,$filtro);
		}else{
			return getNews();
		}
	}
	
	/**/
	
	function editPostNews(){
		#variables to register post
		$news = array();
		$options = array();
		if(isset($this->post) && !empty($this->post)){
			#if post article is set in hidden 
			if($this->post['hidden'] == 'editArticle'){
				
	 			$news = $this->post;
								
				#set params to pass into function
				$options['title'] = $news['title'];
				$options['news'] = nl2br($news['text_area']);
				$options['type_publish'] = $news['type_publish'];
				$options['category'] = $news['category'];
				$options['id'] = $news['id'];
				
				$test = editNews($options);
				return $test;
	 		}
	 	}
		# Return false  
		return FALSE;
	}
	
	
	/*
	 * 
	 * */
	 
	function deletePostNews(){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'delNews') {
				$news = $this->post;
				deleteNews($news);
				return TRUE;
			}
		}
		return FALSE;
	}
	 
	 /*
	  *	Function register products 
	  */
  
	function register_products()
	{
		$products = array();
		$productsPhoto = array();
		$error = array('Error');
		$options = array();
		  
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'postProduct') {
				$products = $this->post;
				$products['desc_product'] = nl2br($this->post['desc_product']);
				
				if(strpos($products['title'], ' ')){
					$products['folder'] = str_replace(' ', '_', $products['title']).'_'.date('Y-m-d');
				}else{ $products['folder'] = $products['title'].'_'.date('Y-m-d'); }
				
				$options['product'] = $products['title'];
				$options['desc_product'] = $products['desc_product'];
				$options['precio_product'] = $products['cost'];
				$options['idcategoria'] = $products['category'];
				$options['folderproduct'] = $products['folder'];
				
				#aqui pasamos los valores a la base de datos 
				putProduct($options);
								
				# if have image files
				if (isset($this->file) && !empty($this->file)) {
					#count all files 
					$count = count($this->file['archivo']['name']);
					#get information of files
					for($i=0;$i<$count;$i++){
						$ext = explode('.', $this->file['archivo']['name'][$i]);
						$num=count($ext)-1;
						if($ext[$num] <> 'jpg'){
							return $error;
						}
						$data[$i]['name']=$this->file['archivo']['name'][$i];
						$data[$i]['path']=$this->file['archivo']['tmp_name'][$i];
						$data[$i]['size']=$this->file['archivo']['size'][$i];
						$data[$i]['type']=$this->file['archivo']['type'][$i];
						$data[$i]['extension']=$ext[$num];
						$data[$i]['string']= $this->get_string();
					}
					$productsPhoto['files'] = $data;
						
					# if exist folder otherwise create folder
					$folder = "C:\Program Files (x86)\Apache Software Foundation\Apache2.2\htdocs\ivan\\".$products['folder'];
					if (!file_exists($folder)) {
				    	mkdir($folder, 0777, true);	
					}
					
					#move files to folder 
					#get id product
					$filtro['product'] = $options['product'];
					$idProduct = getProduct(array('idproduct'),$filtro);
					for ($fl=0; $fl < count($productsPhoto['files']) ; $fl++) { 
						//move_uploaded_file($_FILES['nombre_archivo_cliente']['tmp_name'], $nombreDirectorio.$nombreFichero);
						$new_fichero = $products['title'] .'_'. $productsPhoto['files'][$fl]['string'].'.'.$productsPhoto['files'][$fl]['extension'];
						$newPath = $folder.'\\';
						copy($productsPhoto['files'][$fl]['path'], $newPath.$new_fichero);
						
						# Grabamos las fotos en la base de datos
						//setPhotoProduct($idProduct,$new_fichero);
						
						if($this->watermark){
							# call 
							$wm = new Watimage();
							$waterMark = DIR_FS_IMAGE_RESOURSES.'watermark.png';
							$dataProduct = $newPath.$new_fichero;
							$newProdData = $products['title'] .'_'. $productsPhoto['files'][$fl]['string'].'WM.'.$productsPhoto['files'][$fl]['extension'];
							$newValues = $newPath.$newProdData;

							$wm->setImage($dataProduct);
							$wm->setWatermark(array('file' => $waterMark, 'position' => 'center'));
							$wm->applyWatermark();
							if ( !$wm->generate($newValues) ) {
							  // handle error...
							  print_r($wm->errors);
							}
							# Grabamos las fotos en la base de datos
							setPhotoProduct($idProduct,$newProdData);
						}else{
							# Grabamos las fotos en la base de datos
							setPhotoProduct($idProduct,$new_fichero);
						}
												 
					}					
				}
			  }
		  }
		return TRUE;
	  }
	
	/**/	
	function getRegisterProduct($options=null, $filtro=null){
		if((isset($options) && !empty($options)) || ((isset($filtro) && !empty($filtro)))){
			return getProduct($options,$filtro);
		}else{
			return getProduct();
		}
	}
	
	/**/
	
	function editRegisterProduct($options)
	{
		#variables to register post
		$news = array();
		$options = array();
		if(isset($this->post) && !empty($this->post)){
			#if post article is set in hidden 
			if($this->post['hidden'] == 'editProduct'){
				
	 			$products = $this->post;
								
				#set params to pass into function
				$options['product'] = $products['title'];
				$options['desc_product'] = $products['desc_product'];
				$options['precio_product'] = $products['cost'];
				$options['idcategoria'] = $products['category'];
				$options['idproduct'] = $products['idproduct'];
				
				$test = editProduct($options);
				return $test;
	 		} 	
	 	}
		# Return false  
		return FALSE;
	}
	
	/**/
	
	function deleteRegisterProduct(){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'delProduct') {
				$news = $this->post;
				$del = deleteProduct($news);
				if(!$del){
					$error['Error'] = 'Tiene fotos asociadas al producto';
					return $error;
				}
			}
		}
		return TRUE;
	}

	/**/
	
	function deleteProductPhoto($data){
		if(isset($data) && !empty($data)){
			#primero borramos del servidor asi que traemos la informacion de las fotos por id
			$photos = getPhotProduct($data);
			$foldername = getProduct(array('folderproduct'), $data);
			$folder = "C:\Program Files (x86)\Apache Software Foundation\Apache2.2\htdocs\ivan\\".$foldername[0]['folderproduct'];
		
			foreach ($photos as $key) {
				unlink($folder.'\\'.$key['photoname']);
			}
			
			#removemos el directorio
			rmdir($folder);
		
			# Borramos de la base de datos
			delPhotoProd($data);
											
			return TRUE;
		}
	}
	
	//
	function addPhotoProduct(){
		$product = array();
		$productsPhoto = array();
		$error = array('Error');
		  
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'addPhotoProd') {
				
				#obtenemos los datos del producto
				$product = getProduct(array('idproduct','product','folderproduct'),array('idproduct'=>$this->post['product'])); 
				
				
				if (isset($this->file) && !empty($this->file)) {
					#count all files 
					$count = count($this->file['archivo']['name']);
					#get information of files
					for($i=0;$i<$count;$i++){
						$ext = explode('.', $this->file['archivo']['name'][$i]);
						$num=count($ext)-1;
						if($ext[$num] <> 'jpg'){
							return $error;
						}
						$data[$i]['name']=$this->file['archivo']['name'][$i];
						$data[$i]['path']=$this->file['archivo']['tmp_name'][$i];
						$data[$i]['size']=$this->file['archivo']['size'][$i];
						$data[$i]['type']=$this->file['archivo']['type'][$i];
						$data[$i]['extension']=$ext[$num];
						$data[$i]['string']= $this->get_string();
					}
					$productsPhoto['files'] = $data;
						
					# if exist folder otherwise create folder
					$folder = "C:\Program Files (x86)\Apache Software Foundation\Apache2.2\htdocs\ivan\\".$product[0]['folderproduct'];
					if (!file_exists($folder)) {
				    	mkdir($folder, 0777, true);	
					}
					
					#move files to folder 
					for ($fl=0; $fl < count($productsPhoto['files']) ; $fl++) { 
						//move_uploaded_file($_FILES['nombre_archivo_cliente']['tmp_name'], $nombreDirectorio.$nombreFichero);
						$new_fichero = $product[0]['product'] .'_'. $productsPhoto['files'][$fl]['string'].'.'.$productsPhoto['files'][$fl]['extension'];
						$newPath = $folder.'\\';
						copy($productsPhoto['files'][$fl]['path'], $newPath.$new_fichero);
						
						# Grabamos las fotos en la base de datos
						setPhotoProduct($product,$new_fichero);
												 
					}					
				}	
			}
			return true;
		}
	}
	
	//
	function editPhotoProduct(){
		$productId = null;
		$productsPhoto = array();
		$error = array('Error');
		$options = array();
		  
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'addPhotoProd') {
				
			}
		}
	}
	
	//
	function getPhotoProduct($options=null){
		if((isset($options) && !empty($options))){
			return getPhotProduct($options);
		}else{
			return getPhotProduct();
		}
	}
	
	/*
	  *	Function register album photos 
	  */
	function registerPhotos(){
		#variables to register post
		$photos = array();
		$options = array();
		$photodata =array();
		$error = array('Error1');
		if(isset($this->post) && !empty($this->post)){
			#if post photos is set in hidden 
			if($this->post['hidden'] == 'addPhotos'){
				$photos = $this->post;
				
				if(strpos($photos['album'], ' ')){
					$photos['folder'] = str_replace(' ', '_', $photos['album']).'_'.date('Y-m-d');
				}else{ $photos['folder'] = $photos['album'].'_'.date('Y-m-d'); }
				
				$options['model'] = $photos['modelo'];
				$options['photograph'] = $photos['fotografo'];
				$options['photofolder'] = $photos['folder'];
				$options['photodata'] = $photos['album'];
				$options['idcategoria'] = $photos['category'];
				
				#set values in database
				putPhotos($options);
				
				# if have image files
				if (isset($this->file) && !empty($this->file)) {
					#count all files 
					$count = count($this->file['archivo']['name']);
					#get information of files
					for($i=0;$i<$count;$i++){
						$ext = explode('.', $this->file['archivo']['name'][$i]);
						$num=count($ext)-1;
						if($ext[$num] <> 'jpg'){
							return $error;
						}
						$data[$i]['name']=$this->file['archivo']['name'][$i];
						$data[$i]['path']=$this->file['archivo']['tmp_name'][$i];
						$data[$i]['size']=$this->file['archivo']['size'][$i];
						$data[$i]['type']=$this->file['archivo']['type'][$i];
						$data[$i]['extension']=$ext[$num];
						$data[$i]['string']= $this->get_string();
					}
					$photodata['files'] = $data;
						
					# if exist folder otherwise create folder
					$folder = DIR_FS_IMAGE_PHOT.$photos['folder'];
					if (!file_exists($folder)) {
				    	mkdir($folder, 0777, true);	
					}
					
					#move files to folder 
					#get id product
					$filtro['photodata'] = $options['photodata'];
					$idPhoto = getPhotoData(array('idphoto'),$filtro);
					for ($fl=0; $fl < count($photodata['files']) ; $fl++) { 
						//move_uploaded_file($_FILES['nombre_archivo_cliente']['tmp_name'], $nombreDirectorio.$nombreFichero);
						$new_fichero = $photos['album'] .'_'. $photodata['files'][$fl]['string'].'.'.$photodata['files'][$fl]['extension'];
						$newPath = $folder.'\\';
						copy($photodata['files'][$fl]['path'], $newPath.$new_fichero);
						
						if($this->watermark){
							# call 
							$wm = new Watimage();
							$waterMark = DIR_FS_IMAGE_RESOURSES.'watermark.png';
							$dataPhoto = $newPath.$new_fichero;
							$newPhotoData = $photos['album'] .'_'. $photodata['files'][$fl]['string'].'WM.'.$photodata['files'][$fl]['extension'];
							$newValues = $newPath.$newPhotoData;

							$wm->setImage($dataPhoto);
							$wm->setWatermark(array('file' => $waterMark, 'position' => 'center'));
							$wm->applyWatermark();
							if ( !$wm->generate($newValues) ) {
							  // handle error...
							  print_r($wm->errors);
							}
							# Grabamos las fotos en la base de datos
							setPhotos($idPhoto,$newPhotoData);
						}else{
							# Grabamos las fotos en la base de datos
							setPhotos($idPhoto,$new_fichero);
						}												 
					}					
				}
			}
		}
		return TRUE;
	}
	
	/*
	*/
	
	function getAlbum($filtro){
		if((isset($filtro) && !empty($filtro))){
			return getPhotoData(array('idphoto','photodata'),$filtro);
		}else{
			return getPhotoData(array('idphoto','photodata'),null);
		}
	}
	
		
	function geAlbumsByCat(){
		#variables to register post
		$options = array();
		$photodata =array();
		$error = array('Error');
		if(isset($this->post) && !empty($this->post)){
			#if post photos is set in hidden 
			if($this->post['hidden'] == 'getAlbumCat'){
				$options['idcategoria'] = $this->post['category'];
				$photodata = getPhotosCat($options);
				if(empty($photodata)){
					return $error;
				}
				return $photodata;
			}
		}
	}
	
	function getPhotoByAlbum(){
		#variables to register post
		$options = array();
		$photodata =array();
		$error = array('Error');
		if(isset($this->post) && !empty($this->post)){
			#if post photos is set in hidden 
			if($this->post['hidden'] == 'getPhotosAlbum'){
				$options['photodata'] = $this->post['album'];
				$photodata = getPhotos($options); // hacer la funcion que traiga las fotos con el filtro del album
				if(empty($photodata)){
					return $error;
				}
				return $photodata;
			}
		}
	}

	function getPhotosByCat(){
		#variables to register post
		$options = array();
		$photodata =array();
		$error = array('Error');
		if(isset($this->post) && !empty($this->post)){
			#if post photos is set in hidden 
			if($this->post['hidden'] == 'getPhotoscat'){
				$options['idcategoria'] = $this->post['category'];
				$photodata = getPhotos($options); // la misma funcion con los filtros de categoria
				if(empty($photodata)){
					return $error;
				}
				return $photodata;
			}
		}
	}

	function getAllPhotos($filtro){ // revisar que concuerden los datos 
		if((isset($filtro) && !empty($filtro))){
			return getPhotos($filtro);
		}else{
			return getPhotos();
		}
	}
		
	function deletePhotos(){
		$photodata = null;
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'delPhotos') {
				$photos = $this->post;
				$photodata = getPhotos($photos);
				$foldername = $photodata[0]['photofolder'];
				
				$folder = "C:\Program Files (x86)\Apache Software Foundation\Apache2.2\htdocs\ivan\\".$foldername;
		
				foreach ($photodata as $key) {
					unlink($photodata.'\\'.$key['photoname']);
				}
				
				#removemos el directorio
				rmdir($folder);
			
				# Borramos de la base de datos
				delPhotos($data);
												
				return TRUE;
			}
		}
	}
	
	function deleteAlbumPhoto($data){
		#seteamos la variable que vamos a pasar y llamamos a deletephotos con esa variable 
	}

	
	/*
	 * Create Categorie for  products
	 * */
	function setCatProduct(){
		$categori = array();
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'setCategoriProduct') {
				$categori = $this->post;
				if ($categori['category'] != ' ') {
					setProductCat($categori);
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	/*
	 * modiy catego
	 * */
	function modCatProduct($productCat){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'modCategoriProduct') {
				$productCat = $this->post;
				alterCatProduct($productCat);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/*
	 * Delete cartegoria
	 * */
	function DelCatProduct($productCat){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'delCategoriProduct') {
				$productCat = $this->post;
				deleteCatProduct($productCat);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/*
	 * Get all categories for news
	 * */
	function getCatProduct(){
		$data = array();
		$data = getCateProduct();
		return $data;
	}
	
	// photograp categor
	/*
	 * Create Categorie for Photograp
	 * */
	function setCatPhoto(){
		$categori = array();
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'setCategoriPhoto') {
				$categori = $this->post;
				if ($categori['category'] != ' ') {
					setPhotoCat($categori);
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	/*
	 * modiy catego
	 * */
	function modCatPhoto($photoCat){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'modCategoriPhoto') {
				$photoCat = $this->post;
				alterCatPhoto($photoCat);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/*
	 * Delete cartegoria
	 * */
	function DelCatPhoto($photoCat){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'delCategoriPhoto') {
				$photoCat = $this->post;
				deleteCatPhoto($photoCat);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/*
	 * Get all categories for news
	 * */
	function getCatPhoto(){
		$data = array();
		$data = getCatePhoto();
		return $data;
	}
	
	// News cate
	
	/*
	 * Create Categorie for news
	 * */
	function setCatNews(){
		$categori = array();
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'setCategoriNews') {
				$categori['category'] = $this->post['category'];
				if ($categori['category'] != ' ') {
					setCatNews($categori);
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	/*
	 * modiy catego
	 * */
	function modCatNews(){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'modCategoriNews') {
				$categori = $this->post;
				alterCatNews($categori);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/*
	 * Delete cartegoria
	 * */
	function DelCatNews(){
		if(isset($this->post) && !empty($this->post)){
			if ($this->post['hidden'] == 'delCategoriNews') {
				$categori = $this->post;
				deleteCatNews($categori);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/*
	 * Get all categories for news
	 * */
	function getCatNews(){
		$data = array();
		$data = getCateNews();
		return $data;
	}
	
	/*
	 * Get params to upload Photos
	 * */
	
	function get_param(){
		return array('post'=>$this->post, 'File'=>$this->file, 'get'=>$this->get);
	}
	
	/*
	 * Get string to upload Photos
	 * */
	function get_string(){
		$strings = 'abcdefghijklmNopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; 
		# string long
		$long = 6; 		
		$new_string = '';
		
		#loop to string
		for ($i=0; $i <= $long; $i++){ 
			$rand = rand(0, strlen($strings)); 
			$new_string .= $strings[$rand]; 
		} 
		return $new_string; 
	}
		
	/*
	*	stripslash gpc
	*/
	
	protected function stripslash_gpc(&$value){
		$value = stripslashes($value);
	}
	
	/*
	 *	htmlspecialcarfy 
	 */
	 protected function htmlspecialcarfy(&$value){
		$value = htmlspecialchars($value);
	}

	/*
	 *	URL Decode 
	 */
	 protected function urldecode(&$value){
		$value = urldecode($value);
	}
	
}

?>