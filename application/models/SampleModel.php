<?php

class Application_Model_SampleModel
{
        protected $db;

        public function __construct(){
             $this->db=  Zend_Registry::get('db');
        }
        public function getAlbum(){

            $sql = 'SELECT * FROM album';
            return $result = $this->db->fetchAll($sql);
        }
	
        public function addAlbum($data)
        {     
            unset($data['submit']);
              unset($data['albumid']);
            $this->db->insert('album', $data);
        }
        public function checkLogin($data)
        {
        
           $count = $this->db->fetchOne("SELECT COUNT(*) AS count FROM users where username='".$data['username']."'"
                   . " and password='".$data['password']."'");
           return $count;
        }
        
        public function editAlbum($id)
        {
            $sql = "SELECT * FROM album WHERE id = ?";
            $result = $this->db->fetchAll($sql, $id);
            return $result[0];
        }
        public function updateAlbum($data)
        { 
            $editid=$data['albumid'];
            unset($data['submit']);
            unset($data['albumid']);
            $this->db->update('album', $data, "id = $editid");
           //$this->db->getProfiler()->setEnabled(true);
         // print_r($db->getProfiler()->getLastQueryProfile()->getQueryParams());
        }
        
        public function deleteAlbum($id)
        {   
            $where['id = ?']  = $id;
            $n = $this->db->delete('album', $where);
            
        }
        public function getEntries()
        {
             $sql = 'SELECT * FROM album';
            return $result = $this->db->fetchAll($sql);
        }
        public function _readAll($searchstring){
          // return $adapter = new Zend_Paginator_Adapter_DbSelect($this->db->select()->from('album'));
             $query = '%'.$searchstring.'%';
            if(!empty($searchstring))
             return $adapter = $this->db->select()->from('album')->where('artist like ?', $query);
            else
               return $adapter = $this->db->select()->from('album');   
             
            
           
        }
}
