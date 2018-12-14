<?php
    use Dplus\Ecomm\Pages\ItemGroupPages;
    use Dplus\Ecomm\Pages\ItemMasterItemPages;

    header('Content-Type: application/json');
    $itemgroups = new ItemGroupPages();
    $items = new ItemMasterItemPages;

    if ($input->get->text('key') == $config->updatekey) {
        $results = array(
            'item-groups' => $itemgroups->import_all(),
            'items'       => $items->import_all(),
            'users'       => import_logmintoprocesswire()
        );
    } else {
        $results = array(
            'error' => "You don't have permission for this function"
        );
    }

    echo json_encode($results);
