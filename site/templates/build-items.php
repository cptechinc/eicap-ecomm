<?php 
    header('Content-Type: application/json');
    $results = array(
        'item-groups' => ItemGroup::import_itemgroups(),
        'items' => ItemMasterItem::import_items()
    );
    echo json_encode($results);
