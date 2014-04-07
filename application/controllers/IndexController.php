<?php

class IndexController extends Zend_Controller_Action {

    protected $smodel;

    public function init() {
        /* Initialize action controller here */
        //$messages = $this->_helper->flashMessenger->getMessages();
        $this->smodel = new Application_Model_SampleModel();
    }

    public function indexAction() {
        // action body
        //$this->_helper->layout->setLayout('layout');
        $this->view->messages = $this->_helper->FlashMessenger->getMessages('success');
        $album = $this->smodel->getAlbum();
        $this->view->albumDetails = $album;
        // echo var_dump($album);
    }

    public function editAction() {
        $edit_id = $this->getRequest()->getParam('id');
        $edi_val = $this->smodel->editAlbum($edit_id);
        //print_r($edi_val);
        $album = new Application_Form_Album();
        $album->populate(array('albumid' => $edi_val['id'],
            'artist' => $edi_val['artist'],
            'title' => $edi_val['title']));

        if ($this->getRequest()->isPost()) {
            $postdata = $this->getRequest()->getPost();

            if ($album->isValid($postdata)) {
                $this->smodel->updateAlbum($postdata);
                $this->_helper->FlashMessenger->addMessage("Updated Successfully", "success");
                $this->_helper->redirector('index', 'index', array('id' => '1'));
            } else {
                echo "error";
            }
        }
        $this->view->form = $album;
    }

    public function addAction() {
        $album = new Application_Form_Album();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($album->isValid($data)) {
                //$smodel = new Application_Model_SampleModel($this->_db);
                $this->smodel->addAlbum($data);
                echo "ok";
            } else {
                echo "failed";
            }
        }

        $this->view->form = $album;
    }

    public function deleteAction() {
        $delid = $this->getRequest()->getParam('id');
        $this->smodel->deleteAlbum($delid);
        $this->_helper->FlashMessenger->addMessage("Deleted Successfully", "success");
        $this->_helper->redirector('index', 'index', array('id' => '1'));
    }

    public function loginAction() {
        $auth_obj = Zend_Auth::getInstance('user');
        if ($auth_obj->hasIdentity()) {
            $this->_redirect('index/home');
        }
        // echo "hi";
        $form_login = new Application_Form_Login();
        //var_dump($form_login);
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($form_login->isValid($data)) {

                //$login=$this->smodel->checkLogin($data);

                $zf_auth = new Zend_Auth_Adapter_DbTable();
                $zf_auth->setTableName('users')
                        ->setIdentityColumn('username')
                        ->setCredentialColumn('password')
                        ->setIdentity($data['username'])
                        ->setCredential($data['password']);

                //$auth = $zf_auth->authenticate();
                $result = $auth_obj->authenticate($zf_auth);

                if ($result->isValid()) {
                    $sess_obj = new Zend_Auth_Storage_Session();
                    $sess_obj->write($zf_auth->getResultRowObject(null, 'password'));
                    $this->_redirect('index/home');
                } else {
                    var_dump($result->getMessages());
                    echo $code = $result->getCode();
                    if ($code == Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID) {
                        echo "Invalid password";
                    }
                    if ($code == Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS) {
                        echo "NO username in db";
                    }
                    if ($code == Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND) {
                        echo "Invalid password1";
                    }
                }
            }
        }
        $this->view->form = $form_login;
    }

    public function homeAction() {
        echo "home";
        var_dump(Zend_Auth::getInstance()->getIdentity());

        $excel = new Excel_Export();
        var_dump($excel);
        exit;
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index/index');
    }

    public function viewAction() {
        
            $searchform = new Application_Form_Search();
            $page = $this->_getParam('page',1);
            if($this->getRequest()->isPost())
            {
              $postdata = $this->getRequest()->getPost();  
              $searchstring = $postdata['search'];
            }
            else
            {
                $searchstring='';
            }
            $data = $this->smodel->_readAll($searchstring); // call Method
            $paginator = Zend_Paginator::factory($data);
            $paginator->setItemCountPerPage(5);
            $paginator->setCurrentPageNumber($page);
            $this->view->paginator = $paginator;
            $this->view->form = $searchform;
    }
    
   

}
