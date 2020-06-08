<?php

class Helyszin {

    private $telepules;
    private $elso;
    private $masodik;
    private $harmadik;
    function __construct($telepules, $elso, $masodik, $harmadik) {
        $this->telepules = $telepules;
        $this->elso = $elso;
        $this->masodik = $masodik;
        $this->harmadik = $harmadik;
    }
    function getTelepules() {
        return $this->telepules;
    }

    function getElso() {
        return $this->elso;
    }

    function getMasodik() {
        return $this->masodik;
    }

    function getHarmadik() {
        return $this->harmadik;
    }

    function setTelepules($telepules): void {
        $this->telepules = $telepules;
    }

    function setElso($elso): void {
        $this->elso = $elso;
    }

    function setMasodik($masodik): void {
        $this->masodik = $masodik;
    }

    function setHarmadik($harmadik): void {
        $this->harmadik = $harmadik;
    }


}
