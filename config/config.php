<?php
/**
 * Created by PhpStorm.
 * User: poste1
 * Date: 12/12/2017
 * Time: 11:41
 */
$url = 'http://localhost:8080/inventory';

function import($database_columns,$file_columns,$file) {

    if (isset($_REQUEST['upload'])) {
        $ok = true;
        $file = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file, "r");
        if ($file == NULL) {
            error(_('Please select a file to import'));
            //redirect(page_link_to('admin_export'));
        }
        else {
            while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
            {
                for($c=0;$c<count($database_columns);$c++){
                    $database_column=$database_columns[$c];
                    //$file_column=$file_columns[$c];
                    $database_column=sql_escape($filesop[$c]);
                }
                $nick_name = $filesop[0];
                $first_name = $filesop[1];
                $last_name = $filesop[2];
                $email = $filesop[3];
                $age = $filesop[4];
                $current_city = $filesop[5];
                $password = $filesop[6];
                $mobile = $filesop[7];

                // If the tests pass we can insert it into the database.
                if ($ok) {
                    $sql = sql_query("
            INSERT INTO `User` SET
            `Nick Name`='" . sql_escape($nick_name) . "',
            `First Name`='" . sql_escape($first_name) . "',
            `Last Name`='" . sql_escape($last_name) . "',
            `email`='" . sql_escape($email) . "',
            `Age`='" . sql_escape($age) . "',
            `current_city`='" . sql_escape($current_city) . "',
            `Password`='" . sql_escape($password) . "',
             `mobile`='" . sql_escape($mobile) . "',");
                }
            }

            if ($sql) {
                success(_("You database has imported successfully!"));
                redirect(page_link_to('admin_export'));
            } else {
                error(_('Sorry! There is some problem in the import file.'));
                redirect(page_link_to('admin_export'));
            }
        }
    }
//form_submit($name, $label) Renders the submit button of a form
//form_file($name, $label) Renders a form file box

    return page_with_title("Import Data", array(
        msg(),
        div('row', array(
            div('col-md-12', array(
                form(array(
                    form_file('csv_file', _("Import user data from a csv file")),
                    form_submit('upload', _("Import"))
                ))
            ))
        ))
    ));
}
