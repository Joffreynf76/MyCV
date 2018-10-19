<?php

class UpdateAchievementsWidget extends WP_Widget {

    public function __construct(){

        add_action('wp_loaded',array($this,'register_param'));
        $options = array(
            'classname' => 'updatewidget',
            'description' => 'Affichage du formulaire de modification'
        );

        parent::__construct('updatewidget', 'Modification', $options);
    }

    function register_param() {
        global $wp;
        $wp->add_query_var('id');
    }

    public function widget($args, $instance){

        echo $args['before_widget'];
        echo $args['before_title'];
        echo apply_filters('widget_title', $instance['title']);
        echo $args['after_title'];

        if($_SESSION['login']==1){
            global $wpdb;
            $id1= get_query_var('id');
            $requete="SELECT * FROM ".$wpdb->prefix."achievements WHERE ID='$id1'";
            $achievement2 = $wpdb->get_results($requete);
            foreach($achievement2 as $achievements2){

                ?>
                <form method="post" action="">
                    <label for="description">Description :</label><input type="text" value="<?php echo($achievements2->description); ?>" name="description">
                    <label for="url">Url :</label><input type="text" value="<?php echo($achievements2->url); ?>" name="url">
                    <label for="begin">Début :</label><input type="text" value="<?php echo($achievements2->begin); ?>" name="begin">
                    <label for="end">Fin :</label><input type="text" value="<?php echo($achievements2->end); ?>" name="end">
                    <label for="role">Role :</label><input type="text" value="<?php echo($achievements2->role); ?>" name="role">
                    <label for="picture">Image :</label>
                    <select id="picture" name="picture">
                        <?php
                            global $wpdb;
                            $resultvisual2 = $wpdb->get_results("SELECT * FROM wp_visual");
                            ?>
                            <?php foreach( $resultvisual2 as $resultsvisual2 ){
                                echo "<option value='" . $resultsvisual2->ID . "'>" . $resultsvisual2->picture . "</option>";
                            }
                            ?>
                    </select>

                    <input type="submit" name="modify" value="Modifier" />
                    <input type="submit" name="delete" value="Supprimer" />
                </form>
<?php
            }

            if(isset($_POST['modify'])){
                global $wpdb;
                $wpdb->update('wp_achievements',['description'=> $_POST['description'],'url'=>$_POST['url'],'begin'=>$_POST['begin'],'end'=>$_POST['end'],'role'=>$_POST['role'],'visual_ID'=>$_POST['picture']],['ID'=>$id1]);

                ?>
                <SCRIPT LANGUAGE="JavaScript">
                    document.location.href="http://localhost:8888/projet1/wordpress/portfolio"
                </SCRIPT>
        <?php
            }

            if(isset($_POST['delete'])){
                global $wpdb;
                $wpdb->delete($wpdb->prefix.'achievements',[ 'ID' => $id1 ] );


                   ?>
                   <SCRIPT LANGUAGE="JavaScript">
                       document.location.href="http://localhost:8888/projet1/wordpress/portfolio"
                   </SCRIPT>
           <?php
            }



        }else {
            echo("Veuillez vous connecter");

    }


        echo $args['after_widget'];
    }
}





 ?>
