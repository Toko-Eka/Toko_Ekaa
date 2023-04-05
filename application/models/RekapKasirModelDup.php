<?php
class RekapKasirModelDup extends CI_Model
{
    var $table = 'dbo.xTransak';

    var $column_order = array('tr.NOTA', 'TOTAL', 'JMLBRG'); //set column field database for datatable orderable
    var $column_search = array('tr.NOTA', 'tr.KODETRN', 'tr.PAID', 'tr.KASIR'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('tr.NOTA' => 'desc'); // default order 

    var $tableDet = 'dbo.xTransakDetil';
    var $column_orderDet = array('det.NOTA', 'det.KDBRG', 'det.NAMABRG', 'det.KDSUP', 'det.JMLBRG', 'det.HARGA', 'det.TOTAL', 'det.TGL');
    var $orderDet = array('supp.KDSUP' => 'asc'); // default order 
    var $column_searchDet = array('det.TGL', 'det.NAMABRG', 'det.KDSUP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



  
    
    private function _get_datatables_queryRekap()
    {
        if ($this->input->post('awal')) {


            $this->db->where('tr.TGL >=', $this->input->post('awal'));
            $this->db->where('tr.TGL <=', $this->input->post('akhir'));
        }
        if ($this->input->post('suplier')) {
            $this->db->like('det.KDSUP', $this->input->post('suplier'), 'both'); 
        }
      

        // SELECT     tr.KASIR, SUM(det.TOTAL) AS TOTAL, sup.KDSUP
        // FROM         SUPL as sup INNER JOIN
        //                       xTransakDetil AS det ON sup.KDSUP = det.KDSUP LEFT OUTER JOIN
        //                     xTransak AS tr ON det.NOTA = tr.NOTA
        // WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL)  AND TR.TGL BETWEEN '$awal' AND  '$akhir' AND  (sup.FAKTUR = 1)
        // GROUP BY tr.KASIR, sup.KDSUP ORDER BY sup.KDSUP


        $this->db->select('tr.KASIR')
            ->select_sum('det.TOTAL')
            ->select_min('det.KDSUP','SUPLIER')
            ->select_min('tr.TGL')
            ->from('SUPL as supp')
            ->join('xTransakDetil as det', 'supp.KDSUP = det.KDSUP', 'inner')
            ->join('xTransak as tr', 'tr.NOTA = det.NOTA', 'left outer')
            ->where('tr.KODETRN', 'J')
            ->where('tr.PAID', '1')
            ->where('det.FLAG is NULL', NULL, FALSE)
            ->group_by('tr.KASIR')
            ->group_by('supp.KDSUP');


        $i = 0;

        foreach ($this->column_search as $item) // loop column 
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

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->orderDet)) {
            $order = $this->orderDet;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatablesRekap()
    {
        $this->_get_datatables_queryRekap();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filteredT()
    {
        $this->_get_datatables_queryRekap();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_allT()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function rekapKasir($awal, $akhir,$usr){
        $query = "
        SELECT tr.NOTA,MIN(tr.TGL) AS TGL, SUM(det.TOTAL) as TOTAL FROM xtransak as tr INNER JOIN xtransakdetil as det ON tr.NOTA=det.NOTA LEFT OUTER JOIN SUPL as SUP ON det.KDSUP = SUP.KDSUP 
        WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL) AND (tr.TGL BETWEEN '$awal' AND '$akhir') AND (tr.KASIR = '$usr') AND (SUP.FAKTUR = 1)
        GROUP BY tr.NOTA  ORDER By tr.NOTA 
          
        ";
    
        return $this->db->query($query)->result();
    }
    public function rekapTotal($awal, $akhir){
        $query = "
        SELECT     tr.KASIR, SUM(det.TOTAL) AS TOTAL, sup.KDSUP
        FROM         SUPL as sup INNER JOIN
                              xTransakDetil AS det ON sup.KDSUP = det.KDSUP LEFT OUTER JOIN
                            xTransak AS tr ON det.NOTA = tr.NOTA
        WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL)  AND TR.TGL BETWEEN '$awal' AND  '$akhir' AND  (sup.FAKTUR = 1)
        GROUP BY tr.KASIR, sup.KDSUP ORDER BY sup.KDSUP
         
        ";
    
        return $this->db->query($query)->result();
    }
    public function getRekapDetail($id)
    {
        $query = "
		SELECT KDBRG,NAMABRG,HARGA,JMLBRG FROM xTransakDetil WHERE NOTA='$id' ORDER BY NOTA ASC
		";

        return $this->db->query($query)->result();
    }
    public function fetchSum($tgl_awal, $tgl_akhir, $usr)
    {


        $query = $this->db->query("SELECT tr.NOTA,MIN(tr.TGL) AS TGL, SUM(det.TOTAL) as TOTAL FROM xtransak as tr INNER JOIN xtransakdetil as det ON tr.NOTA=det.NOTA LEFT OUTER JOIN SUPL as SUP ON det.KDSUP = SUP.KDSUP WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL) AND (tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir') AND (tr.KASIR = '$usr') AND (SUP.FAKTUR = 1) GROUP BY tr.NOTA  ORDER By tr.NOTA ;");

        if ($query->num_rows() > 0) {
            $sum = 0;
       
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                  
                    'GRANDTOTAL' => $sum,
                    
                );
            }
        }
        return $hasil;
    }
    public function fetchSumSearch($tgl_awal, $tgl_akhir, $usr, $nota)
    {
     

        $query = $this->db->query("SELECT tr.NOTA,MIN(tr.TGL) AS TGL, SUM(det.TOTAL) as TOTAL FROM xtransak as tr INNER JOIN xtransakdetil as det ON tr.NOTA=det.NOTA LEFT OUTER JOIN SUPL as SUP ON det.KDSUP = SUP.KDSUP WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL) AND (tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir') AND (tr.KASIR = '$usr') AND (SUP.FAKTUR = 1)    AND (  tr.NOTA LIKE '%$nota%' ESCAPE '!' ) GROUP BY tr.NOTA  ORDER By tr.NOTA ;");

        if ($query->num_rows() > 0) {
            $sum = 0;
       
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                  
                    'GRANDTOTAL' => $sum,
                    
                );
            }
        }
        return $hasil;
    }
  
    public function sumRekapTotal($tgl_awal, $tgl_akhir, $supp)
    {
    $query = $this->db->query("SELECT     tr.KASIR, SUM(det.TOTAL) AS TOTAL, sup.KDSUP
     FROM         SUPL as sup INNER JOIN
                           xTransakDetil AS det ON sup.KDSUP = det.KDSUP LEFT OUTER JOIN
                         xTransak AS tr ON det.NOTA = tr.NOTA
     WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL)  AND TR.TGL BETWEEN '$tgl_awal' AND  '$tgl_akhir' AND  (sup.FAKTUR = 1)  AND (  sup.KDSUP LIKE '%$supp%' ESCAPE '!' )
     GROUP BY tr.KASIR, sup.KDSUP ORDER BY sup.KDSUP");

       

        if ($query->num_rows() > 0) {
            $sum = 0;
       
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                  
                    'GRANDTOTAL' => $sum,
                    
                );
            }
        }
        return $hasil;
    }


}