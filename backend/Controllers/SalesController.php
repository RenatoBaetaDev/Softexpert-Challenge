<?php
    require(__DIR__ . "/../Repository/SalesRepository.php");

    class SalesController extends BaseController {

        private $repository;

        public function __construct() {
            $this->repository = new SalesRepository();
        }

        public function get() {
            $sales = $this->repository->get();

            if (!$sales) {
                $message = "No sales found";
                $code = 400;
            };

            $message = "Success";
            $code = 200;

            return $this->response($code, $message, $sales);
        }


        public function create() {
            $jsonPOST = json_decode(file_get_contents('php://input'), true);

            $newSale = $this->repository->create($jsonPOST);

            if (!$newSale) {
                $message = "Error trying to create a new sale";
                $code = 400;
            };

            $message = "Success";
            $code = 200;

            return $this->response($code, $message, $newSale);
        }
    }