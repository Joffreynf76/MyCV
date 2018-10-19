<?php
/*
Plugin Name: plugin réalisations
Plugin URI: https://nfactory.school/
Description: Création réalisations
Author: Joffrey
Version: 0.1
Author URI: https://nfactory.school/
*/

class AchievementsPlugin {

    public function __construct(){

        require_once(plugin_dir_path(__FILE__).'/achievements-widget.php');
        require_once(plugin_dir_path(__FILE__).'/updateAchievements-widget.php');
        add_action ('wp_loaded',array($this,'addAchievements'));
        add_action ('wp_loaded',array($this,'addPicture'));
        add_action ('widgets_init',function(){
            register_widget('AchievementsWidget');

        });
        add_action('widgets_init',function(){
            register_widget('UpdateAchievementsWidget');
        });


        add_shortcode('achievements', array($this, 'shortcodeAction'));
        add_shortcode('update',array($this,'shortcodeAction2' ));
    }




    public static function uninstall(){
        global $wpdb;
        $wpdb->query('DROP TABLE IF EXISTS '.$wpdb->prefix.'achievements');
    }

    public function addAchievements(){
        if(isset($_POST['create'])){
            global $wpdb;
            $wpdb->query($wpdb->prepare('INSERT INTO '.$wpdb->prefix.'achievements(description,url,begin,end,role,visual_ID) VALUES(%s,%s,%s,%s,%s,%d)',$_POST['description'],$_POST['url'],$_POST['begin'],$_POST['end'],$_POST['role'],$_POST['picture']));
            $this->displayMsg('Réalisation ajoutée');
        }
    }




    public function addPicture(){
        if(isset($_POST['upload'])){
            $dossier = 'wp-content/uploads/2018/';
            $fichier = basename($_FILES['file']['name']);
            if(move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $fichier))
            {
                global $wpdb;
                $wpdb->query($wpdb->prepare('INSERT INTO '.$wpdb->prefix.'visual(picture) VALUES(%s)',$_FILES['file']['name']));
                echo 'Upload effectué avec succès !';
            }
            else
            {
                echo 'Echec de l\'upload !';
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
        the_widget('AchievementsWidget');

    }

    public function shortcodeAction2(){
        the_widget('UpdateAchievementsWidget');

    }



}





register_uninstall_hook(__FILE__, array('AchievementsPlugin','uninstall'));

add_action('plugins_loaded',function(){
    new AchievementsPlugin();
});
