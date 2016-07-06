<?php
$page = $_GET['page'] != null ? $_GET['page'] : 1;
$productList = $api->getProductList($page);
$nextPageClass = $productList->next_page != null ? 'next' : 'next disabled';
$prevPageClass = $productList->previous_page != null ? 'previous' : 'previous disabled';
?>
<h1>Product List</h1>
<?php include 'pager.php'; ?>
<table class='table table-striped'>
	<thead>
		<tr>
			<th>Id</th>
			<th>Item Name</th>
			<th>Item Number</th>
			<th>Price</th>
		</tr>
	</thead>
	<tbody>
		<?php for($i = 0; $i < count($productList->products); $i++) { ?>
			<?php $product = $productList->products[$i]; ?>
			<tr>
				<td><?= $product->id ?></td>
				<td><?= $product->item_name ?></td>
				<td><?= $product->item_number ?></td>
				<td><?= $product->price ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?php include 'pager.php'; ?>