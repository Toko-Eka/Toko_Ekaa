<?php
class JualJenisModel extends CI_Model
{




    var $tableDet = 'dbo.xTransakDetil';
    var $column_orderDet = array('det.NOTA', 'det.KDBRG', 'det.NAMABRG', 'det.KDSUP', 'det.JMLBRG', 'det.HARGA', 'det.TOTAL', 'det.TGL');
    var $orderDet = array('det.NOTA' => 'desc'); // default order 
    var $column_searchDet = array('det.TGL', 'det.NAMABRG', 'det.KDSUP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
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
        if ($this->input->post('KDSUP')) {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
        if ($this->input->post('NAMABRG')) {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
            
      
        }

//kanvas
        $this->db->select('det.*,tr.KODETRN')
        ->from($detil. ' as det')
        ->join($master.' as tr', 'tr.NOTA = det.NOTA', 'inner')
        ->where('det.FLAG is NULL', NULL, FALSE)
        ->where('tr.jmode', '10')
        ->where('tr.KODETRN', 'J');


        $i = 0;

        foreach ($this->column_searchDet as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
// $this->fetchSumSearch($item);
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_searchDet) - 1 == $i) //last loop
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

    public function count_all($master,$detil)
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

   
    //program
    private function _get_datatables_queryPr($master,$detil)
    {
        if ($this->input->post('min')) {


            $this->db->where('det.TGL >=', $this->input->post('min'));
            $this->db->where('det.TGL <=', $this->input->post('max'));
        }
        if ($this->input->post('KDSUP')) {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
        if ($this->input->post('NAMABRG')) {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
            
      
        }
        $this->db->select('det.*,tr.KODETRN')
        ->from($detil. ' as det')
        ->join($master. ' as tr', 'tr.NOTA = det.NOTA', 'inner')
        ->where('det.FLAG is NULL', NULL, FALSE)
        ->where('tr.jmode', '4')
        ->where('tr.KODETRN', 'J');




        //  $query = $this->db->get();
        //     //    $query= $this->db->query(' SELECT MIN(tr.TGL) as TGLL, tr.NOTA,SUM(det.JMLBRG) as TotalQTY, SUM(det.TOTAL) as Total FROM Transak as tr  LEFT JOIN TransakDetil as det ON tr.NOTA = det.NOTA GROUP BY tr.NOTA ORDER BY tr.NOTA;');
        //        return $query->result_array();



        $i = 0;

        foreach ($this->column_searchDet as $item) // loop column 
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

                if (count($this->column_searchDet) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_orderDet[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->orderDet)) {
            $orderDet = $this->orderDet;
            $this->db->order_by(key($orderDet), $orderDet[key($orderDet)]);
        }
    }

    function get_datatablesPr($master,$detil)
    {
        $this->_get_datatables_queryPr($master,$detil);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filteredDet($master,$detil)
    {
        $this->_get_datatables_queryPr($master,$detil);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_datatables_queryOl($master,$detil)
    {
        if ($this->input->post('min')) {


            $this->db->where('det.TGL >=', $this->input->post('min'));
            $this->db->where('det.TGL <=', $this->input->post('max'));
        }
        if ($this->input->post('KDSUP')) {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
        if ($this->input->post('NAMABRG')) {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
            
      
        }
        $this->db->select('det.*,tr.KODETRN')
        ->from($detil. ' as det')
        ->join($master. ' as tr', 'tr.NOTA = det.NOTA', 'inner')
        ->where('det.FLAG is NULL', NULL, FALSE)
        ->where('jmode', '5')
        ->where('tr.KODETRN', 'J');




        //  $query = $this->db->get();
        //     //    $query= $this->db->query(' SELECT MIN(tr.TGL) as TGLL, tr.NOTA,SUM(det.JMLBRG) as TotalQTY, SUM(det.TOTAL) as Total FROM Transak as tr  LEFT JOIN TransakDetil as det ON tr.NOTA = det.NOTA GROUP BY tr.NOTA ORDER BY tr.NOTA;');
        //        return $query->result_array();



        $i = 0;

        foreach ($this->column_searchDet as $item) // loop column 
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

                if (count($this->column_searchDet) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_orderDet[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->orderDet)) {
            $orderDet = $this->orderDet;
            $this->db->order_by(key($orderDet), $orderDet[key($orderDet)]);
        }
    }

    function get_datatablesOl($master,$detil)
    {
        $this->_get_datatables_queryOl($master,$detil);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filteredOl($master,$detil)
    {
        $this->_get_datatables_queryOl($master,$detil);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // public function count_allDet()
    // {
    //     $this->db->from($this->tableDet);
        
    //     return $this->db->count_all_results();
    // }
public function fetchSumKanvas($tgl_awal, $tgl_akhir, $barr,$master,$detil)
    {
      

        $query = $this->db->query("  SELECT SUM(det.TOTAL) as TOTAL, SUM(det.JMLBRG) AS JMLBRG FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.NAMABRG LIKE '%$barr%' ESCAPE'!' AND  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'J' AND tr.jmode=10 AND det.FLAG IS NULL GROUP BY det.KDSUP;");

        if ($query->num_rows() > 0) {
            $sumqty = 0;
            $sum = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->JMLBRG,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
    }
    public function fetchSumOlshop($tgl_awal, $tgl_akhir, $barr,$master,$detil)
    {
      

        $query = $this->db->query("  SELECT SUM(det.TOTAL) as TOTAL, SUM(det.JMLBRG) AS JMLBRG FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.NAMABRG LIKE '%$barr%' ESCAPE'!' AND  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'J' AND tr.jmode=5 AND det.FLAG IS NULL GROUP BY det.KDSUP;");

        if ($query->num_rows() > 0) {
            $sumqty = 0;
            $sum = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->JMLBRG,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
    }
    public function fetchSumProgram($tgl_awal, $tgl_akhir, $barr,$master,$detil)
    {
      

        $query = $this->db->query("  SELECT SUM(det.TOTAL) as TOTAL, SUM(det.JMLBRG) AS JMLBRG FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.NAMABRG LIKE '%$barr%' ESCAPE'!' AND  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'J' AND tr.jmode=4 AND det.FLAG IS NULL GROUP BY det.KDSUP;");

        if ($query->num_rows() > 0) {
            $sumqty = 0;
            $sum = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->JMLBRG,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
    }
    public function repKanvas($tgl_awal, $tgl_akhir, $notaaa,$master,$detil)
    {
        $query = "
    SELECT det.*, tr.KODETRN FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'J' AND det.FLAG IS NULL  AND  det.NAMABRG LIKE '%$notaaa%'  AND tr.jmode=10 ORDER BY det.NOTA;
    ";
        return $this->db->query($query)->result();
    }
    public function repProgram($tgl_awal, $tgl_akhir, $notaaa,$master,$detil)
    {
        $query = "
    SELECT det.*, tr.KODETRN FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'J' AND det.FLAG IS NULL AND  det.NAMABRG LIKE '%$notaaa%' AND tr.jmode=4 ORDER BY det.NOTA;
    ";
        return $this->db->query($query)->result();
    }
    public function repOlshop($tgl_awal, $tgl_akhir,$notaaa,$master,$detil)
    {
        $query = "
    SELECT det.*, tr.KODETRN FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'J' AND det.FLAG IS NULL  AND tr.jmode=5  AND  det.NAMABRG LIKE '%$notaaa%'  ORDER BY det.NOTA;
    ";
        return $this->db->query($query)->result();
    }
}

