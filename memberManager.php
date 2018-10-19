<?php
/*
Plugin Name: Users Manager
Description: espace membre
Version: 1.0.0
Author: Moi
*/

class UsersManagerPlugin {

    public function __construct(){

        require_once(plugin_dir_path(__FILE__).'/memberManager-widget.php');
        require_once(plugin_dir_path(__FILE__).'/login-widget.php');
        add_action ('wp_loaded',array($this,'addNewUser'));
        add_action ('wp_loaded',array($this,'logIn' ));
        add_action ('widgets_init',function(){
            register_widget('UsersManagerWidget');

        });
        add_action ('widgets_init',function(){
            register_widget('loginWidget');
        });



        add_shortcode('register_form', array($this, 'shortcodeAction'));
        add_shortcode('login_form',array($this,'shortcodeAction1'));
    }

    public static function pluginActivation(){
        global $wpdb;

        /*$wpdb->query('CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'user (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255),firstname VARCHAR(255),birthday DATE,email VARCHAR(255),password VARCHAR(255))');*/
    }

    public static function uninstall(){
        global $wpdb;
        $wpdb->query('DROP TABLE IF EXISTS '.$wpdb->prefix.'user');
    }


    public function addNewUser(){
        if(isset($_POST['email'])){
            if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                global $wpdb;

                $checkIfExist = $wpdb->get_var(
                    $wpdb->prepare(
                        'SELECT count(*) FROM '.$wpdb->prefix.'user WHERE email = %s', $_POST['email']
                    )
                );
                if($checkIfExist == 0){
                    $mdp = sha1($_POST['password']);
                    $wpdb->query($wpdb->prepare('INSERT INTO '.$wpdb->prefix.'user(name,firstname,picture,birthday,email,password) VALUES(%s,%s,%s,%s,%s,%s)',$_POST['name'],$_POST['firstName'],NULL,$_POST['birthday'],$_POST['email'],$mdp));
                    $this->displayMsg('Inscription réussi');
                    ?>
                    <SCRIPT LANGUAGE="JavaScript">
                        document.location.href="http://localhost:8888/projet1/wordpress/"
                    </SCRIPT>
            <?php

                } else {
                    $this->displayMsg('Email déja utilisé');

                }
            } else {
                $this->displayMsg('Email invalide');
            }
        }
    }

    public function logIn(){
        if(isset($_POST['login'])){
            $email = $_POST['emailLog'];
            $password = sha1($_POST['passwordLog']);

            global $wpdb;
            $result=$wpdb->query("SELECT * FROM ".$wpdb->prefix."user WHERE email='$email' AND password='$password'");
            $user = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."user WHERE email='$email' AND password='$password'");

            if($result == 1){

                $this->displayMsg('Connexion réussi');
                foreach ($user as $key => $users) {

                    $_SESSION['name']=$users->name;
                    $_SESSION['email']=$users->email;


                }




                $_SESSION['login']=1;
            } else {
                $this->displayMsg('Erreur');
            }
        }
    }

    public function displayMsg($msg){

        add_action('wp_enqueue_scripts',function() use ($msg){
            ?>
            <script>
            document.addEventListener('DOMContentLoaded', function(){
                alert('<?php echo $msg; ?>');
            });
            </script>
            <?php
        });
    }

    public function shortcodeAction(){
        the_widget('UsersManagerWidget');

    }

    public function shortcodeAction1(){
        the_widget('loginWidget');
    }
}



register_activation_hook(__FILE__, array('UsersManagerPlugin','pluginActivation'));
register_uninstall_hook(__FILE__, array('UsersManagerPlugin','uninstall'));

add_action( 'plugins_loaded', function(){
    new UsersManagerPlugin();
} );
