<?php
$data = [
	'result' => -1,
	'message' => "No data"
];

if (isset($_POST['action'])) {
	try {
		require_once('../database.php');

		switch ($_POST['action']) {
			case 'load-categories':
				$categories = [];

				$stmt = $conn->prepare('SELECT id, c_name FROM parent_category;');
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cid, $cname);
				while ($stmt->fetch()) {
					$content = [];

					$stmt1 = $conn->prepare('SELECT id, c_name FROM categories WHERE parent = ?;');
					$stmt1->bind_param('i', $cid);
					$stmt1->execute();
					$stmt1->store_result();
					$stmt1->bind_result($ccid, $ccname);
					while ($stmt1->fetch()) {
						array_push($content, [
							"id" => $ccid,
							"name" => $ccname,
						]);
					}
					$stmt1->close();

					array_push($categories, [
						"name" => $cname,
						"childs" => $content
					]);
				}
				$stmt->close();

				$nullContent = [];

				$stmt2 = $conn->prepare('SELECT id, c_name FROM categories WHERE parent IS NULL;');
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result($ccid, $ccname);
				while ($stmt2->fetch()) {
					array_push($nullContent, [
						"id" => $ccid,
						"name" => $ccname,
					]);
				}
				$stmt2->close();
				array_push($categories, [
					"name" => "NULL",
					"childs" => $nullContent
				]);

				$data['result'] = 0;
				$data['message'] = '';
				$data['categories'] = $categories;
				break;
			case 'load-posts':
				$extraSQL = isset($_POST['category-id']) ? 'AND products.cid = ?' : '';
				$posts = [];

				$stmt = $conn->prepare("SELECT products.id, products.p_name, products.price, presentation.picture
					FROM products JOIN presentation WHERE products.id = presentation.pid $extraSQL;");
				if (isset($_POST['category-id'])) $stmt->bind_param('i', $_POST['category-id']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($pid, $pname, $price, $picture);
				while ($stmt->fetch()) {
					array_push($posts, [
						"id" => $pid,
						"name" => $pname,
						"price" => $price,
						"picture" => $picture
					]);
				}
				$stmt->close();

				$data['posts'] = $posts;
				break;
			case 'load-post':
				$posts = [];
/*
CREATE TABLE products (
	id INT AUTO_INCREMENT,
	cid INT NOT NULL,
	proid INT NOT NULL,
	p_name VARCHAR(30) NOT NULL,
	price INT NOT NULL,
	p_desc LONGTEXT NOT NULL,
	stock INT NOT NULL,
	
	PRIMARY KEY (id),
	FOREIGN KEY (cid) REFERENCES categories (id),
	FOREIGN KEY (proid) REFERENCES producers (id)
);*/
				$stmt = $conn->prepare("SELECT cid, proid, p_name, price, p_desc, stock FROM products WHERE id = ?;");
				if (isset($_POST['category-id'])) $stmt->bind_param('i', $_POST['category-id']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($pid, $pname, $price, $picture);
				while ($stmt->fetch()) {
					array_push($posts, [
						"id" => $pid,
						"name" => $pname,
						"price" => $price,
						"picture" => $picture
					]);
				}
				$stmt->close();

				$data['posts'] = $posts;
				break;
			default:
				$data['message'] = "Invalid action.";
				break;
		}
	} catch (Throwable $err) {
		$data['message'] = "Unexpected error, code {$err->getLine()}.";
	}
}

header("Content-Type: application/json;");
echo json_encode($data, JSON_PRETTY_PRINT);
