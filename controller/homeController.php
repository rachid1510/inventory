<?php
/**
 * Created by PhpStorm.
 * User: post2
 * Date: 28/12/2017
 * Time: 15:20
 */
session_start();

require ("model/Model.php");
include ("config/config.php");

class homeController
{
    public function  actionIndex(){


        if (!isset($_SESSION["login"])) {
            header("Location:login.php?error=e");
        }
        $sims=array();
        $product= model::create('Product');
        $sims= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='0' and m.category_id=2" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $boitiers= array();
        $boitiers= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='0' and m.category_id=1" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $boitiersbloqs= array();
        $boitiersbloqs= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='' and m.category_id=1" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));

        $simsbloqs= array();
        $simsbloqs= $product->findFromRelation("products p,movements m","p.movement_id=m.id and p.status='3' and m.category_id=2" ,array("fields"=>"COUNT(*) nombre","groupBy"=>"m.category_id"));


        require 'view/home/index.php';

         }
}