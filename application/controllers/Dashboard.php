<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
    }

    public function index()
    {
        // get all of the dreams
        $data['dreamTable'] = $this->Main_model->get('my_dreams', 'id');

        $this->load->view('includes/header');
        $this->load->view('dashboard', $data);
        $this->load->view('includes/footer');
    }

    function createGoal()
    {
        // $_POST['goal']  = "flutter";
        // $_POST['finish_date']  = "2020-12-11";
        if (isset($_POST['goal'])) {
            $goal = $this->input->post('goal');
            $finish_date = $this->input->post('finish_date');

            $startDate = date('Y-m-d');

            $insert['goal'] = $goal;
            $insert['start_date'] = $startDate;
            $insert['end_date'] = $finish_date;
            $this->Main_model->_insert('my_dreams', $insert);
        }
    }

    function refreshTable()
    {
        $dreamTable = $this->Main_model->get('my_dreams', 'id');
        $counter = 0;
        foreach ($dreamTable->result() as $row) {
            $counter++;
            echo '
            <tr>
                <td>' . $counter . '</td>
                <td>' . $row->goal . '</td>
                <td>' . $row->start_date . '</td>
                <td>' . $row->end_date . '</td>
            </tr>
            ';
        }
    }
}
