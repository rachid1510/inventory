<?php



class DetailsInstallation extends Model
{
    //
    public function __construct()
    {
        parent::__construct('details_installations');
    }

    /*
     * insert box
     */
    public function insertBox($box,$product,$installation_id,$personal_id,$detail_installation,$inventory_personl,$CostumerProduct,$gsm_product_costumer,$operateur_product_costumer)
    {
        $result=true;

        //change of the box
        /*
         * installation is change of the box
         */
        $databoitier = array("product_id" => $box, "installation_id" => $installation_id);
        /*
        * save detail installation
        */
        if($detail_installation->save($databoitier)==0)
        {
            $result=false;
        }

        $inventory_personal_data = $inventory_personl->find(array('conditions' => 'product_id =' . $box . ' and personal_id=' . $personal_id));
        $data_inventory_perso = array("id" => $inventory_personal_data[0]['id'], "status" => '0');
        $data_product = array("id" => $inventory_personal_data[0]['product_id'], "status" => '0');
        /*
            * update status of product on product's table and personal's inventory
            */
        if($result==true) {
            if ($inventory_personl->save($data_inventory_perso) == 0 or $product->save($data_product) == 0) {
                $result = false;
            }
        }
        if(isset($gsm_product_costumer) and !empty($gsm_product_costumer)) {


            $costumer_products = array('imei_product' => $gsm_product_costumer, 'provider' => $operateur_product_costumer, 'installation_id' => $installation_id);
            if ($result == true) {
                if ($CostumerProduct->save($costumer_products)== 0) {
                    $result = false;
                }
            }
        }
        return $result;
    }
    /*
     * insert sim
     */
    public function insertCard($card,$product,$installation_id,$personal_id,$detail_installation,$inventory_personl,$CostumerProduct,$imei_product_costumer,$provider_product_costumer)
    {
        $result=true;

        /*
         * installation is change of the card
         */
        $datasim = array("product_id" => $card, "installation_id" => $installation_id);
        /*
         * save detail installation
         */
        if($detail_installation->save($datasim)==0){
            $result=false;
        }
        /*
        * get inventory personl id
        */
        $inventory_personal_data = $inventory_personl->find(array('conditions' => 'product_id =' . $card . ' and personal_id=' . $personal_id));
        $data_inventory_perso = array("id" => $inventory_personal_data[0]['id'], "status" => '0');
        $data_product = array("id" => $inventory_personal_data[0]['product_id'], "status" => '0');
        /*
        * update status of product on product's table and personal's inventory
        */
        if($result) {
            if ($inventory_personl->save($data_inventory_perso)==0 or $product->save($data_product)== 0) {
                $result = false;
            }
        }

        /*
         * data product's costumer
         */
        if(isset($imei_product_costumer) and !empty($imei_product_costumer)) {

            $costumer_products = array('imei_product' => $imei_product_costumer, 'provider' => $provider_product_costumer, 'installation_id' => $installation_id);
            if ($result) {
                if ($CostumerProduct->save($costumer_products) == 0) {
                    $result = false;
                }
            }
        }
        return $result;
    }

}
