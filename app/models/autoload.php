<?php

// auxiliary classes of the core
require_once 'core/Form/FormBaseInterface.php';
require_once 'core/Form/FormBase.php';
require_once 'core/Form/FormListTypeInterface.php';
require_once 'core/Form/FormSearchTypeInterface.php';
require_once 'core/Form/FormListBase.php';
require_once 'core/Form/FormWidget.php';
require_once 'core/Validate.php';
require_once 'core/Sanitize.php';
require_once 'core/Paginate.php';
require_once 'core/BindableInterface.php';
require_once 'core/BaseModel.php';
require_once 'core/SluggableInterface.php';
require_once 'core/ValidableInterface.php';
require_once 'core/Pagination/PaginableInterface.php';
require_once 'core/Pagination/Paginable.php';
require_once 'core/Pagination/PaginationRenderInterface.php';
require_once 'core/Pagination/PaginationRender.php';
require_once 'core/Pagination/PaginatorViewExtension.php';
require_once 'core/Search/SearchQueryBuilderInterface.php';
require_once 'core/Search/SearchQueryBuilder.php';

// models and FormTypes from app
require_once 'Entity/Entity.php';
require_once 'Article/Article.php';
require_once 'Article/ArticleFormType.php';
require_once 'Contact/Contact.php';
require_once 'Contact/ContactFormType.php';
require_once 'Staticpage/Staticpage.php';
require_once 'Staticpage/StaticpageFormType.php';
require_once 'User/User.php';
