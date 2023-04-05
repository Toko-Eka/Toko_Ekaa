<?php
class HargaBarangModel extends CI_Model
{




    var $table = 'dbo.MASTER';
    var $column_order = array('NAMABRG','HET','RLABA','HBT','JHAR1','JHAR2','JHAR3','JHAR4','JHAR5','HKANVAS'); //set column field database for datatable orderable
    var $column_search = array('KDBRG','JENIS','NAMABRG'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('KDBRG' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query()
    {
        if($this->input->post('KDSUP'))
        {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
        if($this->input->post('NAMABRG'))
        {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
        }
        if ($this->input->post('min')) {


            $this->db->where('det.TGL >=', $this->input->post('min'));
            $this->db->where('det.TGL <=', $this->input->post('max'));
        }
    
        if ($this->input->post('NAMABRG')) {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
      
        }

        $this->db->from($this->table);
          



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
    public function getHarga($supp)
	{
		$query = "
        SELECT * FROM dbo.MASTER WHERE KDSUP='$supp' ORDER BY KDSUP 
		";

		return $this->db->query($query)->result();
	}
    public function getHargaAll()
	{
		$query = "
        SELECT * FROM dbo.MASTER ORDER BY KDSUP 
		";

		return $this->db->query($query)->result();
	}
}