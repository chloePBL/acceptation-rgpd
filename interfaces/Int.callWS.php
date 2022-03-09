<?php

interface ICallWS
{
    public function execute($sJsonExecute);
    public function getJson();
    public function getError();
}