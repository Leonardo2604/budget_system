<?php
	require('connection.php');

	function return_all()
	{
		$connection = connect_db();
		$result = $connection->query( "SELECT * FROM `products`" );
		return $result;
	}

	function create ($name, $description, $price, $cash_discount, $labor)
	{
		$connection = connect_db();
		$stmt = $connection->prepare( "INSERT INTO `products` ( `name`, `description`, `price`, `cash_discount`, `labor` ) VALUES ( ?, ?, ?, ?, ? )" );
		$stmt->bind_param('ssdid', $name, $description, $price, $cash_discount, $labor);
		$stmt->execute();
		$stmt->close();
		$connection->close();
	}

	function update($name, $description, $price, $cash_discount, $labor, $id)
	{
		$connection = connect_db();
		$stmt = $connection->prepare( "UPDATE `products` SET `name` = ?, `description` = ?, `price` = ?, `cash_discount` = ?, `labor` = ? WHERE `id` = ? LIMIT 1" );
		$stmt->bind_param('ssdidi', $name, $description, $price, $cash_discount, $labor, $id);
		$stmt->execute();
		$stmt->close();
		$connection->close();	
	}

	function show($id)
	{
		$connection = connect_db();
		$stmt = $connection->prepare( "SELECT * FROM `products` WHERE `id`= ? LIMIT 1" );
		$stmt->bind_param( 'i', $id );
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$connection->close();
		return $result;
	}

	function delete($id)
	{
		$connection = connect_db();	
		$stmt = $connection->prepare("DELETE FROM `products` WHERE `id` = ? LIMIT 1");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->close();
		$connection->close();
	}
?>