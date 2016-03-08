<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////
//
// Queries File
//
// Package: Generic site 
// Author: Ivan Mera <ivan.mera13@gmail.com>
//
//////////////////////////////////////////////////////////////////////////////////////////////////////

/*
 *	Function to return the city
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	CityId, CountryId, RegionId, City, Latitude, Longitude, TimeZone, DmaId, Code
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	CityId, CountryId, RegionId, City, Latitude, Longitude, TimeZone, DmaId, Code
 *  Return
 * 		$data (array): Contain result of query
 */
function get_city($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain

	if(isset($filtro['CityId'])){ $where .= " AND CityId = {$filtro['CityId']} "; }
	if(isset($filtro['CountryId'])){ $where .= " AND CountryId = {$filtro['CountryId']} "; }
	if(isset($filtro['RegionId'])){ $where .= " AND RegionId = {$filtro['RegionId']} "; }
	if(isset($filtro['City'])){ $where .= " AND City = {$filtro['City']} "; }
	if(isset($filtro['Latitude'])){ $where .= " AND Latitude = {$filtro['Latitude']} "; }
	if(isset($filtro['Longitude'])){ $where .= " AND Longitude = {$filtro['Longitude']} "; }
	if(isset($filtro['TimeZone'])){ $where .= " AND TimeZone = {$filtro['TimeZone']} "; }
	if(isset($filtro['DmaId'])){ $where .= " AND DmaId = {$filtro['DmaId']} "; }
	if(isset($filtro['Code'])){ $where .= " AND Code = {$filtro['Code']} "; }
	if(isset($filtro['Title'])){ $where .= " AND Title = {$filtro['Title']} "; }

	$sql = " SELECT	$options FROM load_city WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;
}

/*
 *	Function to return the countries
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	CountryId, Country, FIPS104, ISO2, ISO3, ISON, Internet, Capital, MapReference, 
 * 							NationalitySingular, NationalityPlural, Currency, CurrencyCode, Population, Title, Comment
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	CountryId, Country, FIPS104, ISO2, ISO3, ISON, Internet, Capital, MapReference, 
 * 							NationalitySingular, NationalityPlural, Currency, CurrencyCode, Population, Title, Comment
 *  Return
 * 		$data (array): Contain result of query
 */

function get_countries_register($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	if(isset($filtro['CountryId'])){ $where .= " AND CountryId = {$filtro['CountryId']} "; } 
	if(isset($filtro['Country'])){ $where .= " AND Country = {$filtro['Country']} "; } 
	if(isset($filtro['FIPS104'])){ $where .= " AND FIPS104 = {$filtro['FIPS104']} "; } 
	if(isset($filtro['ISO2'])){ $where .= " AND ISO2 = {$filtro['ISO2']} "; } 
	if(isset($filtro['ISO3'])){ $where .= " AND ISO3 = {$filtro['ISO3']} "; } 
	if(isset($filtro['ISON'])){ $where .= " AND ISON = {$filtro['ISON']} "; } 
	if(isset($filtro['Internet'])){ $where .= " AND Internet = {$filtro['Internet']} "; } 
	if(isset($filtro['Capital'])){ $where .= " AND Capital = {$filtro['Capital']} "; } 
	if(isset($filtro['MapReference'])){ $where .= " AND MapReference = {$filtro['MapReference']} "; } 
	if(isset($filtro['NationalitySingular'])){ $where .= " AND NationalitySingular = {$filtro['NationalitySingular']} "; } 
	if(isset($filtro['NationalityPlural'])){ $where .= " AND NationalityPlural = {$filtro['NationalityPlural']} "; } 
	if(isset($filtro['Currency'])){ $where .= " AND Currency = {$filtro['Currency']} "; } 
	if(isset($filtro['CurrencyCode'])){ $where .= " AND CurrencyCode = {$filtro['CurrencyCode']} "; } 
	if(isset($filtro['Population'])){ $where .= " AND Population = {$filtro['Population']} "; } 
	if(isset($filtro['Title'])){ $where .= " AND Title = {$filtro['Title']} "; } 
	if(isset($filtro['Comment'])){ $where .= " AND Comment = {$filtro['Comment']} "; }
	
	$sql = " SELECT	$options FROM countries_register WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the Regions
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	RegionId, CountryId, Region, Code, ADM1Code
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	RegionId, CountryId, Region, Code, ADM1Code
 *  Return
 * 		$data (array): Contain result of query
 */

function get_load_regions($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['RegionId'])){ $where .= " AND RegionId = {$filtro['RegionId']} "; } 
	if(isset($filtro['CountryId'])){ $where .= " AND CountryId = {$filtro['CountryId']} "; } 
	if(isset($filtro['Region'])){ $where .= " AND Region = {$filtro['Region']} "; } 
	if(isset($filtro['Code'])){ $where .= " AND Code = {$filtro['Code']} "; } 
	if(isset($filtro['ADM1Code'])){ $where .= " AND ADM1Code = {$filtro['ADM1Code']} "; } 
	
	$sql = " SELECT	$options FROM load_regions WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}


/*
 *	Function to return the Category of product
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	idcategoria, desc_categoria
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	idcategoria, desc_categoria
 *  Return
 * 		$data (array): Contain result of query
 */
 /*
function get_categoriaproduct($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['idcategoria'])){ $where .= " AND idcategoria = {$filtro['idcategoria']} "; } 
	if(isset($filtro['desc_categoria'])){ $where .= " AND desc_categoria = {$filtro['desc_categoria']} "; } 
	
	$sql = " SELECT	$options FROM categoriaproduct WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}
*/

/*
 *	Function to return the product
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	idproduct, desc_product, precio_product, idcategoria
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	idproduct, desc_product, precio_product, idcategoria
 *  Return
 * 		$data (array): Contain result of query
 */
 
function getProduct($campos = null, $filtro = null){
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['idproduct'])){ $where .= " AND idproduct = {$filtro['idproduct']} "; }
	if(isset($filtro['product'])){ $where .= " AND product = '{$filtro['product']}' "; }  
	if(isset($filtro['desc_product'])){ $where .= " AND desc_product = '{$filtro['desc_product']}' "; } 
	if(isset($filtro['precio_product'])){ $where .= " AND precio_product = {$filtro['precio_product']} "; } 
	if(isset($filtro['idcategoria'])){ $where .= " AND idcategoria = {$filtro['idcategoria']} "; } 
	
	$sql = " SELECT	$options FROM product WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the product
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	idproduct, desc_product, precio_product, idcategoria
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	idproduct, desc_product, precio_product, idcategoria
 *  Return
 * 		$data (array): Contain result of query
 */
 
function getPhotoData($campos = null, $filtro = null){
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['idphoto'])){ $where .= " AND idphoto = {$filtro['idphoto']} "; }
	if(isset($filtro['photodata'])){ $where .= " AND photodata = '{$filtro['photodata']}' "; }  
	if(isset($filtro['model'])){ $where .= " AND model = '{$filtro['model']}' "; } 
	if(isset($filtro['photograph'])){ $where .= " AND photograph = {$filtro['photograph']} "; }
	if(isset($filtro['photofolder'])){ $where .= " AND photofolder = {$filtro['photofolder']} "; }  
	if(isset($filtro['idcategoria'])){ $where .= " AND idcategoria = {$filtro['idcategoria']} "; } 
	
	
	$sql = " SELECT	$options FROM photos WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;
}

function getPhotos($option){
		
	$where = " 1 = 1";

	if(isset($option['idcategoria'])){ $where .= " AND ph.idcategoria = {$option['idcategoria']} "; }
	if(isset($option['photograph'])){ $where .= " AND ph.photograph = {$option['photograph']} "; }
	if(isset($option['model'])){ $where .= " AND ph.model = {$option['model']} "; }
	if(isset($option['photodata'])){ $where .= " AND ph.photodata = {$option['photodata']} "; }
	
	$sql = "SELECT phd.id, phd.photoname, ph.photofolder, ph.photodata
			FROM photos as ph 
			INNER JOIN photodata as phd ON (ph.idphoto = phd.idphoto)
			WHERE $where";
	
	// Call poiter to connect 
	$db = new Database();
	
	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	if(isset($data) AND count($data)>0){
		return $data;
	}
	return FALSE;
	
}


function getPhotosCat($cat){
		
	$where = " 1 = 1";

	if(isset($cat)){ $where .= " AND ph.idcategoria = {$cat['idcategoria']} "; } 
	
	$sql = "SELECT phd.id, phd.idphoto, ph.photofolder, ph.photodata as album
			FROM photos as ph 
			INNER JOIN photodata as phd ON (ph.idphoto = phd.idphoto)
			WHERE $where";
	
	// Call poiter to connect 
	$db = new Database();
	
	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	if(isset($data) AND count($data)>0){
		return $data;
	}
	return FALSE;
	
}




/**/
function deleteProduct($data){
	if (isset($data) && is_array($data)) {
		$id = $data['idproduct'];
	}else{
		return FALSE;
	}
	
	#get product photos
	$get = CountPhotoProduct($id);
	
	#if have more than 0 return a error or false 
	if(empty($get)){
		return FALSE;
	}
	
	$sql = "DELETE FROM product WHERE idproduct = {$id};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}


function deletePhotos($data){
	if (isset($data) && is_array($data)) {
		$id = $data['idproduct'];
	}else{
		return FALSE;
	}
	
	#get product photos
	$get = CountPhotos($id);
	
	#if have more than 0 return a error or false 
	if(empty($get)){
		return FALSE;
	}
	
	$sql = "DELETE FROM photos WHERE idphoto = {$id};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

//

function delPhotos($id){
	if(isset($id)){ $idp = $id['idproduct']; }
	
	$sql = "DELETE FROM photodata WHERE idphoto = {$idp};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

function delPhotoProd($id){
	if(isset($id)){ $idp = $id['idproduct']; }
	
	$sql = "DELETE FROM productphoto WHERE idproduct = {$idp};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Get 
 * 
 */
function CountPhotoProduct($id=null){
			
	$sql = "SELECT count(*) FROM productphoto WHERE idproduct = {$id};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	while($row = $db->fetchAssoc()){
		$data = $row;
	}
	$db->close();
	return $data;
}

function CountPhotos($id=null){
			
	$sql = "SELECT count(*) FROM photodata WHERE idphoto = {$id};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	while($row = $db->fetchAssoc()){
		$data = $row;
	}
	$db->close();
	return $data;
}

/*
 * 
 * */

function editProduct($campos = null)
{
	$options = null;
	$var = array();
	#validate if $options is empty

	if(isset($campos['product'])){ $var[] = "product = '{$campos['product']}'";} 
	if(isset($campos['desc_product'])){ $var[] =  "desc_product = '{$campos['desc_product']}'";}
	if(isset($campos['precio_product'])){ $var[] = "precio_product = '{$campos['precio_product']}'";}
	if(isset($campos['idcategoria'])){$var[] = "idcategoria = {$campos['idcategoria']}' ";}
	
	$set = "SET ". implode(",", $var);
	
	if(isset($campos['id'])){$where = "WHERE idproduct = {$campos['idproduct']} ";}
	
	$sql = " UPDATE	product $set $where";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
} 
 
 
 
/*
 * 
 * */

function getNews($campos = null, $filtro = null){
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['idnews'])){ $where .= " AND idnews = {$filtro['idnews']} "; } 
	if(isset($filtro['title'])){ $where .= " AND title = {$filtro['title']} "; } 
	if(isset($filtro['autor'])){ $where .= " AND autor = {$filtro['autor']} "; } 
	if(isset($filtro['news'])){ $where .= " AND news = {$filtro['news']} "; } 
	if(isset($filtro['type_publish'])){ $where .= " AND type_publish = {$filtro['type_publish']} "; } 
	if(isset($filtro['date'])){ $where .= " AND date = {$filtro['date']} "; } 
	if(isset($filtro['category'])){ $where .= " AND category = {$filtro['category']} "; } 
	
	$sql = " SELECT	$options FROM news WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;
}


/*
 * 
 * */

function editNews($campos = null)
{
	$options = null;
	$var = array();
	#validate if $options is empty

	if(isset($campos['title'])){ $var[] = "title = '{$campos['title']}'";} 
	if(isset($campos['news'])){ $var[] =  "news = '{$campos['news']}'";}
	if(isset($campos['type_publish'])){ $var[] = "type_publish = '{$campos['type_publish']}'";}
	if(isset($campos['date'])){$var[] = "date = Now() ";}
	if(isset($campos['category'])){$var[] = "category = {$campos['category']}";}
	
	$set = "SET ". implode(",", $var);
	
	if(isset($campos['id'])){$where = "WHERE idnews = {$campos['id']} ";}
	
	$sql = " UPDATE	news $set $where";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to return the data with the keywors in stats 
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 		$data (array): Contain result of query
 */

function deleteNews($data){
	if (isset($data) && is_array($data)) {
		$id = $data['idnews'];
	}else{
		return FALSE;
	}
	
	$sql = "DELETE FROM news WHERE idnews = {$id};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}


/*
 *	Function to return the status of bill
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	estado_factura, estado, desc_estado
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	estado_factura, estado, desc_estado
 *  Return
 * 		$data (array): Contain result of query
 */
 
function get_estados_factura($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['estado_factura'])){ $where .= " AND estado_factura = {$filtro['estado_factura']} "; } 
	if(isset($filtro['estado'])){ $where .= " AND estado = {$filtro['estado']} "; } 
	if(isset($filtro['desc_estado'])){ $where .= " AND desc_estado = {$filtro['desc_estado']} "; } 
	
	$sql = " SELECT	$options FROM estados_factura WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the details of bill
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	iddetallefact, numberfact, idproduct, cantidad, detallefact, valordetalle, id_fact
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	iddetallefact, numberfact, idproduct, cantidad, detallefact, valordetalle, id_fact
 *  Return
 * 		$data (array): Contain result of query
 */
 
function get_factdetalle($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['iddetallefact'])){ $where .= " AND iddetallefact = {$filtro['iddetallefact']} "; } 
	if(isset($filtro['numberfact'])){ $where .= " AND numberfact = {$filtro['numberfact']} "; } 
	if(isset($filtro['idproduct'])){ $where .= " AND idproduct = {$filtro['idproduct']} "; } 
	if(isset($filtro['cantidad'])){ $where .= " AND cantidad = {$filtro['cantidad']} "; } 
	if(isset($filtro['detallefact'])){ $where .= " AND detallefact = {$filtro['detallefact']} "; } 
	if(isset($filtro['valordetalle'])){ $where .= " AND valordetalle = {$filtro['valordetalle']} "; } 
	if(isset($filtro['id_fact'])){ $where .= " AND id_fact = {$filtro['id_fact']} "; } 
	
	$sql = " SELECT	$options FROM factdetalle WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the bill
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_fact, numberfact, fechafact, codcliente, estado_factura
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_fact, numberfact, fechafact, codcliente, estado_factura
 *  Return
 * 		$data (array): Contain result of query
 */

function get_factura($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['id_fact'])){ $where .= " AND id_fact = {$filtro['id_fact']} "; } 
	if(isset($filtro['numberfact'])){ $where .= " AND numberfact = {$filtro['numberfact']} "; } 
	if(isset($filtro['fechafact'])){ $where .= " AND fechafact = {$filtro['fechafact']} "; } 
	if(isset($filtro['codcliente'])){ $where .= " AND codcliente = {$filtro['codcliente']} "; } 
	if(isset($filtro['estado_factura'])){ $where .= " AND estado_factura = {$filtro['estado_factura']} "; } 
	
	$sql = " SELECT	$options FROM factura WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the socialmedia
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	idsocial, socialnet, iconsocial, urliconmedia
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	idsocial, socialnet, iconsocial, urliconmedia
 *  Return
 * 		$data (array): Contain result of query
 */

function get_socialmedia($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['idsocial'])){ $where .= " AND idsocial = {$filtro['idsocial']} "; } 
	if(isset($filtro['socialnet'])){ $where .= " AND socialnet = {$filtro['socialnet']} "; } 
	if(isset($filtro['iconsocial'])){ $where .= " AND iconsocial = {$filtro['iconsocial']} "; } 
	if(isset($filtro['urliconmedia'])){ $where .= " AND urliconmedia = {$filtro['urliconmedia']} "; } 
	
	$sql = " SELECT	$options FROM socialmedia WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the details of socialmedia
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	idsocialdetail, urlsocialmedia, idsocial
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	idsocialdetail, urlsocialmedia, idsocial
 *  Return
 * 		$data (array): Contain result of query
 */

function get_socialmedia_details($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['idsocial'])){ $where .= " AND idsocial = {$filtro['idsocial']} "; } 
	if(isset($filtro['idsocialdetail'])){ $where .= " AND idsocialdetail = {$filtro['idsocialdetail']} "; } 
	if(isset($filtro['urlsocialmedia'])){ $where .= " AND urlsocialmedia = {$filtro['urlsocialmedia']} "; } 
	
	$sql = " SELECT	$options FROM socialmedia_details WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the stats of day
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_day, day, user, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_day, day, user, view
 *  Return
 * 		$data (array): Contain result of query
 */

function get_stats_day($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain

	if(isset($filtro['id_day'])){ $where .= " AND id_day = {$filtro['id_day ']} "; } 
	if(isset($filtro['day'])){ $where .= " AND day = {$filtro['day']} "; } 
	if(isset($filtro['user'])){ $where .= " AND user = {$filtro['user']} "; } 
	if(isset($filtro['view'])){ $where .= " AND view = {$filtro['view']} "; } 
	
	$sql = " SELECT	$options FROM stats_day WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the data with stats for ips
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_ips, ip, time, online
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_ips, ip, time, online
 *  Return
 * 		$data (array): Contain result of query
 */

function get_stats_ips($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain

	if(isset($filtro['id_ips'])){ $where .= " AND id_ips = {$filtro['id_ips ']} "; } 
	if(isset($filtro['ip'])){ $where .= " AND ip = {$filtro['ip']} "; } 
	if(isset($filtro['time'])){ $where .= " AND time = {$filtro['time']} "; } 
	if(isset($filtro['online'])){ $where .= " AND online = {$filtro['online']} "; } 
	
	$sql = " SELECT	$options FROM stats_ips WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the data with the keywors in stats 
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 		$data (array): Contain result of query
 */

function get_stats_keyword($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain

	if(isset($filtro['id_key'])){ $where .= " AND id_key = {$filtro['id_key ']} "; } 
	if(isset($filtro['day'])){ $where .= " AND day = {$filtro['day']} "; } 
	if(isset($filtro['keyword'])){ $where .= " AND keyword = {$filtro['keyword']} "; } 
	if(isset($filtro['view'])){ $where .= " AND view = {$filtro['view']} "; } 
	
	$sql = " SELECT	$options FROM stats_keyword WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the data with the language in stats 
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_lang, day, language, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_lang, day, language, view
 *  Return
 * 		$data (array): Contain result of query
 */

function get_stats_language($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain

	if(isset($filtro['id_lang'])){ $where .= " AND id_lang = {$filtro['id_lang ']} "; } 
	if(isset($filtro['day'])){ $where .= " AND day = {$filtro['day']} "; } 
	if(isset($filtro['language'])){ $where .= " AND language = {$filtro['language']} "; } 
	if(isset($filtro['view'])){ $where .= " AND view = {$filtro['view']} "; } 
	
	$sql = " SELECT	$options FROM stats_language WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the data with the stats pages
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_page, day, page, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_page, day, page, view
 *  Return
 * 		$data (array): Contain result of query
 */

function get_stats_page($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain

	if(isset($filtro['id_page'])){ $where .= " AND id_page = {$filtro['id_page ']} "; } 
	if(isset($filtro['day'])){ $where .= " AND day = {$filtro['day']} "; } 
	if(isset($filtro['page'])){ $where .= " AND page = {$filtro['page']} "; } 
	if(isset($filtro['view'])){ $where .= " AND view = {$filtro['view']} "; } 
	
	$sql = " SELECT	$options FROM stats_page WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the data with the stats referer
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_referer, day, referer, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_referer, day, referer, view
 *  Return
 * 		$data (array): Contain result of query
 */

function get_stats_referer($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain

	if(isset($filtro['id_referer'])){ $where .= " AND id_referer = {$filtro['id_referer ']} "; } 
	if(isset($filtro['day'])){ $where .= " AND day = {$filtro['day']} "; } 
	if(isset($filtro['referer'])){ $where .= " AND referer = {$filtro['referer']} "; } 
	if(isset($filtro['view'])){ $where .= " AND view = {$filtro['view']} "; } 
	
	$sql = " SELECT	$options FROM stats_referer WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/*
 *	Function to return the data with the type of user
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_type, type_user
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_type, type_user
 *  Return
 * 		$data (array): Contain result of query
 */

function get_type_users($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain

	if(isset($filtro['id_type'])){ $where .= " AND id_type = {$filtro['id_type ']} "; } 
	if(isset($filtro['type_user'])){ $where .= " AND type_user = {$filtro['type_user']} "; } 
	
	$sql = " SELECT	$options FROM type_users WHERE $where";
		
	// Call poiter to connect 
	$db = new Database();

	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	return $data;

}

/**/

function valid_user($user,$password){
	
	$where = " 1=1";
	if(!isset($user) || !isset($password)){
		return FALSE;
	}else{
		$where .= " AND username_login = '{$user}' AND password_login = '{$password}'";
	}
	
	$sql = " SELECT	* FROM users_register WHERE $where";
	
	$db = new Database();
	
	$db->query($sql);
	if($db->failed()){
		return FALSE;
	}
	if($row = $db->fetchAssoc()){
		return TRUE;
	}else{
		return FALSE;
	}
	$db->close();
	
	return TRUE;
}
/**/
function userRegister($user){
	
	$where = " 1=1";
	if(!isset($user)){
		return FALSE;
	}else{
		$where .= " AND username_login = '{$user}'";
	}
	
	$sql = " SELECT	* FROM users_register WHERE $where";
	
	$db = new Database();
	
	$db->query($sql);
	if($db->failed()){
		return FALSE;
	}
	if($row = $db->fetchAssoc()){
		return TRUE;
	}else{
		return FALSE;
	}
	$db->close();
	
	return TRUE;
}



/**/

function resetpass($mail, $password){
	if(!isset($mail) || !isset($password)){
		return FALSE;
	}else{
		$where = " email_user = '{$mail}'";
	}
	
	$sql = " UPDATE users_register SET password_login = '{$password}' WHERE $where";
	$db = new Database();
	
	$db->query($sql);

	if($db->failed()){
		return FALSE;
	}
	$db->close();
	
	return TRUE;
}

/**/

function valid_mail($mail){
	
	$where = " 1=1";
	if(!isset($mail)){
		return FALSE;
	}else{
		$where .= " AND email_user = '{$mail}'";
	}
	
	$sql = " SELECT	* FROM users_register WHERE $where";
	
	$db = new Database();
	
	$db->query($sql);
	if($db->failed()){
		return FALSE;
	}
	if($row = $db->fetchAssoc()){
		return TRUE;
	}else{
		return FALSE;
	}
	$db->close();
	
	return TRUE;
}

/*
 *	Function to return the users registers
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_user, name_user, surname_user, email_user, username_login, password_login, id_type_user
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_user, name_user, surname_user, email_user, username_login, password_login, id_type_user
 *  Return
 * 		$data (array): Contain result of query
 */
function get_users_register($campos = null, $filtro = null)
{
	$options = null;
	#validate if $options is empty
	if (!isset($campos)) {	
		$options = " * "; 	
	}else{
		# count campos set 
		if (is_array($campos)){
			$options = implode(",", $campos); 
		}
	}

	$where = " 1 = 1";
	
	#validate if $filter contain
	
	if(isset($filtro['id_user'])){ $where .= " AND id_user = {$filtro['id_user ']} "; } 
	if(isset($filtro['name_user'])){ $where .= " AND name_user = '{$filtro['name_user']}' "; } 
	if(isset($filtro['surname_user'])){ $where .= " AND surname_user = '{$filtro['surname_user']}' "; } 
	if(isset($filtro['email_user'])){ $where .= " AND email_user = '{$filtro['email_user']}' "; } 
	if(isset($filtro['username_login'])){ $where .= " AND username_login = '{$filtro['username_login']}' "; } 
	if(isset($filtro['password_login'])){ $where .= " AND password_login = '{$filtro['password_login']}' "; } 
	if(isset($filtro['id_type_user'])){ $where .= " AND id_type_user = '{$filtro['id_type_user']}' "; } 
	
	$sql = " SELECT	$options FROM users_register WHERE $where";
	
	// Call poiter to connect 
	$db = new Database();
	
	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	if(isset($data) AND count($data)>0){
		return $data;
	}
	return FALSE;
}

/*
 *	Function to Insert info into categoriaprodutc
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	idcategoria, desc_categoria
 *  Return
 * 			boolean: True if save ok or False
 */
 /*
function put_categoriaproduct($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO categoriaproduct $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}*/

/*
 *	Function to Insert info into produtc
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	idproduct, desc_product, precio_product, idcategoria
 *  Return
 * 			boolean: True if save ok or False
 */
 
function putProduct($data = null){
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		//$options = implode(",", $datos);  	
		if(isset($data['product'])){ $options .= " '{$data['product']}', "; }
		if(isset($data['desc_product'])){ $options .= " '{$data['desc_product']}', "; }
		if(isset($data['precio_product'])){ $options .= " {$data['precio_product']}, "; }
		if(isset($data['type_publish'])){ $options .= " '{$data['type_publish']}', "; }
		if(isset($data['idcategoria'])){ $options .= " {$data['idcategoria']}, "; }
		if(isset($data['folderproduct'])){ $options .= " '{$data['folderproduct']}'"; }
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(", ", array_keys($data));
		
	$sql = "INSERT INTO product ($campos) VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;

}

/*
 * 
*/
function setPhotoProduct($id=null,$data=null){
	if(!isset($id)){ return FALSE; }elseif(is_array($id)){ $idp = $id[0]['idproduct']; }
	if(!isset($data)){ return FALSE; }
	
	$sql = "INSERT INTO productphoto (idproduct,photoname) VALUES ({$idp}, '{$data}'); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}


/*
 * 
*/
function setPhotos($id=null,$data=null){
	if(!isset($id)){ return FALSE; }elseif(is_array($id)){ $idp = $id[0]['idphoto']; }
	if(!isset($data)){ return FALSE; }
	
	$sql = "INSERT INTO photodata (idphoto,photoname) VALUES ({$idp}, '{$data}'); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

//
function getPhotProduct($id=null){	

	$where = " 1 = 1";

	if(isset($id)){ $where .= " AND idproduct = {$id['idproduct']} "; } 
	
	$sql = "SELECT photoname FROM productphoto WHERE $where; ";
	
	// Call poiter to connect 
	$db = new Database();
	
	$db->query($sql);

	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	if(isset($data) AND count($data)>0){
		return $data;
	}
	return FALSE;
}

/*
 *	Function to Insert info into produtc
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	idproduct, desc_product, precio_product, idcategoria
 *  Return
 * 			boolean: True if save ok or False
 */
 
function putPhotos($data = null){
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		//$options = implode(",", $datos);  	
		if(isset($data['model'])){ $options .= " '{$data['model']}', "; }
		if(isset($data['photograph'])){ $options .= " '{$data['photograph']}', "; }
		if(isset($data['photofolder'])){ $options .= " '{$data['photofolder']}',"; }
		if(isset($data['photodata'])){ $options .= " '{$data['photodata']}', "; }
		if(isset($data['idcategoria'])){ $options .= " {$data['idcategoria']} "; }
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(", ", array_keys($data));
		
	$sql = "INSERT INTO photos ($campos) VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;

}

/*
 *	Function to Insert info into estados_factura
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	estado_factura, estado, desc_estado
 *  Return
 * 			boolean: True if save ok or False
 */
 

function put_estados_factura($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO estados_factura $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into factdetalle
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	iddetallefact, numberfact, idproduct, cantidad, detallefact, valordetalle, id_fact
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_factdetalle($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO factdetalle $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into factura
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_fact, numberfact, fechafact, codcliente, estado_factura
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_factura($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO factura $campos VALUES ($options); "; 
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into socialmedia
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	idsocial, socialnet, iconsocial, urliconmedia
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_socialmedia($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO socialmedia $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into socialmedia_details
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	idsocialdetail, urlsocialmedia, idsocial
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_socialmedia_details($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO socialmedia_details $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into stats_day
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_day, day, user, view
 *  Return
 * 			boolean: True if save ok or False
 */

function put_stats_day($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO stats_day $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into stats_ips
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_ips, ip, time, online
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_stats_ips($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO stats_ips $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into stats_keywords
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_stats_keywords($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO stats_keyword $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into stats_language
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_lang, day, language, view
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_stats_language($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO stats_language $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into stats_page
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_page, day, page, view
 *  Return
 * 			boolean: True if save ok or False
 */

function put_stats_page($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO stats_page $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into stats_referer
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_referer, day, referer, view
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_stats_referer($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO stats_referer $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into type_users
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_type, type_user
 *  Return
 * 			boolean: True if save ok or False
 */

function put_type_users($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO type_users $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into users_register
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	id_user, name_user, surname_user, email_user, username_login, password_login, id_type_user
 *  Return
 * 			boolean: True if save ok or False
 */
 
function put_users_register($datos = null)
{
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($datos) && is_array($datos)) {	
		$options = implode(",", $datos);  	
	}else{
		return null;
	}

	# obtains the keys of array 
	$campos = implode(",", array_keys($datos));
		
	$sql = "INSERT INTO users_register $campos VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 * Funtions to Upload data information 
 */

/*
 *	Function to Insert info into news
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	title, autor, news, type_publish, date, idcategory
 *  Return
 * 			boolean: True if save ok or False
 */

function setNews($data = null){
	$options = '';
	$campos = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		//$options = implode(",", $data);
		if(isset($data['title'])){ $options .= " '{$data['title']}', "; }
		if(isset($data['autor'])){ $options .= " '{$data['autor']}', "; }
		if(isset($data['news'])){ $options .= " '{$data['news']}', "; }
		if(isset($data['type_publish'])){ $options .= " '{$data['type_publish']}', "; }
		if(isset($data['date'])){ $options .= " Now(),"; }
		if(isset($data['category'])){ $options .= " {$data['category']}"; }
	}else{
		return FALSE;
	}
	
	# obtains the keys of array 
	$campos = implode(",", array_keys($data));
	
	$sql = "INSERT INTO news ($campos) VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to Insert info into categorianews
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	category
 *  Return
 * 			boolean: True if save ok or False
 */

function setCatNews($data){
	$options = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		$options = implode(",", $data);  	
	}else{
		return FALSE;
	}
	
	$sql = "INSERT INTO categorianews (categoria) VALUES ('$options'); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to return all the data from categorianews
 * 	Params
 * 		NONE
 *	
 *  Return
 * 		$data (array): Contain result of query
 */
 
function getCateNews(){
	$data = array();
	
	$sql = "SELECT * FROM categorianews;";
	
	$db = new Database();
	$db->query($sql);
	//$data = $db->fetchAssoc();
	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	if(isset($data) AND count($data)>0){
		return $data;
	}
	return FALSE;
}

/*
 *	Function to update the data with the keywors in categorianews 
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 		boolean: True if save ok or False
 */

function alterCatNews($data){
	$id = null;
	$categ = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		$id = $data['idcategoria'];
		$categ = $data['category'];  	
	}else{
		return FALSE;
	}
	
	$sql = "UPDATE categorianews SET categoria = '{$categ}' WHERE idcategoria = {$id}; ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to return the data with the keywors in stats 
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 		$data (array): Contain result of query
 */

function deleteCatNews($data){
	if (isset($data) && is_array($data)) {
		$id = $data['idcategoria'];
	}else{
		return FALSE;
	}
	
	$sql = "DELETE FROM categorianews WHERE idcategoria = {$id};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}


/*
 *	Function to Insert info into categorianews
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	category
 *  Return
 * 			boolean: True if save ok or False
 */

function setPhotoCat($data){
	$options = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		$options = implode(",", $data);  	
	}else{
		return FALSE;
	}
	
	$sql = "INSERT INTO categoriaphotos (categoria) VALUES ('$options'); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to return all the data from categorianews
 * 	Params
 * 		NONE
 *	
 *  Return
 * 		$data (array): Contain result of query
 */
 
function getCatePhoto(){
	$data = array();
	
	$sql = "SELECT * FROM categoriaphotos;";
	
	$db = new Database();
	$db->query($sql);
	//$data = $db->fetchAssoc();
	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	if(isset($data) AND count($data)>0){
		return $data;
	}
	return FALSE;
}

/*
 *	Function to update the data with the keywors in categoriaphotos 
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 		boolean: True if save ok or False
 */

function alterCatPhoto($data){
	$id = null;
	$categ = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		$id = $data['idcategoria'];
		$categ = $data['category'];  	
	}else{
		return FALSE;
	}
	
	$sql = "UPDATE categoriaphotos SET categoria = '{$categ}' WHERE idcategoria = {$id}; ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to delete categories
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 		$data (array): Contain result of query
 */

function deleteCatPhoto($data){
	if (isset($data) && is_array($data)) {
		$id = $data['idcategoria'];
	}else{
		return FALSE;
	}
	
	$sql = "DELETE FROM categoriaphotos WHERE idcategoria = {$id};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}


/*
 *	Function to Insert info into categorianews
 * 	Params
 *		$datos (array): Contain clausules of datos on query Variables in array
 *						- 	category
 *  Return
 * 			boolean: True if save ok or False
 */

function setProductCat($data){
	$options = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		$options = implode(",", $data);  	
	}else{
		return FALSE;
	}
	
	$sql = "INSERT INTO categoriaproduct (categoria) VALUES ('$options'); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

function setUser($data){
	$options = null;
	$campos = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		//$options = implode(",", $datos);  	
		if(isset($data['name_user'])){ $options .= " '{$data['name_user']}', "; }
		if(isset($data['surname_user'])){ $options .= " '{$data['surname_user']}', "; }
		if(isset($data['email_user'])){ $options .= " '{$data['email_user']}', "; }
		if(isset($data['phonenumber'])){ $options .= " '{$data['phonenumber']}', "; }
		if(isset($data['username_login'])){ $options .= " '{$data['username_login']}', "; }
		if(isset($data['password_login'])){ $options .= " '{$data['password_login']}', "; }
		if(isset($data['id_type_user'])){ $options .= " '{$data['id_type_user']}', "; }
		if(isset($data['dt_register'])){ $options .= " '{$data['dt_register']}' "; }
	}else{
		return null;
	}
//date("Y-m-d H:i:s")
	$campos = implode(", ", array_keys($data));
		
	$sql = "INSERT INTO users_register ($campos) VALUES ($options); ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}


/*
 *	Function to return all the data from categorianews
 * 	Params
 * 		NONE
 *	
 *  Return
 * 		$data (array): Contain result of query
 */
 
function getCateProduct(){
	$data = array();
	
	$sql = "SELECT * FROM categoriaproduct;";
	
	$db = new Database();
	$db->query($sql);
	//$data = $db->fetchAssoc();
	while($row = $db->fetchAssoc())
	{
		$data[] = $row;
	}
	$db->close();
	if(isset($data) AND count($data)>0){
		return $data;
	}
	return FALSE;
}

/*
 *	Function to update the data with the keywors in categoriaproducts 
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 		boolean: True if save ok or False
 */

function alterCatProduct($data){
	$id = null;
	$categ = null;
	#validate if $options is empty
	if(isset($data) && is_array($data)) {	
		$id = $data['idcategoria'];
		$categ = $data['category'];  	
	}else{
		return FALSE;
	}
	
	$sql = "UPDATE categoriaproduct SET categoria = '{$categ}' WHERE idcategoria = {$id}; ";
	
	// Call poiter to connect 
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}

/*
 *	Function to delete categories
 * 	Params
 * 		$options (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *		$filtro (array): Contain clausules of filter on query Variables in array
 *						- 	id_key, day, keyword, view
 *  Return
 * 		$data (array): Contain result of query
 */

function deleteCatProduct($data){
	if (isset($data) && is_array($data)) {
		$id = $data['idcategoria'];
	}else{
		return FALSE;
	}
	
	$sql = "DELETE FROM categoriaproduct WHERE idcategoria = {$id};";
	
	//Call pointer to connect
	$db = new Database();
	$db->query($sql);
	$db->close();
	return TRUE;
}


?>