<?php
    require(__DIR__ . "/../Repository/ProductsRepository.php");

    class ProductsController extends BaseController {

        private $repository;

        public function __construct() {
            $this->repository = new ProductsRepository();
        }

        public function get() {
            $products = $this->repository->get();

            if (!$products) {
                $message = "No products found";
                $code = 400;
            };

            $message = "Success";
            $code = 200;

            return $this->response($code, $message, $products);
        }


        public function create() {
            $jsonPOST = json_decode(file_get_contents('php://input'), true);

            $newCategory = $this->repository->create($jsonPOST);

            if (!$newCategory) {
                $message = "Error trying to create a new category";
                $code = 400;
            };

            $message = "Success";
            $code = 200;

            return $this->response($code, $message, $newCategory);
        }

        public function delete($params) {

            if (!is_numeric($params)) {
                $message = "Please provide a valid id";
                $code = 400;
                return $this->response($code, $message, null);

            }

            $delete = $this->repository->deleteProduct($params);

            if (!$delete) {
                $message = "Error trying to delete category";
                $code = 400;
            };

            $message = "Success";
            $code = 200;

            return $this->response($code, $message, null);
        }
    }