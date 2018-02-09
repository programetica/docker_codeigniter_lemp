<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PeopleModel extends CI_Model
{
    // Test
	// Notice that column_search items are individually quoted, unlike Codeigniter's query builder select statement.
	// Always use all upper case, just as with Query Builder.
	var $table = array('docker_codeigniter_lemp.PEOPLE');
	var $column_search = array('PERSON_ID', 'LAST_NAME', 'FIRST_NAME', 'PHONE_NUMBER', 'EMAIL');

	var $order = array('PERSON_ID' => 'desc'); // default order

	public function __construct()
	{
		//parent::__construct();
		$this->load->database();

		// The two lines of code below replace having to repeat the array above.
		$this->column_order = unserialize(serialize($this->column_search));
		$this->column_status = unserialize(serialize($this->column_search));

		//$this->output->enable_profiler(TRUE);

	}
	
	    // Put all your default where clause query stuff here.  It will get called and reset
    public function set_where_clause()
    {
        $this->db->distinct();
        /*$this->db->join('SCOTT.EMPLOYEE E', 'E.EMPNO = PP.EMPNO');
        $this->db->join('PROJECT P', 'P.PROJECTNO = PP.PROJECTNO'); */
       // $this->db->where('E.JOB = \'SALESMAN\'');

    }

	private function _get_datatables_query()
	{
		$this->db->select($this->column_search);
		
		$this->db->from($this->table);
		
		$this->set_where_clause();

		// Limit returns for faster testing.
		// $this->db->limit(1000);

		$i = 0;

		foreach ($this->column_search as $item) // loop column
		{

			// if there's a value in the search item...
			if ($_POST['columns'][$i]['search']['value']) {

				// if there exists a specific string in the value...
				$pos = strpos(($_POST['columns'][$i]['search']['value']), '-yadcf_delim-');

				// This is fixing a bug where Edge browser kept sending a delimiter for date ranges when the date range control wasn't being used.
				if (($pos) and (strlen($_POST['columns'][$i]['search']['value']) > 13)) {


					$range = explode('-yadcf_delim-', ($_POST['columns'][$i]['search']['value']));

					If (($range[0]) and (strlen($range[1]) == 9)) {

						$this->db->where('to_date(' . $item . ') ' . '>= upper(\'' . $range[0] . '\')');

					}

					If (($range[1]) and (strlen($range[1]) == 9)) {

						$this->db->where('to_date(' . $item . ') ' . '<= upper(\'' . $range[1] . '\')');

					}


				} else {

					// force column filtering to be uppercase always.  This appears to be the correct place for this.
					// @TODO examine if using upper with numbers can cause issues.  Can I seperate the process for numbers and strings?

					If ($_POST['columns'][$i]['search']['value'] <> '-yadcf_delim-') {


						$pos_pipe = strpos(($_POST['columns'][$i]['search']['value']), '|');

						if ($pos_pipe) {

							// Explode the string then loop through and break the search statement up into individual terms and make each one a
							// Query Builder like term separated by "OR".  \
							// @TODO You must contain all "OR" statements into one parenthetical statement.

							$multi_search = explode("|", ($_POST['columns'][$i]['search']['value']));

							//var_dump($multi_search);

							// Add an opening parenthesis here to create a multi-condition where clause that doesn't affect the rest of the query.
							$this->db->group_start();

							foreach ($multi_search as $search_item) {


								$this->db->or_where('upper(DESCRIPTION) = ', strtoupper($search_item));

							}

							// Add closing parenthesis here.
							$this->db->group_end();

						} else {

							$POST_VAR = strtoupper($_POST['columns'][$i]['search']['value']);
							$this->db->like(('upper(' . $item . ')'), strtoupper($POST_VAR));


						}
					}
				}

			}

			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like(strtoupper($item), strtoupper($_POST['search']['value']));
				} else {
					$this->db->or_like(strtoupper($item), strtoupper($_POST['search']['value']));
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);

		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered()
	{
		// @TODO See if we can speed this up by using $this->db->count_all_results instead:
		// https://stackoverflow.com/questions/7036950/difference-between-querynum-rows-and-this-db-count-all-results-in-codei
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


}
