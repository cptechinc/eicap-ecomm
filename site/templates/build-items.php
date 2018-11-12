<?php 
    use Dplus\Ecomm\Pages\ItemGroupPages;
    use Dplus\Ecomm\Pages\ItemMasterItemPages;
    
    header('Content-Type: application/json');
    $itemgroups = new ItemGroupPages();
    $items = new ItemMasterItemPages;
    
    $results = array(
        'item-groups' => $itemgroups->import_all(),
        'items'       => $items->import_all(),
        'users'       => import_logmintoprocesswire()
    );
    echo json_encode($results);
