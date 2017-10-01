<?php
	require('connection.php');

	function return_all()
	{
		$connection = connect_db();
		$result = $connection->query( "SELECT * FROM `users`" );
		return $result;
	}

	function login($email){
		$connection = connect_db();
		$stmt = $connection->prepare("SELECT * FROM `users` WHERE `email` = ? LIMIT 1");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$connection->close();
		return $result;
	}

	function create ($permission, $name, $email, $password)
	{
		$connection = connect_db();
		$stmt = $connection->prepare( "INSERT INTO `users` (`permission`, `name`, `email`, `password` ) VALUES ( ?, ?, ?, ? )" );
		$stmt->bind_param('ssss', $permission, $name, $email, $password);
		$stmt->execute();
		$stmt->close();
		$connection->close();
	}

	function update($permission, $name, $email, $password, $id)
	{
		$connection = connect_db();
		$stmt = $connection->prepare( "UPDATE `users` SET `permission`= ?, `name` = ?, `email` = ?, `password` = ? WHERE `id` = ? LIMIT 1" );
		$stmt->bind_param('ssssi', $permission, $name, $email, $password, $id);
		$stmt->execute();
		$stmt->close();
		$connection->close();	
	}

	function show($id)
	{
		$connection = connect_db();
		$stmt = $connection->prepare( "SELECT * FROM `users` WHERE `id`= ? LIMIT 1" );
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
		$stmt = $connection->prepare("DELETE FROM `users` WHERE `id` = ? LIMIT 1");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->close();
		$connection->close();
	}
?>