<?php

namespace App\Controllers;

use App\Models\Productos;
use Core\Controller;

class ApiController extends Controller
{
	private function jsonResponse($data, int $status = 200): void
	{
		http_response_code($status);
		header("Content-Type: application/json");
		echo json_encode($data);
	}

	public function productos(): void
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
			$this->jsonResponse(["error" => "Method Not Allowed"], 405);
			return;
		}

		$productos = Productos::getAll();
		$this->jsonResponse($productos);
	}

	public function producto(?int $id = null): void
	{
		switch ($_SERVER['REQUEST_METHOD']) {

			case 'GET':
				if ($id === null) {
					$this->jsonResponse(["error" => "Product ID required"], 400);
					return;
				}

				$producto = Productos::getById($id);
				if (!$producto) {
					$this->jsonResponse(["error" => "Product not found"], 404);
					return;
				}

				$this->jsonResponse($producto);
				break;

			case 'POST':
				$data = json_decode(file_get_contents("php://input"), true);

				if (!isset($data['nombre'], $data['cantidad'])) {
					$this->jsonResponse(["error" => "Invalid data"], 400);
					return;
				}

				$producto = new Productos(
					null,
					$data['nombre'],
					(int)$data['cantidad']
				);

				if (Productos::create($producto)) {
					$this->jsonResponse(["message" => "Product created", "id" => $producto->getId()], 201);
				} else {
					$this->jsonResponse(["error" => "Create failed"], 500);
				}
				break;

			case 'PUT':
				if ($id === null) {
					$this->jsonResponse(["error" => "Product ID required"], 400);
					return;
				}

				$data = json_decode(file_get_contents("php://input"), true);

				if (!isset($data['nombre'], $data['cantidad'])) {
					$this->jsonResponse(["error" => "Invalid data"], 400);
					return;
				}

				$producto = new Productos(
					$id,
					$data['nombre'],
					(int)$data['cantidad']
				);

				if (Productos::update($producto)) {
					$this->jsonResponse(["message" => "Product updated"]);
				} else {
					$this->jsonResponse(["error" => "Update failed"], 500);
				}
				break;

			case 'DELETE':
				if ($id === null) {
					$this->jsonResponse(["error" => "Product ID required"], 400);
					return;
				}

				if (Productos::delete($id)) {
					$this->jsonResponse(["message" => "Product deleted"]);
				} else {
					$this->jsonResponse(["error" => "Delete failed"], 500);
				}
				break;

			default:
				$this->jsonResponse(["error" => "Method Not Allowed"], 405);
		}
	}
}