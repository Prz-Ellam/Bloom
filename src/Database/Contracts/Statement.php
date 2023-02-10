<?php

namespace Bloom\Database\Contracts;

interface Statement {
    public function bindColumn();
    public function bindParam();
    public function bindValue();
    public function fetch();
    public function fetchAll();
    public function rowCount();
    public function execute();
}
