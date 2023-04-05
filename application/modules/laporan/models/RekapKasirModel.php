<?php
class RekapKasirModel extends CI_Model
{



    var $table = 'dbo.xTransak';

    var $column_order = array('MIN(tr.TGL)','MIN(tr.TGL)','MIN(tr.TGL)','tr.NOTA', 'TOTAL'); //set column field database for datatable orderable
    var $column_search = array('tr.TGL','tr.NOTA', 'TOTAL'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('tr.NOTA' => 'asc'); // default order 

    var $tableDet = 'dbo.xTransakDetil';
    var $column_orderDet = array('tr.KASIR', 'tr.KASIR', 'supp.KDSUP', 'sum(det.TOTAL)');
    var $orderDet = array('tr.KASIR' => 'desc'); // default order 
    var $column_searchDet = array('det.TGL', 'det.NAMABRG', 'det.KDSUP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($master,$detil)
    {
        if ($this->input->post('min')) {


            $this->db->where('tr.TGL >=', $this->input->post('min'));
            $this->db->where('tr.TGL <=', $this->input->post('max'));
        }
        if ($this->input->post('KASIR')) {
            $this->db->where('tr.KASIR', $this->input->post('KASIR'));
        }
        if ($this->input->post('NOTA')) {
            $this->db->like('tr.NOTA', $this->input->post('NOTA'), 'both'); 
            // $this->db->where('tr.NOTA', $this->input->post('NOTA'));
        }




        $this->db->select('tr.NOTA')
            ->select_sum('det.TOTAL')
            ->select_min('tr.TGL')
           
            ->from('SUPL as supp')
            ->join($detil.' as det', 'supp.KDSUP = det.KDSUP', 'right outer')
            ->join($master.' as tr', 'tr.NOTA = det.NOTA', 'left outer')
            ->where('tr.KODETRN', 'J')
            ->where('tr.PAID', '1')
            ->where('det.FLAG is NULL', NULL, FALSE)
            ->group_by('tr.NOTA');


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

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    //total
    
    private function _get_datatables_queryRekap($master,$detil)
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
            ->join($detil. ' as det', 'supp.KDSUP = det.KDSUP', 'inner')
            ->join($master.' as tr', 'tr.NOTA = det.NOTA', 'left outer')
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
            $this->db->order_by($this->column_orderDet[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->orderDet)) {
            $order = $this->orderDet;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatablesRekap($master,$detil)
    {
        $this->_get_datatables_queryRekap($master,$detil);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filteredT($master,$detil)
    {
        $this->_get_datatables_queryRekap($master,$detil);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_allT()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function rekapKasir($awal, $akhir,$usr,$master,$detil){
        $query = "
        SELECT tr.NOTA,MIN(tr.TGL) AS TGL, SUM(det.TOTAL) as TOTAL FROM $master as tr INNER JOIN $detil as det ON tr.NOTA=det.NOTA LEFT OUTER JOIN SUPL as SUP ON det.KDSUP = SUP.KDSUP 
        WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL) AND (tr.TGL BETWEEN '$awal' AND '$akhir') AND (tr.KASIR = '$usr') AND (SUP.FAKTUR = 1)
        GROUP BY tr.NOTA  ORDER By tr.NOTA 
          
        ";
    
        return $this->db->query($query)->result();
    }
    public function rekapTotal($awal, $akhir, $supp,$master,$detil){
        $query = "
        SELECT     tr.KASIR, SUM(det.TOTAL) AS TOTAL, sup.KDSUP
        FROM         SUPL as sup INNER JOIN
                              $detil AS det ON sup.KDSUP = det.KDSUP LEFT OUTER JOIN
                            $master AS tr ON det.NOTA = tr.NOTA
        WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL)  AND TR.TGL BETWEEN '$awal' AND  '$akhir' AND  (sup.FAKTUR = 1)  AND (  sup.KDSUP LIKE '%$supp%' ESCAPE '!' )
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
      
    public function fetchSumSearch($tgl_awal, $tgl_akhir, $usr, $nota,$master,$detil)
    {
     

        $query = $this->db->query("SELECT tr.NOTA,MIN(tr.TGL) AS TGL, SUM(det.TOTAL) as TOTAL FROM $master as tr INNER JOIN $detil as det ON tr.NOTA=det.NOTA LEFT OUTER JOIN SUPL as SUP ON det.KDSUP = SUP.KDSUP WHERE     (tr.PAID = 1) AND (tr.KODETRN = 'J') AND (det.FLAG IS NULL) AND (tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir') AND (tr.KASIR = '$usr') AND (SUP.FAKTUR = 1)    AND (  tr.NOTA LIKE '%$nota%' ESCAPE '!' ) GROUP BY tr.NOTA  ORDER By tr.NOTA ;");

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
  
    public function sumRekapTotal($tgl_awal, $tgl_akhir, $supp,$master,$detil)
    {
    $query = $this->db->query("SELECT     tr.KASIR, SUM(det.TOTAL) AS TOTAL, sup.KDSUP
     FROM         SUPL as sup INNER JOIN
                           $detil AS det ON sup.KDSUP = det.KDSUP LEFT OUTER JOIN
                         $master AS tr ON det.NOTA = tr.NOTA
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
    public function search($postData)
    {
    $response = array();

    if(isset($postData['search']) ){
      // Select record
      $this->db->select('*');
      $this->db->where("UserID like '%".$postData['search']."%' ");

      $records = $this->db->get('UserID')->result();

      foreach($records as $row ){
         $response[] = array("value"=>$row->UserID);
      }

    }

    return $response;
 }
 public function searchNota($postData)
 {
 $response = array();

 if(isset($postData['searchNot']) ){
   // Select record
   $this->db->select('TOP (10)*');
   $this->db->where("NOTA like '%".$postData['searchNot']."%' ");

   $records = $this->db->get('xTransak')->result();

   foreach($records as $row ){
      $response[] = array("value"=>$row->NOTA);
   }

 }

 return $response;
}

}