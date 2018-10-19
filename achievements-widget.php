<?php

class AchievementsWidget extends WP_Widget {

    public function __construct(){
        $options = array(
            'classname' => 'achievementswidget',
            'description' => 'Affichage du formulaire de réalisations'
        );

        parent::__construct('achievementswidget', 'Réalisations', $options);
    }


    public function widget($args, $instance){

        echo $args['before_widget'];
        echo $args['before_title'];
        echo apply_filters('widget_title', $instance['title']);
        echo $args['after_title'];

        if($_SESSION['login']==1){

        ?>

        <form method="post" action="">
                <label for="description">Description :</label><input type="text" name="description" required>
                <label for="url">Url :</label><input type="text" name="url" required>
                <label for="begin">Début :</label><input type="text" name="begin" required>
                <label for="end">Fin :</label><input type="text" name="end" required>
                <label for="role">Role :</label><input type="text" name="role" required>
                <label for="picture">Image :</label>
                <select id="picture" name="picture">
                    <?php
                        global $wpdb;
                        $resultvisual = $wpdb->get_results('SELECT * FROM '. $wpdb->prefix . 'visual');
                        ?>
                        <?php foreach( $resultvisual as $resultsvisual ){
                            echo "<option value='" . $resultsvisual->ID . "'>" . $resultsvisual->picture . "</option>";
                        }
                        ?>
                </select>
                <input type="submit" value="Ajouter" name="create">
        </form>

        <form method="post" action="" enctype="multipart/form-data">
            <label for="file">Image :</label><input type="file" name="file" required />
            <input type="submit" value="Ajouter" name="upload">
        </form>


        <h1>Mes réalisations</h1>
        <?php
        global $wpdb;
        $achievement = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'achievements');

        $upload_dir = wp_upload_dir();
        foreach($achievement as $achievements){

            $sql = "SELECT picture FROM wp_visual WHERE wp_visual.ID= $achievements->visual_ID";
            $visual = $wpdb->get_results($sql);
            echo "<div class='portfolio'>
                <h4>".$achievements->description."</h4>
                <p>".$achievements->url.

                "</p>
                <p>
                Début : ".$achievements->begin."
                </p>
                <p>
                Fin : ".$achievements->end."
                </p>
                <p>
                Rôle : ".$achievements->role."
                </p>";

                foreach($visual as $visuals){

                    echo ("<img src='".$upload_dir['baseurl']."/2018/".$visuals->picture."' />
                           <a href='modifier/?id=".$achievements->ID."'>Modifier</a>
                    </div><hr />");

                }


        }









        }else {
            echo('Veuillez vous connecter pour ajouter une réalisation');
            ?>
            <h1>Mes réalisations</h1>
            <?php
            global $wpdb;
            $achievement = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'achievements');

            $upload_dir = wp_upload_dir();
            foreach($achievement as $achievements){
                $sql = "SELECT picture FROM wp_visual WHERE wp_visual.ID= $achievements->visual_ID";
                $visual = $wpdb->get_results($sql);
                echo "<div class='portfolio'>
                    <h4>".$achievements->description."</h4>
                    <p>".$achievements->url.

                    "</p>
                    <p>
                    Début : ".$achievements->begin."
                    </p>
                    <p>
                    Fin : ".$achievements->end."
                    </p>
                    <p>
                    Rôle : ".$achievements->role."
                    </p>";

                    foreach($visual as $visuals){

                        echo ("<img src='".$upload_dir['baseurl']."/2018/".$visuals->picture."' /></div>");

                    }


            }


    }


        echo $args['after_widget'];
    }
}





 ?>
