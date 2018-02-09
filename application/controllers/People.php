<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTE:  Be very careful when looking at examples of Datatables on the internet that you're looking at examples of Datatables 1.10 or above
// There are many many examples from older versions.  Older examples may work with modification to the new syntax.

// See CodeIgniter Server-side DataTables project: http://mbahcoding.com/tutorial/php/codeigniter/codeigniter-simple-server-side-datatable-example.html

class People extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        $this->load->model('PeopleModel', 'people');

        // If you're using more than one table in your model(with alias prefixes ex. "LIC.LAST_NAME"), you can't simply copy the column_search as I've done here.
        // You'll need to create a new array without prefixes ex. $db_data['FIELD'] = array('LASTNAME', 'FIRSTNAME', 'MIDDLENAME');

        //Normally this line would simply copy the existing column_search array, but if you're using multiple tables and aliases, you can't do that.
        //$db_data['FIELD'] = $this->PeopleModel->column_search;

        $db_data['FIELD'] = array('PERSON_ID', 'LAST_NAME', 'FIRST_NAME', 'PHONE_NUMBER', 'EMAIL');


        $this->session->set_userdata($db_data);

        // If your query fails, try raising the memory limit.  Don't use above what you need though and don't get ridiculous.
        // ini_set('memory_limit','400M');

    }

    public function index()
    {

        $this->load->helper('url');

        //$this->load->view('PeopleModel_v', $this->data);
        $this->load->view('people_v');

    }

    // The code in this function is an example of how serverside processing must be formatted for Datatables.
    // See source for this at: http://mbahcoding.com/tutorial/php/codeigniter/codeigniter-simple-server-side-datatable-example.html
    public function ajax_list()
    {
        $list = $this->people->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $people) {
            $no++;
            $row = array();


            for ($i = 0; $i < count($_SESSION['FIELD']); ++$i) {

                $field_name = '';
                $field_name = strtoupper($_SESSION['FIELD'][$i]);
                $row[] = $people->$field_name;

            }

            $data[] = $row;
        }

        $output = array(

            // Adding filter values here for controls on view page  see Usage - Server example at http://yadcf-showcase.appspot.com/server_side_source.html
            // When using YADCF with server-side processing, you have to add the values for header filter controls from the server side.
            /* "yadcf_data_2" => ["Analyst", "Clerk", "Manager", "Salesman"],
            "yadcf_data_5" => ["1", "2", "3", "4", "5", "6"],
            "yadcf_data_9" => ["1", "2"],  */
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->people->count_all(),
            "recordsFiltered" => $this->people->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function getData()
    {
        //$data_get['profileId'] =  $this->uri->segment(5);
        //$data_get['appType'] = $this->uri->segment(6);


        //test change...
        $this->output->set_content_type('application/json');

        $data['aaData'] = $this->people->getData();

        $this->output
            ->set_content_type('application/json')//set Json header
            ->set_output(json_encode($data));// make output json encoded

        return $data;


    }


}
