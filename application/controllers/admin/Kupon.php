<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kupon extends CI_Controller {
        public function __construct(){
                parent::__construct();
                is_logged_in('Kupon');
                $this->load->model('Kupon_model');
                $this->load->library('datatables'); 
        }

        public function index(){
                $data['judul']="Kupon";
                $data['group']="Kupon";
                $this->load->view('backend/template/header',$data);        
                $this->load->view('backend/template/sidebar');        
                $this->load->view('backend/kupon/kupon');        
                $this->load->view('backend/template/footer');        
                $this->load->view('backend/template/script');        
        }

        function fetch_data()
        {
            $data = $this->db->query("SELECT * FROM tbl_kupon");
            $output = '<table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode Kupon</th>
                                <th>Tipe</th>
                                <th>Tipe Potongan</th>
                                <th>Min Belanja</th>
                                <th>Potongan</th>
                                <th>Valid Until</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
            foreach ($data->result() as $row) {
                $val = "Rp." . number_format($row->value,0,",",".");
                if($row->tipe_potongan == 'percent'){
                    $val = $row->value."%";
                }
                $output .= '
                <tr>
                    <td>' . $row->kode_kupon . '</td>
                    <td>' . $row->tipe_kupon . '</td>
                    <td>' . $row->tipe_potongan . '</td>
                    <td>Rp.' . number_format($row->min_value,0,",",".") . '</td>
                    <td>'.$val.'</td>
                    
                    <td>' .date("d-F-Y",strtotime($row->valid_until)) . '</td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-btn mr-2 mb-2 btn-block" data-kode_kupon = "' . $row->kode_kupon . '">Delete</button>
                        <button class="btn btn-info btn-sm edit-btn mr-2 mb-2 btn-block" data-kode_kupon = "' . $row->kode_kupon . '" data-tipe_kupon = "' . $row->tipe_kupon . '" data-tipe_potongan = "' . $row->tipe_potongan . '" data-min_value = "' . $row->min_value . '" data-value = "' . $row->value . '" data-max_value = "' . $row->max_value . '" data-valid_until = "' . $row->valid_until . '" >Edit</button>
                    </td>
                </tr>
                ';
            }
            $output .= '</tbody></table>';
            echo $output;
        }
        public function save_data(){
            
            $this->form_validation->set_rules('kode_kupon', 'Kode Kupon', 'required|trim|is_unique[tbl_kupon.kode_kupon]');
            $this->form_validation->set_rules('valid_until', 'Valid Sampai', 'required|trim');
            $this->form_validation->set_rules('value', 'Nilai potongan', 'required|trim');
            $this->form_validation->set_rules('min_value', 'Min Belanja', 'required|trim');
            $this->form_validation->set_rules('tipe_kupon', 'Tipe Kupon', 'required|trim');
            if($this->input->post('tipe_kupon') == 'potongan'){
                $this->form_validation->set_rules('tipe_value', 'Tipe Value', 'required|trim');
            }
            if ($this->form_validation->run() == false) {
                if (form_error('tipe_kupon')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('tipe_kupon')));
                    die();
                }
               
                if (form_error('tipe_value')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('tipe_value')));
                    die();
                }
               
                if (form_error('min_value')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('min_value')));
                    die();
                }
               
                if (form_error('value')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('value')));
                    die();
                }
               
                if (form_error('valid_until')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('valid_until')));
                    die();
                }
               
                if (form_error('kode_kupon')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('kode_kupon')));
                    die();
                }
               
            } else {
                $data=[
                    'kode_kupon'=>$this->input->post('kode_kupon'),
                    'tipe_kupon'=>$this->input->post('tipe_kupon'),
                    'tipe_potongan'=>$this->input->post('tipe_potongan'),
                    'min_value'=>$this->input->post('min_value'),
                    'value'=>$this->input->post('value'),
                    'valid_until'=>$this->input->post('valid_until'),
                ];
                
                $this->db->insert('tbl_kupon',$data);
                echo "Success|Berhasil menambah kupon";
                die(); 
    
            }
        }
        public function update_data(){
            $original_value = $this->input->post('original_value');
            if($this->input->post('kode_kupon') != $original_value) {
                $is_unique =  '|is_unique[tbl_kupon.kode_kupon]';
            } else {
                $is_unique =  '';
            }
            $this->form_validation->set_rules('kode_kupon', 'Kode Kupon', 'required|trim'.$is_unique);
            $this->form_validation->set_rules('valid_until', 'Valid Sampai', 'required|trim');
            $this->form_validation->set_rules('value', 'Nilai potongan', 'required|trim');
            $this->form_validation->set_rules('min_value', 'Min Belanja', 'required|trim');
            $this->form_validation->set_rules('tipe_kupon', 'Tipe Kupon', 'required|trim');
            if($this->input->post('tipe_kupon') == 'potongan'){
                $this->form_validation->set_rules('tipe_value', 'Tipe Value', 'required|trim');
            }
            if ($this->form_validation->run() == false) {
                if (form_error('tipe_kupon')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('tipe_kupon')));
                    die();
                }
               
                if (form_error('tipe_value')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('tipe_value')));
                    die();
                }
               
                if (form_error('min_value')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('min_value')));
                    die();
                }
               
                if (form_error('value')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('value')));
                    die();
                }
               
                if (form_error('valid_until')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('valid_until')));
                    die();
                }
               
                if (form_error('kode_kupon')) {
                    echo "Error|" . str_replace("</p>", "", str_replace("<p>", "", form_error('kode_kupon')));
                    die();
                }
               
            } else {
                $data=[
                    'kode_kupon'=>$this->input->post('kode_kupon'),
                    'tipe_kupon'=>$this->input->post('tipe_kupon'),
                    'tipe_potongan'=>$this->input->post('tipe_potongan'),
                    'min_value'=>$this->input->post('min_value'),
                    'value'=>$this->input->post('value'),
                    'valid_until'=>$this->input->post('valid_until'),
                ];
                $this->db->where('kode_kupon',$this->input->post('original_value'));
                $this->db->update('tbl_kupon',$data);
                echo "Success|Berhasil mengubah kupon";
                die(); 
    
            }
        }
        function delete(){
            $kode_kupon = $_POST['kode_kupon'];
            $this->db->where('kode_kupon', $kode_kupon);
            $this->db->delete('tbl_kupon');
            echo json_encode("success");
        }
}
?>