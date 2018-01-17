<?php



class Installation extends Model
{
    //
    public function __construct()
    {
        parent::__construct('installations');
    }
    public function insertInstallation($personal_id,$selected_vehicle,$date_installation,$new_vehicle,$costumer_id,$observation,$installation)
    {

        $status="Completed";

        if (!empty($new_vehicle)) {
            $vehicle = Model::create('Vehicle');
            $data = array("imei" => $new_vehicle, "costumer_id" => $costumer_id, "user_id" => $_SESSION['user_id']);
            $vec = $vehicle->save($data);
            if ($vec > 0) {
                $selected_vehicle = $vec;
            }

        }
        /*
        * prepare data to insert in installation table
         */
        $data = array("status" => $status, "personal_id" => $personal_id, "vehicle_id" => $selected_vehicle, "user_id" => $_SESSION['user_id'], "installed_at" => $date_installation,"observation"=>$observation);
        /*
         * call function to save installation and get lastinsert id in var $installation_id
         */
        $installation_id = $installation->save($data);
        return $installation_id;

    }
}
