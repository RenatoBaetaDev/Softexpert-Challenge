<?php
    require(__DIR__ . "/../Repository/TaxesRepository.php");

    class TaxesController extends BaseController {

        private $repository;

        public function __construct() {
            $this->repository = new TaxesRepository();
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
    }