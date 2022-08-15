<?php
    require(__DIR__ . "/../Repository/CategoriesRepository.php");

    class CategoriesController extends BaseController {

        private $repository;

        public function __construct() {
            $this->repository = new CategoriesRepository();
        }

        public function get() {
            $categories = $this->repository->get();

            if (!$categories) {
                $message = "No categories found";
                $code = 400;
            };

            $message = "Success";
            $code = 200;

            return $this->response($code, $message, $categories);
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

            $delete = $this->repository->deleteCategory($params);

            if (!$delete) {
                $message = "Error trying to delete category";
                $code = 400;
            };

            $message = "Success";
            $code = 200;

            return $this->response($code, $message, null);
        }
    }