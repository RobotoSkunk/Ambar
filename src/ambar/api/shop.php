<?php
$data = [
	'result' => -1,
	'message' => "No data"
];

if (isset($_GET['action'])) {
	try {
		require_once('../database.php');

		switch ($_GET['action']) {
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
				$extraSQL = isset($_GET['category-id']) ? 'AND products.cid = ?' : '';

				$stmt = $conn->prepare("SELECT products.id, products.p_name, products.price, presentation.picture
				FROM products JOIN presentation WHERE products.id = presentation.pid $extraSQL;");
				if (isset($_GET['category-id'])) $stmt->bind_param('i', $_GET['category-id']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($cid, $cname);
				
				$stmt->close();
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
