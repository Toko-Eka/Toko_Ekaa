<?php
class BrgNotTerjualModel extends CI_Model
{
	

    var $table = 'dbo.MASTER';
    var $column_order = array('NAMABRG','HET','HBT','AKHIR'); //set column field database for datatable orderable
    var $column_search = array('NAMABRG','HET','HBT','AKHIR'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('KDBRG' => 'ASC'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($master,$detail)
    {
        if ($this->input->post('min')) {
           $awal =  $this->input->post('min');
           $akhir =  $this->input->post('max');
          $stok1 =  $this->input->post('AWAL');
          $stok2 =  $this->input->post('AKHIR');
           $a="'$awal'";
           $b="'$akhir'";

           $this->db->where('KDBRG NOT IN (SELECT KDBRG FROM '.$detail.' WHERE TGL BETWEEN '.$a.' and '.$b.') AND  AKHIR BETWEEN '.$stok1.' and '.$stok2.' ', NULL, FALSE);

          
                    }
        if($this->input->post('KDSUP'))
        {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
        if ($this->input->post('NAMABRG')) {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
      
        }
   
        $this->db->select('brg.*')
        ->from('MASTER AS brg');
       
 
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($master,$detail)
    {
        $this->_get_datatables_query($master,$detail);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($master,$detail)
    {
        $this->_get_datatables_query($master,$detail);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($master,$detail)
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function getNotTerjual($awal,$akhir,$barr,$master,$detail,$stok1,$stok2)
	{
		$query = "
        SELECT * FROM dbo.MASTER WHERE KDBRG NOT IN (SELECT KDBRG FROM $detail WHERE TGL BETWEEN '$awal' and '$akhir' )  AND NAMABRG LIKE '%$barr%' AND AKHIR BETWEEN '$stok1' and '$stok2' ORDER BY KDSUP ASC
		";
// var_dump($query);die;
		return $this->db->query($query)->result();
	}
    public function getNotTerjualWithSupp($awal,$akhir,$barr,$supp,$master,$detail,$stok1,$stok2)
	{
		$query = "
        SELECT * FROM dbo.MASTER WHERE KDBRG NOT IN (SELECT KDBRG FROM $detail WHERE TGL BETWEEN '$awal' and '$akhir' )  AND NAMABRG LIKE '%$barr%' AND KDSUP = '$supp'  AND AKHIR BETWEEN '$stok1' and '$stok2' ORDER BY KDSUP ASC
		";
// var_dump($query);die;
		return $this->db->query($query)->result();
	}
}