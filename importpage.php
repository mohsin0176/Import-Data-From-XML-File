<?php

include"database.php";

if (isset($_POST['buttonImport'])) 
{
	copy($_FILES['xmlFile']['tmp_name'],
'data/'.$_FILES['xmlFile']['name']);
	$products=simplexml_load_file('data/'.$_FILES['xmlFile']['name']);
	foreach ($products as $product) 
	{
		$stmt=$con->prepare("INSERT INTO product (id,name,price,quantity)
			VALUES(:id,:name,:price,:quantity)");
		$stmt->bindValue('id',$product->id);
		$stmt->bindValue('name',$product->name);
		$stmt->bindValue('price',$product->price);
		$stmt->bindValue('quantity',$product->quantity);
		$stmt->execute();
	}
}

$stmt=$con->prepare("SELECT *FROM product");
$stmt->execute();

?>

<form method="POST" enctype="multipart/form-data">
	XML FILE<input type="FILE" name="xmlFile">
	<br>
	<input type="submit"  value="Import" name="buttonImport">
</form>

<br>
<h3>Product List</h3>
<table cellpadding="2" cellspacing="2" border="1">
	<tr>
		<th>ID</th>
		<th>NAME</th>
		<th>PRICE</th>
		<th>QUANTITY</th>
	</tr>
	<?php while ($product=$stmt->fetch(PDO::FETCH_OBJ)) { ?>
    
    <tr>
    	<td><?php echo $product->id;  ?></td>
    	<td><?php echo $product->name;  ?></td>
    	<td><?php echo $product->price;  ?></td>
    	<td><?php echo $product->quantity;  ?></td>
    </tr>
		 
	<?php } ?>
</table>