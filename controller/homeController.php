<?php
session_start();

require ("model/Model.php");
include ("config/config.php");


class homeController
{
    public function  actionIndex(){


        if (!isset($_SESSION["login"])) {
            header("Location:login.php?error=e");
        }
        $product= model::create('Product');

        $sims=array();
        $sims= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='0' and m.category_id=2" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $boitiers= array();
        $boitiers= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='0' and m.category_id=1" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $boitiersbloqs= array();
        $boitiersbloqs= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='3' and m.category_id=1" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $simsbloqs= array();
        $simsbloqs= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='3' and m.category_id=2" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $simsopentech= array();
        $simsopentech= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='1' and m.category_id=2" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $boitiersopentech= array();
        $boitiersopentech= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='1' and m.category_id=1" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $simspersonel= array();
        $simspersonel= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='2' and m.category_id=2" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $boitierspersonel= array();
        $boitierspersonel= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='2' and m.category_id=1" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        require 'view/home/index.php';

         }



}