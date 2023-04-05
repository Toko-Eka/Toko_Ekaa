<?php
class NilaiInvenModel extends CI_Model
{



    var $table = 'dbo.MASTER';
    var $column_order = array('NAMABRG','KDSUP','AKHIR','HBT','(AKHIR * HBT)'); //set column field database for datatable orderable
    var $column_search = array('KDBRG','JENIS','NAMABRG','KDSUP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('KDBRG' => 'asc'); // default order 


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query()
    {
        if ($this->input->post('min')) {


            $this->db->where('det.TGL >=', $this->input->post('min'));
            $this->db->where('det.TGL <=', $this->input->post('max'));
        }
    
        if ($this->input->post('NAMABRG')) {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
      
        }
        if ($this->input->post('KDSUP')) {
            $this->db->like('KDSUP', $this->input->post('KDSUP'), 'both'); 
      
        }
      
       $this->db->select('NAMABRG')
                ->select('ROUND((HBT),0,1) as HBT')
                ->select('AKHIR')
                ->select('(AKHIR * ROUND((HBT),0,1)) as TOTAL')          
                ->select('KDSUP') 
                ->from('MASTER');
       

 





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
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function fetchSumWOBoth()
    {


        $query = $this->db->query("    SELECT NAMABRG, AKHIR, ROUND((HBT),0,1) as HBT, AKHIR * ROUND((HBT),0,1) as TOTAL,KDSUP FROM MASTER ORDER BY KDSUP");

        if ($query->num_rows() > 0) {
            $sum = 0;
            $sumqty = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->AKHIR,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
    }
    public function fetchSumWoSupp($brg)
    {


        $query = $this->db->query("SELECT NAMABRG, AKHIR, ROUND((HBT),0,1) as HBT, AKHIR * ROUND((HBT),0,1) as TOTAL,KDSUP FROM MASTER WHERE NAMABRG LIKE '%$brg%' ORDER BY KDSUP  ;");

        if ($query->num_rows() > 0) {
            $sumqty = 0;
            $sum = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->AKHIR,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
    }
    public function fetchSumWoBrg($supp)
    {

// var_dump($supp);
        $query = $this->db->query("SELECT NAMABRG, AKHIR, ROUND((HBT),0,1) as HBT, AKHIR * ROUND((HBT),0,1) as TOTAL,KDSUP FROM MASTER WHERE KDSUP = '$supp' ORDER BY KDSUP  ;");

        if ($query->num_rows() > 0) {
            $sumqty = 0;
            $sum = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->AKHIR,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
    }
    public function fetchSum($brg,$supp)
    {


        $query = $this->db->query("SELECT NAMABRG, AKHIR, ROUND((HBT),0,1) as HBT, AKHIR * ROUND((HBT),0,1) as TOTAL,KDSUP FROM MASTER WHERE NAMABRG LIKE '%$brg%' AND KDSUP = '$supp' ORDER BY KDSUP  ;");

        if ($query->num_rows() > 0) {
            $sumqty = 0;
            $sum = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->AKHIR,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
    }
    public function repInventoryOld($awal,$akhir){
        $query = " 
        SELECT   MIN(det.KDBRG) AS kode
        ,MIN(det.NAMABRG) AS nama
        ,MIN(det.KDSUP) AS KDSUP
    ,SUM(det.JMLBRG) AS totalQty
    ,SUM(det.HBT * det.JMLBRG) as total
    ,MIN(brg.AKHIR) AS stokAkhir
    ,MIN(det.TGL) AS tgl
    ,MIN(BRG.AWAL) AS stokAwal
    ,MIN(BRG.MASUK) AS jmlMasuk
    ,MIN(BRG.JUAL) AS jmlKeluar 
    FROM xTransakDetil as det RIGHT JOIN xTransak as mast on det.NOTA = mast.NOTA JOIN MASTER AS BRG ON BRG.KDBRG = det.KDBRG   WHERE  det.tgl BETWEEN '$awal' AND '$akhir' GROUP BY BRG.KDBRG ORDER BY MAX(det.KDSUP)
    ";
    // var_dump($query);die;
    return $this->db->query($query)->result();
     }
     public function repInventory(){
        $query = " 
        SELECT NAMABRG, AKHIR, ROUND((HBT),0,1) as HBT, AKHIR * ROUND((HBT),0,1) as TOTAL,KDSUP FROM MASTER ORDER BY KDSUP
       ";
    // var_dump($query);die;
    return $this->db->query($query)->result();
     }
     public function repInventorySupp($kdsupp){
        $query = " 
        SELECT NAMABRG, AKHIR, ROUND((HBT),0,1) as HBT, AKHIR * ROUND((HBT),0,1) as TOTAL,KDSUP FROM MASTER WHERE KDSUP='$kdsupp' ORDER BY KDSUP
       ";
    // var_dump($query);die;
    // var_dump($query);die;
return $this->db->query($query)->result();
     }
     public function repInventoryBrg($bar){
        $query = " 
        SELECT NAMABRG, AKHIR, ROUND((HBT),0,1) as HBT, AKHIR * ROUND((HBT),0,1) as TOTAL,KDSUP FROM MASTER WHERE NAMABRG LIKE '%$bar%' ESCAPE'!' ORDER BY KDSUP
       ";
    // var_dump($query);die;
    // var_dump($query);die;
    return $this->db->query($query)->result();
     }
     public function repInventoryAll($kdsupp,$bar){
        $query = " 
        SELECT NAMABRG, AKHIR, ROUND((HBT),0,1) as HBT, AKHIR * ROUND((HBT),0,1) as TOTAL,KDSUP FROM MASTER WHERE NAMABRG LIKE'%$bar%'  ESCAPE'!'   and  KDSUP='$kdsupp' ORDER BY KDSUP
       ";
    // var_dump($query);die;
    // var_dump($query);die;
    return $this->db->query($query)->result();
     }
}