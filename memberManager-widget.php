<?php

class UsersManagerWidget extends WP_Widget {

    public function __construct(){
        $options = array(
            'classname' => 'usersmanagerwidget',
            'description' => 'Affichage du formulaire d\'inscription'
        );

        parent::__construct('usersmanagerwidget', 'Inscription', $options);
    }


    public function widget($args, $instance){

        echo $args['before_widget'];
        echo $args['before_title'];
        echo apply_filters('widget_title', $instance['title']);
        echo $args['after_title'];

        if(isset($_SESSION['login'])){
            echo("Déjà inscrit");
        } else {
        ?>
        <form method="post" action="">
                <label for="name">Nom :</label><input type="text" name="name" required>
                <label for="firstName">Prénom :</label><input type="text" name="firstName" required>
                <label for="email">Email :</label><input type="email" name="email" required>
                <label for="birthday">Date de naissance</label><input type="date" name="birthday" required>
                <label for="password">Mot de passe</label><input type="password" name="password" required>
                <input type="submit" value="S'inscrire">
                </form>
        <?php
    }
        echo $args['after_widget'];
    }
}





 ?>
