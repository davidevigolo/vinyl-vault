<?php

function check_user_has_in_collection($user_id,$disk_id,$edition_name){
    $connection = DbConnection::get_instance();
    $query = "SELECT COUNT(*) as count FROM ownership WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $disk_id, $edition_name);
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        return false;
    }
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['count'] > 0;
}

function check_user_has_in_wishlist($user_id,$disk_id,$edition_name){
    $connection = DbConnection::get_instance();
    $query = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $disk_id, $edition_name);
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        return false;
    }
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['count'] > 0;
}

function album_actions($user_id,$disk_id,$edition_name){
    ob_start();

    if($user_id){
        $in_collection = check_user_has_in_collection($user_id,$disk_id,$edition_name);
        $in_wishlist = check_user_has_in_wishlist($user_id,$disk_id,$edition_name);
        $action_collection = '<p class="alert-add-vinyl">Il disco è nella tua collezione.</p>';
        $action_wishlist = '<p class="alert-add-vinyl">Il disco è nella tua lista dei desideri.</p>';
        if(!$in_collection){
            $action_collection = Template::render('static/layout/album/album_action_add_collection.html',[
                'disk_id' => htmlspecialchars($disk_id),
                'album_edition' => htmlspecialchars($edition_name)
            ]);
        }
        if(!$in_wishlist){
            $action_wishlist = Template::render('static/layout/album/album_action_add_wishlist.html',[
                'disk_id' => htmlspecialchars($disk_id),
                'album_edition' => htmlspecialchars($edition_name)
            ]);
        }
        if($in_collection){
            $action_wishlist = '';
        }
        echo Template::render('static/layout/album/album_actions.html',[
            'album_action_add_collection' => $action_collection,
            'album_action_add_wishlist' => $action_wishlist
        ],$action_collection,$action_wishlist);
    }else{
        echo '<p class="alert-add-vinyl">Effettua il <a href="login.php">login</a> per aggiungere questo album alla tua collezione o alla lista dei desideri.</p>';
    }
    return ob_get_clean();
}