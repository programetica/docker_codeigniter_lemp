<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// This was meant to be a model where all where clauses for an application could be built from an array of input variables, but it may get too complex
class Dataprocessing_m extends CI_Model
{


    public function __construct()
    {

        //parent::__construct();

    }

    // TODO test this to make sure there's no conflict when multiple people are running reports.
    // TODO change this for Datatables to create an array instead of Query Builder statements?


    // This function should be modified to customize it for each application.  On a single application level, it's pretty generic.
    public function getWhereClause2()
    {

        $whereVariablesArray = $_SESSION['WHERE_VARIABLES_ARRAY'];

        foreach ($whereVariablesArray as $key => $value) {

            // If there are two values, then it's a date or value range with a from and to value.  Name the range keys appropriately to work with this code.
            if (count($value) == 2) {


                $whereElement = '';

                $whereElement = $key;

                foreach ($value as $key => $value) {


                    if (substr($key, -2) == 'To') {

                        $this->db->where($whereElement . ' <= ', $value, false);

                    }

                    if (substr($key, -4) == 'From') {

                        $this->db->where($whereElement . ' >= ', $value, false);

                    }
                }
                // If it's not a range value...
            } else {

                $whereElement = '';

                $whereElement = $key;

                foreach ($value as $key => $value) {

                    if ($key == 'testType') {


                        if ($value == 'X') {

                            $this->db->where($_SESSION['source_view'] . '.X = \'Y\'');
                            unset($whereVariablesArray[$key]);

                        } elseif ($value == 'Z') {

                            $this->db->where($_SESSION['source_view'] . '.Z = \'Y\'');
                            unset($whereVariablesArray[$key]);

                        } else {


                            if (substr($key, 0, 4) == 'join') {

                                $this->db->where($whereElement . ' = ', $value, false);
                                unset($whereVariablesArray[$key]);


                            } else {

                                $this->db->where($whereElement . ' = ', $value);
                                unset($whereVariablesArray[$key]);

                            }
                        }


                    } else {
                        if ($key <> 'testType') {

                            // THE CODE BELOW MAY CAUSE ISSUES WITH SOME APPLICATIONS
                            $this->db->where(strtoupper($whereElement) . ' = ', strtoupper($value));
                            //$this->db->like(strtoupper($whereElement), strtoupper($value));
                            unset($whereVariablesArray[$key]);

                        }
                    }


                }
            }


        }
    }

}
