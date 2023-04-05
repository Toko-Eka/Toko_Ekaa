<?php
class upload_model extends CI_Model
{

    public function attachDB($param1, $param2)
    {
        $query = "
        USE [master];
     ALTER DATABASE [esc] SET SINGLE_USER;
     USE [master];
     EXEC master.dbo.sp_detach_db @dbname = N'esc', @skipchecks = 'true';
         EXEC sp_attach_db @dbname = N'esc',   
            @filename1 =   'C:\laragon\www\Toko_Eka\assets\uploadDB\\$param1',   
            @filename2 =   'C:\laragon\www\Toko_Eka\assets\uploadDB\\$param2';    
        ";
        //   var_dump($query);die;
    $this->db->query($query);
    }
}
