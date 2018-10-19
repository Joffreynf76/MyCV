<?php

class loginWidget extends WP_Widget {

    public function __construct(){
        $options = array(
            'classname' => 'loginwidget',
            'description' => 'Affichage du formulaire de connexion'
        );

        parent::__construct('loginwidget', 'Connexion', $options);
    }


    public function widget($args, $instance){

        echo $args['before_widget'];
        echo $args['before_title'];
        echo apply_filters('widget_title', $instance['title']);
        echo $args['after_title'];

        if($_SESSION['login']==1){
            echo '<form method=post action="">

            <input type="submit" name="logout" value="Déconnexion">
            <input type="submit" name="unsubscribe" value="Désinscription"></form>';

            if(isset($_POST['unsubscribe'])){
                global $wpdb;
                $email=$_SESSION['email'];
                $wpdb->delete($wpdb->prefix.'user',[ 'email' => $email ],
                   [ '%s' ] );
                   session_destroy();

                   ?>
                   <SCRIPT LANGUAGE="JavaScript">
                       document.location.href="http://localhost:8888/projet1/wordpress/"
                   </SCRIPT>
           <?php

            }


        }else {
        ?>
        <form method="post" action="">
                <label for="email">Email :</label><input type="email" name="emailLog" required>
                <label for="password">Mot de passe :</label><input type="password" name="passwordLog" required>
                <input type="submit" value="Connexion" name="login">
        </form>

        <?php
    }
        if(isset($_POST['logout'])){
            session_destroy();



        ?>
        <SCRIPT LANGUAGE="JavaScript">
            document.location.href="http://localhost:8888/projet1/wordpress/"
        </SCRIPT>
<?php
}

        echo $args['after_widget'];
    }
}





 ?>
