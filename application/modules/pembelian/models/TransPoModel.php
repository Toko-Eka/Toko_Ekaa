<?php
class TransPoModel extends CI_Model
{



    var $table = 'dbo.Trpo';

    var $column_order =array('det.NOTA', 'det.KDBRG', 'det.NAMABRG', 'det.KDSUP', 'det.JMLBRG', 'det.HARGA', 'det.TOTAL', 'det.TGL'); //set column field database for datatable orderable
    var $column_search =array('mast.NAMABRG', 'mast.KDBRG'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('tr.NOTA' => 'asc'); // default order 
    var $column_orderLoad =array('nopo', 'supplier','flag2'); //set column field database for datatable orderable
    var $column_searchLoad =array('nopo', 'supplier','flag2'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $orderLoad = array('nopo' => 'asc'); // default order 


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    private function _get_datatables_query()
    {
 
        if($this->input->post('KDSUP'))
        {
            $this->db->where('mast.KDSUP', $this->input->post('KDSUP'));
        }
    
        if ($this->input->post('NAMABRG')) {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
      
        }
      
      

        $a="'J'";
        $b="'B'";
        $tgl1 =  $this->input->post('dari');
        $tgl2 =  $this->input->post('ke');
       $stok1 =  $this->input->post('AWAL');
       $stok2 =  $this->input->post('AKHIR');
       $stokawal =  $this->input->post('AWALSTOK');
       $stokakhir =  $this->input->post('AKHIRSTOK');
       $fixed1="'$stokawal'";
       $fixed2="'$stokakhir'"; 
        $awal="'$tgl1'";
        $akhir="'$tgl2'"; 
        $this->db->select('mast.KDBRG,min(mast.KDSUP) AS KDSUP ,mast.NAMABRG,SUM(CASE WHEN tr.kodetrn = '.$a.' AND ( tr.TGL BETWEEN '.$awal.' AND '.$akhir.') THEN det.JMLBRG ELSE 0 END) AS TERJUAL,MIN(mast.AWAL) AS AWAL, SUM(CASE WHEN tr.kodetrn = '.$b.' AND ( tr.TGL BETWEEN '.$awal.' AND '.$akhir.')                         THEN det.JMLBRG ELSE 0 END) AS MASUK, MIN(mast.AKHIR) AS AKHIR, MIN(mast.MAXOR) AS MAXOR, MIN(mast.HET) AS HET, MIN(mast.HBT) AS HBT')
            ->from('MASTER as mast')
            ->join('xTransakDetil as det', 'mast.KDBRG = det.KDBRG', 'LEFT OUTER')
            ->join('xTransak as tr', 'det.NOTA = tr.NOTA', 'LEFT OUTER')
          ->where('mast.KDSUP', $this->input->post('KDSUP'))
      
          ->where('det.AKHIR BETWEEN   ' . $fixed1 .' AND '.$fixed2.' ')
 
      
            ->where('det.FLAG is NULL', NULL, FALSE)
            ->group_by(' mast.KDBRG, mast.NAMABRG  HAVING      (NOT (mast.KDBRG IS NULL)) AND (SUM(CASE WHEN tr.kodetrn ='.$a.' AND ( tr.TGL IS NULL OR                         tr.TGL BETWEEN '.$awal.' AND '.$akhir.') THEN det.JMLBRG ELSE 0 END) BETWEEN '.$stok1.' AND '.$stok2.')  AND   (SUM(CASE WHEN tr.kodetrn ='.$a.'AND (tr.TGL BETWEEN '.$awal.' AND '.$akhir.') THEN det.JMLBRG ELSE 0 END) BETWEEN '.$stok1.' AND '.$stok2.')');





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

        // if (isset($_POST['order'])) // here order processing
        // {
        //     $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        // } else if (isset($this->order)) {
        //     $order = $this->order;
        //     $this->db->order_by(key($order), $order[key($order)]);
        // }
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
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
   
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    private function _get_datatables_queryLoad()
    {
        if ($this->input->post('min')) {


            $this->db->where('tgl >=', $this->input->post('min'));
            $this->db->where('tgl <=', $this->input->post('max'));
        }
        if ($this->input->post('PAID')) {
            $this->db->where('tr.PAID', $this->input->post('PAID'));
        }
        if($this->input->post('KDSUP'))
        {
            $this->db->where('kdsup', $this->input->post('KDSUP'));
        }
        if ($this->input->post('FLAG')) {
            $this->db->like('flag2', $this->input->post('FLAG'), 'both');
        }
   


        $this->db->select('*')
           
            ->from('TrPo');
           


        $i = 0;

        foreach ($this->column_searchLoad as $item) // loop column 
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

                if (count($this->column_searchLoad) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_orderLoad[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->orderLoad)) {
            $order = $this->orderLoad;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatablesLoad()
    {
        $this->_get_datatables_queryLoad();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filteredLoad()
    {
        $this->_get_datatables_queryLoad();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_allLoad()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function search($postData)
    {
    $response = array();

    if(isset($postData['search']) ){
      // Select record
      $this->db->select('TOP (10)*');
      $this->db->where("NAMABRG like '%".$postData['search']."%' ");
      $this->db->or_where("KDBRG like '%".$postData['search']."%' ");
      $this->db->where("KDSUP ='".$postData['supl']."' ");
      $records = $this->db->get('MASTER')->result();

      foreach($records as $row ){
         $response[] = array("label"=>$row->KDBRG,"val"=>$row->NAMABRG,"hbt"=>$row->HBT,"rlaba"=>round((float)$row->RLABA * 1 ) . '%',"het"=>$row->HET);
     
      }

    }

    return $response;
 }
 function load($id)
{
   
     
             
         
             $this->db->select('mast.*, po.JMLBRG, po.JMLMSK')
       ->from('Trpodetil AS po')
    
       ->join('MASTER as mast','mast.KDBRG = po.KDBRG', 'INNER')
          ->where('po.KDBRG IN (SELECT KDBRG FROM Trpodetil WHERE NOPO = '.$id.')')
          ->where('po.nopo ='.$id);


          $query = $this->db->get();
    
          $result = $query->result();
   
          $paid = array();
          foreach ($result as $row) 
          {
              $paid[] = $row->KDBRG;
              $paid[] = $row->NAMABRG;
              $paid[] = $row->HET;
              $paid[] = $row->HBT;
              $paid[] = round((float)$row->RLABA * 1 ) . '%';
              $paid[] =$row->JMLBRG;
              $paid[] =$row->JMLMSK;
      
          }
        
          return $paid;
       echo json_encode($paid);
      var_dump($paid);

      
            
            

     
        
 
}
public function GetDetail($id)
{
    $query = "
    SELECT * FROM Trpodetil  WHERE NOPO='$id'  ORDER BY NOPO ASC
    ";

    return $this->db->query($query)->result();
}
function scanBar($id)
{
   
     
    $kode="'$id'";
         
             $this->db->select('*')
       ->from('MASTER')
    
      
          ->where('KDBRG ='.$kode);


          $query = $this->db->get();
    
          $result = $query->result();
   
          $paid = array();
          foreach ($result as $row) 
          {
              $paid[] = $row->KDBRG;
              $paid[] = $row->NAMABRG;
              $paid[] = $row->HET;
              $paid[] = $row->HBT;
              $paid[] = round((float)$row->RLABA * 1 ) . '%';
    
      
          }
        
          return $paid;
       echo json_encode($paid);
      var_dump($paid);

      
            
            

     
        
 
}
}