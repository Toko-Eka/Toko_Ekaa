<?php
class UnpaidTrModel extends CI_Model
{



    var $table = 'dbo.xTransakDetil';

    var $column_orderDet =array('tr.NOTA', 'det.KDBRG', 'det.NAMABRG', 'det.KDSUP', 'det.JMLBRG', 'det.HARGA', 'det.TOTAL', 'det.TGL'); //set column field database for datatable orderable
    var $column_search =array('det.TGL', 'det.NAMABRG', 'det.KDSUP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('tr.NOTA' => 'asc'); // default order 


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    private function _get_datatables_query($master,$detil)
    {
        if ($this->input->post('min')) {


            $this->db->where('det.TGL >=', $this->input->post('min'));
            $this->db->where('det.TGL <=', $this->input->post('max'));
        }
    
        if ($this->input->post('NAMABRG')) {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
      
        }

        $this->db->select('det.*,tr.KODETRN')
            ->from($detil.' as det')
            ->join($master. ' as tr', 'tr.NOTA = det.NOTA', 'inner')
            ->where('det.FLAG is NULL', NULL, FALSE)
            ->where('tr.PAID', '0')
            ->where('tr.KODETRN', 'J');




        //  $query = $this->db->get();
        //     //    $query= $this->db->query(' SELECT MIN(tr.TGL) as TGLL, tr.NOTA,SUM(det.JMLBRG) as TotalQTY, SUM(det.TOTAL) as Total FROM Transak as tr  LEFT JOIN TransakDetil as det ON tr.NOTA = det.NOTA GROUP BY tr.NOTA ORDER BY tr.NOTA;');
        //        return $query->result_array();



        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_orderDet[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($master,$detil)
    {
        $this->_get_datatables_query($master,$detil);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($master,$detil)
    {
        $this->_get_datatables_query($master,$detil);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function RepDetPerNota($tgl_awal, $tgl_akhir,$master,$detil)
    {
        $query = "
    SELECT det.*, tr.KODETRN FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'J' AND det.FLAG IS NULL AND tr.PAID=1  ORDER BY det.NOTA;
    ";
        // var_dump($query);die;
        return $this->db->query($query)->result();
    }
    public function fetchSumWoSupp($tgl_awal, $tgl_akhir, $brg,$master,$detil)
    {
var_dump($brg);
        $query = $this->db->query("SELECT SUM(det.TOTAL) as TOTAL,SUM(det.JMLBRG) AS JML FROM $detil as det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.FLAG IS NULL AND tr.KODETRN='J' AND tr.PAID='0' AND det.NAMABRG LIKE '%$brg%' AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY det.NOTA;");

        if ($query->num_rows() > 0) {
            $sum = 0;
            $sumqty = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->JML,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
        //     $tgl_awal = $this->db->escape($tgl_awal);
        //     $tgl_akhir = $this->db->escape($tgl_akhir);
        //     $this->db->where('TGL BETWEEN '.$tgl_awal.' AND '.$tgl_akhir); // Tambahkan where tanggal nya
        // return $this->db->get('dbo.Transak')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
    }
    public function fetchSumWoBoth($tgl_awal, $tgl_akhir,$master,$detil)
    {


        $query = $this->db->query("SELECT SUM(det.TOTAL) as TOTAL,SUM(det.JMLBRG) AS JML FROM $detil as det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.FLAG IS NULL AND tr.KODETRN='J' AND tr.PAID='0' AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY det.NOTA;");

        if ($query->num_rows() > 0) {
            $sumqty = 0;
            $sum = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->JML,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
    }
    public function repUnpaid($tgl_awal, $tgl_akhir,$master,$detil)
    {
        $query = "
    SELECT det.*, tr.KODETRN FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'J' AND det.FLAG IS NULL AND tr.PAID= 0 ORDER BY det.NOTA;
    ";

        return $this->db->query($query)->result();
    }
}