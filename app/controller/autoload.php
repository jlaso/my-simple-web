<?php

    // frontend routes
    require_once __DIR__."/frontend/home.php";
    require_once __DIR__."/frontend/articles.php";
    require_once __DIR__."/frontend/contact.php";
    require_once __DIR__.'/frontend/login.php';
    require_once __DIR__.'/frontend/entity.php';

    // backend routes
    require_once __DIR__."/backend/admin.php";
    require_once __DIR__."/backend/CRUD/list-entity.php";
    require_once __DIR__."/backend/CRUD/edit-entity.php";
    require_once __DIR__."/backend/CRUD/new-entity.php";
    require_once __DIR__."/backend/crud.php";
