<?php

interface ICustomerTojson
{
    public function getJson();
    public function getError();
    public function execute();
}