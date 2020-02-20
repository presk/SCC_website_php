
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/user.controller.php');?>
<?php require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/Controllers/user_management.controller.php');?>
<?php require_once './header.php' ?>
<title>User Management</title>
<body>

<?php require_once './navbartop.php' ?>
<section class="section">
<?php
    $user_array = getAllUsers();
    if(empty($user_array)){
        echo "No members in group.";
    }else{
        echo "
                <table class='table' >
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Auth</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Street#</th>
                            <th>Apt#</th>
                            <th>Street</th>
                            <th>City</th>
                            <th>Bday</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <form action='' method='POST'>
                ";
        foreach($user_array as $user){
            echo 
            "<tr>
                <td><input type='text' size='10' name=".$user->getID()."[user_name]' value={$user->getUserName()}></td>
                <td><input type='text' size='20' name=".$user->getID()."[email]]' value={$user->getUserEmail()}></td>
                <td><input type='text' size='1' name=".$user->getID()."[roleID]]' value={$user->getRoleID()}></td>
                <td><input type='text' size='7' name=".$user->getID()."[first_name]]' value={$user->getUserFirstName()}></td>
                <td><input type='text' size='10' name=".$user->getID()."[last_name]]' value={$user->getUserLastName()}></td>
                <td><input type='text' size='7' name=".$user->getID()."[street_number]]' value={$user->getAddrNumber()}></td>    
                <td><input type='text' size='1' name=".$user->getID()."[apt_number]]' value={$user->getAptNumber()}></td>  
                <td><input type='text' size='10' name=".$user->getID()."[street_name]]' value={$user->getStreet()}></td>     
                <td><input type='text' size='10' name=".$user->getID()."[city]]' value={$user->getCity()}></td>
                <td><input type='text' size='7' name=".$user->getID()."[bday]]' value={$user->getUserBday()}></td>
                <td><button type=\"submit\" class=\"button\" name=\"save\" value=\"{$user->getId()}\">Save</button></td>
                <td><button type=\"submit\" class=\"button\" name=\"delete\" value=\"{$user->getId()}\">Delete</button></td>
            </tr>";
    }
    
    echo "
    </form>
    </tbody>
    </table>
    ";
    
}
?>

    <a class="button" href="create_user.php">Create New User</a>
</section>
</body>
<?php require_once './footer.php' ?>