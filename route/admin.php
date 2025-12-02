<?php
// session_start();
require_once('../config/Database.php');
require_once('../../controller/controllers.php');



$page = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
// $genre = new AdminGenreController();

// Routes for admin panel

switch ($page){
    case 'dashboard' : include "../Page/admin/admin-page/index.php"; break;
    case 'genre' : {  
        switch ($action) {
            case 'delete' : 
                $genre->delete($_GET['id']); break;
            case 'edit' : 
                $genre->edit($_GET['id']);
                break;
        }  
        $genre->index();
        $genre->read_all();   
      
       
        // if($_POST) $genre->create();
    }
}